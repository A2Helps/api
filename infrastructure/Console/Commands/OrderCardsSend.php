<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Batches\Models\Batch;
use Api\BatchItems\Models\BatchItem;
use Api\Cards\Models\Card;
use Api\Codes\Jobs\DistributeCodeJob;
use Api\Codes\Models\Code;
use Api\Orders\Jobs\SendCards;
use Api\Orders\Models\Order;
use Api\Orgs\OrgFacade;
use Api\Recipients\Models\Recipient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OrderCardsSend extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'order:cards:send {count=-1}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send Order Cards';

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
		DB::beginTransaction();

		$orders = Order::where('finalized', true)->where('cards_sent', false)->get();

		$count = (int) $this->argument('count');
		$c = 0;

		$orders->each(function($o) use (&$count, &$c) {
			if ($count !== -1 && $c++ === $count) {
				return false;
			}

			SendCards::dispatch($o);
		});

		DB::commit();
	}
}
