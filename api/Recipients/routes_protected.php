<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	$r->get('/recipients',         '\Api\Recipients\Controller@getAll');
});
