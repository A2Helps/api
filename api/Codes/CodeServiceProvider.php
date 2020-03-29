<?php

namespace Api\Codes;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Api\Codes\Services\CodeService;

class CodeServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = CodeService::class;
}
