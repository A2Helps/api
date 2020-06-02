<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	$r->get('/merchants/{id}',    '\Api\Merchants\Controller@getById');
	$r->get('/merchants',         '\Api\Merchants\Controller@getAll');
	$r->put('/merchants/{id}',    '\Api\Merchants\Controller@update');
	$r->post('/merchants',        '\Api\Merchants\Controller@create');
});
