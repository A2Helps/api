<?php

namespace Admin\Recipients;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Admin\Recipients\Services\AdminRecipientService;

class RecipientServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminRecipientService::class;
}
