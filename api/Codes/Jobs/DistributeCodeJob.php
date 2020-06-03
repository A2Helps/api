<?php

namespace Api\Codes\Jobs;

use Api\Codes\Mailers\DistributeCode;
use Api\Codes\Models\Code;
use Api\Donations\Mailers\Confirmation;
use Api\Donations\Models\Donation;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Facades\Mail;
use Infrastructure\Jobs\QueuedJob;

class DistributeCodeJob extends QueuedJob
{
	protected $code;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Code $code)
	{
		$this->code = $code;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$lc = new LogContext(['code_id' => $this->code->id]);
		$lc->info('distributing code');

		if (empty($this->code->recipient->email)) {
			$lc->warning('no code recipient email associated');

			return;
		}

		$mailable = new DistributeCode(
			$this->code,
		);

		Mail::to($this->code->recipient->email)
			->send($mailable);

		$this->code->sent = true;
		$this->code->distributed = true;
		$this->code->save();
	}
}
