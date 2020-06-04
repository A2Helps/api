<?php

namespace Infrastructure\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Infrastructure\Console\Commands\BatchCreate;
use Infrastructure\Console\Commands\BatchFinalize;
use Infrastructure\Console\Commands\CodeDistribute;
use Infrastructure\Console\Commands\OrderCardsSend;
use Infrastructure\Console\Commands\OrderFinalize;
use Infrastructure\Console\Commands\OrgAllot;
use Infrastructure\Console\Commands\OrgCodesPopulateRecipient;
use Infrastructure\Console\Commands\OrgList;
use Infrastructure\Console\Commands\RecipientLinkOrg;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
		ResourceMake::class,

		OrgList::class,
		OrgAllot::class,
		RecipientLinkOrg::class,
		OrgCodesPopulateRecipient::class,
		CodeDistribute::class,
		BatchCreate::class,
		BatchFinalize::class,
		OrderFinalize::class,
		OrderCardsSend::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }
}
