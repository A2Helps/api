<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->get('/users/me',    '\Api\Users\Controller@getMe');

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	$r->get('/users',    '\Api\Users\Controller@getAll');
});
