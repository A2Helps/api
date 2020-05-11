<?php

namespace Api\BatchItems;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\BatchItems\Services\BatchItemService;

class BatchItemServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = BatchItemService::class;
}
