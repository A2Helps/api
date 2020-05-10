<?php

namespace Api\Codes\Services;

use Admin\Merchants\AdminMerchantFacade;
use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Codes\Exceptions\CodeNotFoundException;
use Api\Codes\Models\Code;
use Api\Merchants\Exceptions\MerchantNotFoundException;
use Api\OrderCards\Models\OrderCard;
use Api\OrderCards\OrderCardFacade;
use Api\Orders\OrderFacade;
use Api\Recipients\Exceptions\RecipientNotFoundException;
use Api\Recipients\Models\Recipient;
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
		Log::info('attempting to verify code', ['code' => $code, 'phone' => $phone]);

		$c = $this->getByCode($code);
		$r = null;

		try {
			// check if we already have a recipient with this phone
			$r = RecipientFacade::getByPhone($phone);
		} catch (RecipientNotFoundException $e) {}

		// check if the code is claimed (has associated recipient)
		if ($c->claimed) {
			// if recipient is already created, and is user matching code, then verification passes
			if (! empty($r) && $r->id === $c->recipient_id) {
				return;
			}

			throw new UnauthorizedException(
				new Exception('verify.code.claimed')
			);
		}
		else if (! empty($r)) {
			throw new UnauthorizedException(
				new Exception('verify.recipient.duplicate')
			);
		}

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
				'phone'      => $phone,
				'user_id'    => $user->id,
				'name_first' => $n[0] ?? null,
				'name_last'  => $n[1] ?? null,
			]);

			$c->recipient_id = $r->id;
			$c->save();
		});
	}

	/**
	 * Redeem a code for merchant cards
	 *
	 * Currently, client sends a desired amount which is
	 * a multiple of the lowest (min) amount a merchant supports.
	 */
	public function redeem(string $code, array $merchants): void
	{
		$u = $this->auth->user();
		$lc = new LogContext(['code' => $code]);

		$merchants = collect($merchants);

		$lc->debug('processing redemption intent');
		$c = $this->getByCode($code);

		// ensure code is claimed
		if (empty($c->recipient_id)) {
			throw new UnauthorizedException(
				new Exception('code not claimed')
			);
		}

		if ($c->redeemed) {
			throw new UnauthorizedException(
				new Exception('code already redeemed')
			);
		}

		// find recipient
		$r = $u->recipients->first(function($x) use ($c) {
			return $x->id === $c->recipient_id;
		});

		if (empty($r)) {
			throw new UnauthorizedException(
				new Exception('non-owner')
			);
		}

		$this->processRedemption($c, $r, $merchants);
	}

	public function processRedemption(Code $c, Recipient $r, Collection $merchants): void
	{
		$items = collect([]);

		// validate merchants and generate order items
		$merchants->each(function($req) use (&$items, $r) {
			$m = AdminMerchantFacade::getById($req['id']);

			if (! $m->active) {
				throw new Exception('merchant is not active');
			}

			$amount = (int) $req['amount'];

			if ($m->custom_amount) {
				$items->push([
					'recipient_id' => $r->id,
					'amount'       => $amount,
					'merchant_id'  => $m->id,
				]);

				return;
			}

			// merchant does not support custom amounts,
			// so we need to ensure we can fulfill desired amount

			// get the lowest amount
			$mAmounts = collect($m->amounts);
			$min = (int) $mAmounts->min();

			// ensure amount is a multiple of min
			if ($amount % $min !== 0) {
				throw new Exception('Amount is not a multiple of min');
			}

			// attempt to optimize
			$optimized = (int) $mAmounts->sortDesc()->first(function($a) use ($amount) {
				if ($amount % $a === 0) {
					return true;
				}
			});

			if (empty($optimized)) {
				$optimized = $min;
			}

			$qty = $amount / $optimized;

			for ($i = 0; $i < $qty; $i++) {
				$items->push([
					'recipient_id' => $r->id,
					'amount'       => $optimized,
					'merchant_id'  => $m->id,
				]);
			}
		});

		// Arrow functions!!!! :D
		$sum = $items->reduce(fn($c, $i) => $c += $i['amount']) * 100;

		if ($sum > config('a2helps.budget')) {
			throw new Exception('Over budget');
		}

		$order = null;
		DB::transaction(function () use ($c, $r, $items, &$order, $sum) {
			$order = OrderFacade::create([
				'code_id'      => $c->id,
				'recipient_id' => $r->id,
				'user_id'      => $r->user_id,
				'amount'       => $sum,
			]);

			$items->each(function($i) use ($order) {
				OrderCardFacade::create([
					'order_id'     => $order->id,
					'recipient_id' => $order->recipient_id,
					'merchant_id'  => $i['merchant_id'],
					'amount'       => $i['amount'] * 100,
				]);
			});

			// should use service here
			$c->redeemed = true;
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
