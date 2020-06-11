<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Codes\Jobs\CodeReminderJob;
use Api\Codes\Models\Code;
use Api\Orgs\OrgFacade;
use Api\Recipients\Models\Recipient;
use Illuminate\Console\Command;

class CodeRemind extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'code:remind';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send Codes Reminders';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$codes = Code::where('distributed', true)->where('sent', true)->where('redeemed', false)->get();

		$codes->each(function($c) {
			if (empty($c->email)) {
				return;
			}

			CodeReminderJob::dispatch($c);

			$this->comment(sprintf('queued reminder for %s', $c->id));
		});
	}
}
