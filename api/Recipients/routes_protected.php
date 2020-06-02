<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	$r->get('/recipients/{id}',    '\Api\Recipients\Controller@getById');
	$r->get('/recipients',         '\Api\Recipients\Controller@getAll');
});
