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
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Exceptions\UnauthorizedException;
use Spatie\QueryBuilder\AllowedFilter;

class RecipientService
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
		$data['code'] = strtoupper(Str::random(12));

		$recipient = Recipient::create($data);

		Log::info('created recipient', ['recipient_id' => $recipient->id]);

		return $recipient;
	}

	public function delete($id): void
	{
		$user = Auth::user();
		$recipient = $this->getRequestedRecipient($id);

		if ($recipient->org_id !== $user->orgMember->org_id) {
			throw new UnauthorizedException();
		}

		$recipient->delete();

		Log::info('deleted recipient', ['recipient_id' => $id]);
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
