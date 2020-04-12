<?php

namespace Api\Codes\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Codes\Exceptions\CodeNotFoundException;
use Api\Codes\Models\Code;
use Api\Recipients\Exceptions\RecipientNotFoundException;
use Api\Recipients\RecipientFacade;
use Api\Recipients\Services\RecipientService;
use Api\Users\UserFacade;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Infrastructure\Exceptions\UnauthorizedException;
use Infrastructure\Services\BaseService;
use Kreait\Firebase\Exception\Auth\PhoneNumberExists;
use Spatie\QueryBuilder\AllowedFilter;

class CodeService extends BaseService
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
		Log::debug('fetching all codes');

		if (empty($user->orgMember)) {
			return collect([]);
		}

		return QueryBuilder::for(Code::where('org_id', $user->orgMember->org_id))
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

	public function getById(string $id): Code
	{
		$id = expand_uuid($id);
		$user = Auth::user();
		Log::debug('fetching code', ['code_id' => $id]);

		$query = Code::where('org_id', $user->orgMember->org_id)->where('id', $id);
		$code = QueryBuilder::for($query)->first();

		if (empty($code)) {
			throw new CodeNotFoundException();
		}

		return $code;
	}

	public function getByCode(string $code): Code
	{
		$code = Code::where('code', $code)->first();

		if (empty($code)) {
			throw new CodeNotFoundException();
		}

		return $code;
	}

	public function update(string $id, array $data): Code
	{
		$id = expand_uuid($id);
		$user = Auth::user();

		$lc = new LogContext(['code_id' => $id]);
		$lc->debug('received request to update code');

		$code = $this->getRequestedCode($id);

		$this->checkUserOrgPerm($code->org_id);

		// FIXME:
		// $data = Arr::only($data, ['email', 'phone']);
		// if (! empty($data['email'])) {
		// 	$data['email'] = strtolower($data['email']);
		// }

		$code->fill(Arr::only($data, ['printed', 'sent', 'name']));

		// if code is now used, attach orgMember
		if ($code->used && empty($code->org_member_id)) {
			$code->org_member_id = $user->orgMember->id;
		}

		// mark code distributed if it has been printed
		if ($code->printed && ! $code->distributed) {
			$code->distributed = true;
			$code->org_member_id = $user->orgMember->id;

			$lc->info('marking code distributed', [
				'printed' => true
			]);
		}

		$code->save();
		$lc->info('updated code');

		if ($code->sent && ! $code->distributed) {
			$lc->warning('TODO: this is where we DISTRIB CODE', ['sent' => true]);
			// DistributeCode::dispatch($code);
		}

		return $code;
	}

	public function bulkUpdate(array $ids, array $data): Collection
	{
		$data = Arr::only($data, ['sent', 'printed']);
		$codes = new Collection();

		DB::transaction(function() use ($ids, $data, &$codes) {
			foreach ($ids as $id) {
				$codes->push($this->update($id, $data));
			}
		});

		return $codes;
	}

	/**
	 * responses:
	 * 404 - code not found
	 * 401 - code.claimed | code is already claimed
	 * 401 - recipient.duplicate | recipient already has claimed a code
	 * @throws UnauthorizedException
	 */
	public function verify(string $code, string $phone): void
	{
		$c = $this->getByCode($code);

		// check if the code is claimed
		if ($c->claimed) {
			throw new UnauthorizedException(
				new Exception('verify.code.claimed')
			);
		}

		try {
			// check if we already have a recipient with this phone
			$r = RecipientFacade::getByPhone($phone);

			// if recipient is already created, but is user matching code then verification passes
			if ($r->id === $c->recipient_id) {
				return;
			}

			throw new UnauthorizedException(
				new Exception('verify.recipient.duplicate')
			);
		} catch (RecipientNotFoundException $e) {}

		DB::transaction(function() use ($c, $phone) {
			$n = explode(' ', $c->name, 1);

			try {
				$user = UserFacade::createRecipientUser([
					'phone'      => $phone,
					'name_first' => $n[0] ?? null,
					'name_last'  => $n[1] ?? null,
				]);
			} catch (PhoneNumberExists $e) {
				throw new UnauthorizedException(
					new Exception('veryify.recipient.exists')
				);
			}

			$r = RecipientFacade::create([
				'phone'   => $phone,
				'name'    => $c->name,
				'user_id' => $user->id,
			]);

			$c->recipient_id = $r->id;
			$c->save();
		});
	}

	private function getRequestedCode($id): Code
	{
		$id = expand_uuid($id);
		$code = Code::find($id);

		if (empty($code)) {
			throw new CodeNotFoundException();
		}

		return $code;
	}
}
