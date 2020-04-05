<?php

namespace Api\Donations\Jobs;

use Api\Donations\Mailers\Confirmation;
use Api\Donations\Models\Donation;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Facades\Mail;
use Infrastructure\Jobs\QueuedJob;

class SendConfirmationJob extends QueuedJob
{
	protected $donation;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Donation $donation)
	{
		$this->donation = $donation;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$lc = new LogContext(['donation_id' => $this->donation->id]);
		$lc->info('sending donation confirmation');

		if (empty($this->donation->email)) {
			$lc->info('no donation email associated');

			return;
		}

		$mailable = new Confirmation(
			$this->donation,
		);

		Mail::to($this->donation->email)
			->send($mailable);
	}
}
