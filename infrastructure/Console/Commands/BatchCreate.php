<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Batches\Models\Batch;
use Api\BatchItems\Models\BatchItem;
use Api\Codes\Jobs\DistributeCodeJob;
use Api\Codes\Models\Code;
use Api\Orders\Models\Order;
use Api\Orgs\OrgFacade;
use Api\Recipients\Models\Recipient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BatchCreate extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'batch:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create Batches';

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

		$orders = Order::where('batched', false)->get();

		$merchants = [];
		$orders->each(function($o) use (&$merchants) {
			$o->orderCards->each(function($oc) use (&$merchants) {
				if (!array_key_exists($oc->merchant_id, $merchants)) {
					$merchants[$oc->merchant_id] = [];
				}

				$amount = (int) $oc->amount;
				if (!array_key_exists($amount, $merchants[$oc->merchant_id])) {
					$merchants[$oc->merchant_id][$amount] = [];
				}

				$merchants[$oc->merchant_id][$amount][] = $oc;
			});
		});

		foreach ($merchants as $merchantId => $merchant) {
			foreach ($merchant as $amount => $ma) {
				$c = collect($ma);

				foreach ($c->chunk(10) as $chunk) {

					$b = Batch::create([
						'merchant_id' => $merchantId,
						'amount'      => $amount,
						'quantity'    => count($chunk),
					]);

					foreach ($chunk as $oc) {
						$bi = BatchItem::create([
							'batch_id'      => $b->id,
							'order_card_id' => $oc->id,
						]);

						$oc->batch_item_id = $bi->id;
						$oc->save();
					}
				}
			}
		}

		$orders->each(function($o) {
			$o->batched = true;
			$o->save();
		});

		DB::commit();
	}
}
