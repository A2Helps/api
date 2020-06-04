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

class BatchFinalize extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'batch:finalize';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Finalize Batches';

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

		$batches = Batch::where('completed', true)->where('finalized', false)->get();

		$batches->each(function($b) {
			$b->batchItems->each(function($bi) use (&$b) {
				if (empty($bi->number)) {
					throw new \Exception('batch_item empty number');
				}

				$card = Card::create([
					'merchant_id'   => $b->merchant_id,
					'amount'        => $b->amount,
					'number'        => $bi->number,
					'assigned'      => true,
					'order_card_id' => $bi->order_card_id,
					'recipient_id'  => $bi->orderCard->recipient_id,
				]);

				$bi->card_id = $card->id;
				$bi->save();

				$bi->orderCard->card_id = $card->id;
				$bi->orderCard->save();

				$b->finalized = true;
				$b->save();
			});
		});

		DB::commit();
	}
}
