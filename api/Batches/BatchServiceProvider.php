<?php

namespace Api\Batches;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Batches\Services\BatchService;

class BatchServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = BatchService::class;
}
