<?php

namespace Infrastructure\Console\Commands;

use Admin\Orgs\AdminOrgFacade;
use Api\Users\Repositories\UserRepository;
use Api\Employers\Repositories\EmployerRepository;
use Api\EmployerUsers\Repositories\EmployerUserRepository;
use Api\Orgs\OrgFacade;
use Api\Recipients\Models\Recipient;
use Exception;
use Illuminate\Console\Command;

class RecipientLinkOrg extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'recipient:link_org
		{--o|org= : The ID of the Org}
		{--d|domain= : The email domain to assign}
	';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Link org to a recipient';

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
		$org = AdminOrgFacade::getById($this->option('org'));
		$domain = $this->option('domain');

		if (empty($domain)) {
			throw new Exception('Domain required');
		}

		$q = Recipient::whereNull('org_id');

		foreach ($q->cursor() as $r) {
			$e = strtolower(trim($r->email));
			if (empty($e)) {
				continue;
			}

			$sub = substr($e, strlen($e) - strlen($domain));
			if ($sub !== $domain) {
				continue;
			}

			// found match
			$r->email;
			$r->org_id = $org->id;
			$r->save();

			$this->line(sprintf('linked recipient | %s | %s', $r->id, $e));
		}
	}
}
