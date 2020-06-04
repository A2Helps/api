<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Batches\Models\Batch;
use Api\BatchItems\Models\BatchItem;
use Api\Cards\Models\Card;
use Api\Codes\Jobs\DistributeCodeJob;
use Api\Codes\Models\Code;
use Api\Orders\Models\Order;
use Api\Orgs\OrgFacade;
use Api\Recipients\Models\Recipient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OrderFinalize extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'order:finalize';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Finalize Orders';

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

		$orders = Order::where('batched', true)->where('finalized', false)->get();

		$orders->each(function($o) {
			$unfinalized = $o->orderCards->find(fn($oc) => ! empty($oc->card_id));

			if ($unfinalized) {
				$this->comment(sprintf('Order is not fulfilled: %s', $o->id));
				return;
			}

			$o->finalized = true;
			$o->save();
		});

		DB::commit();
	}
}
