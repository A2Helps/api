<?php

namespace Api\Donations\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Donations\Exceptions\DonationNotFoundException;
use Api\Donations\Models\Donation;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Infrastructure\Exceptions\UnauthorizedException;
use Infrastructure\Stripe\StripeFacade;

class DonationService
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

	public function create($data): Donation
	{
		$data = Arr::only($data, ['amount']);

		$lc = new LogContext(['amount' => $data['amount']]);
		$lc->debug('creating donation');

		$donation = Donation::create($data);

		$lc->addContext(['donation_id' => $donation->id]);
		$lc->info('created donation');

		$session = StripeFacade::createCheckout($donation);

		$donation->co_session = $session->id;
		$donation->save();

		$lc->info('created stripe checkout session for donation', ['session_id' => $donation->co_session]);

		return $donation;
	}

	public function update($id, array $data): void
	{
		$donation = $this->getRequestedDonation($id);

		if ($donation->completed || $donation->canceled) {
			throw new UnauthorizedException();
		}

		if (!empty($data['canceled'])) {
			$donation->canceled = true;
		}
		else if (!empty($data['completed'])) {
			$donation->completed = true;
		}

		$donation->save();
		return;
	}

	public function donationCompleted(string $sessionId): Donation
	{
		$lc = new LogContext(['co_session' => $sessionId]);
		$donation = Donation::where('co_session', $sessionId)->first();

		if (empty($donation)) {
			$lc->warning('co_session was not found');
			throw new DonationNotFoundException();
		}

		$lc->info('donation completed', ['donation_id' => $donation->id]);

		$donation->completed = true;
		$donation->save();

		return $donation;
	}

	protected function getRequestedDonation($id): Donation
	{
		$id = expand_uuid($id);
		$donation = Donation::find($id);

		if (empty($donation)) {
			throw new DonationNotFoundException();
		}

		return $donation;
	}
}
