<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Users\Repositories\UserRepository;
use Api\Employers\Repositories\EmployerRepository;
use Api\EmployerUsers\Repositories\EmployerUserRepository;
use Api\Orgs\OrgFacade;
use Illuminate\Console\Command;

class OrgList extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'org:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Lists Orgs';

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
		$orgs = AdminOrgFacade::getAll()->map(function($x) {
			return [$x->id, $x->name, $x->allotment, $x->count_distributed, $x->enabled];
		});

		$headers = ['Id', 'Name', 'Allotment', 'Distributed', 'Enabled'];
		$this->table($headers, $orgs);
	}
}
