<?php

namespace Api\Recipients\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Recipients\Exceptions\RecipientNotFoundException;
use Api\Recipients\Models\Recipient;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Infrastructure\Exceptions\UnauthorizedException;
use Infrastructure\Services\BaseService;
use Spatie\QueryBuilder\AllowedFilter;

class RecipientService extends BaseService
{
	private $auth;

	private $database;

	private $dispatcher;

	public function __construct(
		AuthManager $auth,
		DatabaseManager $database,
		Dispatcher $dispatcher
	) {
		$this->auth = $auth;
		$this->database = $database;
		$this->dispatcher = $dispatcher;
	}

	public function getAll(): Collection
	{
		$user = Auth::user();
		Log::debug('fetching all recipients');

		return QueryBuilder::for(Recipient::where('org_id', $user->orgMember->org_id))
			->allowedFilters([
				'phone',
				'email',
				'sent',
				'printed',
				'distributed',
				AllowedFilter::scope('used'),
			])
			->get();
	}

	public function getById($id): Recipient
	{
		$id = expand_uuid($id);
		$user = Auth::user();
		Log::debug('fetching recipient', ['recipient_id' => $id]);

		$query = Recipient::where('org_id', $user->orgMember->org_id)->where('id', $id);
		$recipient = QueryBuilder::for($query)->first();

		if (empty($recipient)) {
			throw new RecipientNotFoundException();
		}

		return $recipient;
	}

	public function create($data): Recipient
	{
		$user = Auth::user();

		if (empty($user->orgMember)) {
			throw new \Exception('Org member not found');
		}

		$data = Arr::only($data, ['email', 'phone']);

		if (! empty($data['email'])) {
			$data['email'] = strtolower($data['email']);
		}

		$data['org_member_id'] = $user->orgMember->id;
		$data['org_id'] = $user->orgMember->org_id;

		// TODO:: check if code is in use
		$data['code'] = strtoupper(Str::random(8));

		$recipient = Recipient::create($data);

		Log::info('created recipient', ['recipient_id' => $recipient->id]);

		return $recipient;
	}

	public function update($id, array $data): Recipient
	{
		$id = expand_uuid($id);

		$lc = new LogContext(['recipient_id' => $id]);
		$lc->debug('received request to update recipient');

		$recipient = $this->getRequestedRecipient($id);

		$this->checkUserOrgPerm($recipient->org_id);

		$recipient->fill(Arr::only($data, ['printed', 'sent', 'name']));

		// mark recipient distributed if it has been printed
		if ($recipient->printed && ! $recipient->distributed) {
			$recipient->distributed = true;

			$lc->info('marking recipient distributed', [
				'printed' => true
			]);
		}

		$recipient->save();
		$lc->info('updated recipient');

		if ($recipient->sent && ! $recipient->distributed) {
			$lc->warning('TODO: this is where we DISTRIB RECIPIENT', ['sent' => true]);
			// DistributeRecipient::dispatch($recipient);
		}

		return $recipient;
	}

	public function bulkUpdate(array $ids, array $data): Collection
	{
		$data = Arr::only($data, ['sent', 'printed']);
		$recipients = new Collection();

		DB::transaction(function() use ($ids, $data, &$recipients) {
			foreach ($ids as $id) {
				$recipients->push($this->update($id, $data));
			}
		});

		return $recipients;
	}

	private function getRequestedRecipient($id): Recipient
	{
		$id = expand_uuid($id);
		$recipient = Recipient::find($id);

		if (empty($recipient)) {
			throw new RecipientNotFoundException();
		}

		return $recipient;
	}
}
