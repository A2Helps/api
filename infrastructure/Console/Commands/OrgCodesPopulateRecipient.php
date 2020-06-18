<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Orgs\OrgFacade;
use Api\Recipients\Models\Recipient;
use Illuminate\Console\Command;

class OrgCodesPopulateRecipient extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'org:codes:populate_recipient
		{--o|org= : The ID of the Org}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Populate codes with recipients';

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
		$orgId = $this->option('org');
		$org = AdminOrgFacade::getById($orgId);

		$org->codes->each(function($code) use ($org) {
			if ($code->used || $code->claimed || $code->sent) {
				return;
			}

			$r = Recipient::where('org_id', $org->id)
				->whereNull('code_id')
				->inRandomOrder()
				->first();

			if (empty($r)) {
				return;
			}

			$r->phone = null;
			$r->code_id = $code->id;

			$code->recipient_id = $r->id;
			$code->phone = null;
			$code->email = $r->email;
			$code->name = sprintf('%s %s', $r->name_first, $r->name_last);

			$code->save();
			$r->save();

			$this->comment(sprintf('populated %s with recipient %s', $code->id, $r->id));
		});
	}
}
