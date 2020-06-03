<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Codes\Jobs\DistributeCodeJob;
use Api\Codes\Models\Code;
use Api\Orgs\OrgFacade;
use Api\Recipients\Models\Recipient;
use Illuminate\Console\Command;

class CodeDistribute extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'code:distribute';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Distribute Codes';

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
		$codes = Code::where('distributed', false)->whereNotNull('recipient_id')->get();

		$codes->each(function($c) {
			DistributeCodeJob::dispatch($c);

			$this->comment(sprintf('queued distribution of %s', $c->id));
		});
	}
}
