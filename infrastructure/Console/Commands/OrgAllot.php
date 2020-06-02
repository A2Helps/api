<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Users\Repositories\UserRepository;
use Api\Employers\Repositories\EmployerRepository;
use Api\EmployerUsers\Repositories\EmployerUserRepository;
use Api\Orgs\OrgFacade;
use Illuminate\Console\Command;

class OrgAllot extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'org:allot
		{--o|org= : The ID of the Org}
		{--a|amount= : The amount to allot}

	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Allot codes to an Org';

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
		$amount = (int) $this->option('amount');
		$orgId = $this->option('org');

		$org = AdminOrgFacade::getById($orgId);

		$allotment = $org->allotment + $amount;
		AdminOrgFacade::update($org->id, ['allotment' => $allotment]);

		$this->info('success');
	}
}
