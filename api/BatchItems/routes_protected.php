<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	// $r->get('/batch_items',         '\Api\BatchItems\Controller@getAll');
	// $r->get('/batch_items/{id}',    '\Api\BatchItems\Controller@getById');
	// $r->post('/batch_items',        '\Api\BatchItems\Controller@create');
	$r->put('/batch_items/{id}',    '\Api\BatchItems\Controller@update');
	// $r->delete('/batch_items/{id}', '\Api\BatchItems\Controller@delete');
});
