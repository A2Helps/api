<?php

namespace Api\Recipients;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Recipients\Services\RecipientService;

class RecipientServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = RecipientService::class;
}
