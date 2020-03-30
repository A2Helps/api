<?php

namespace Admin\Codes;

use Infrastructure\Services\Provider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Admin\Codes\Services\AdminCodeService;

class CodeServiceProvider extends Provider implements DeferrableProvider
{
	protected $resource = AdminCodeService::class;
}
