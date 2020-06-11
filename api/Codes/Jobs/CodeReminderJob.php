<?php

namespace Api\Codes\Jobs;

use Api\Codes\Mailers\CodeReminder;
use Api\Codes\Models\Code;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Facades\Mail;
use Infrastructure\Jobs\QueuedJob;

class CodeReminderJob extends QueuedJob
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
		$lc->info('sending code reminder');

		if ($this->code->redeemed) {
			$lc->warning('code already redeemed');

			return;
		}

		if (empty($this->code->recipient->email)) {
			$lc->warning('no code recipient email associated');

			return;
		}

		$mailable = new CodeReminder(
			$this->code,
		);

		Mail::to($this->code->recipient->email)
			->send($mailable);
	}
}
