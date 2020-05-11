<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	$r->get('/batches',         '\Api\Batches\Controller@getAll');
	$r->get('/batches/{id}',    '\Api\Batches\Controller@getById');
	// $r->post('/batches',        '\Api\Batches\Controller@create');
	$r->put('/batches/{id}',    '\Api\Batches\Controller@update');
	// $r->delete('/batches/{id}', '\Api\Batches\Controller@delete');
});
