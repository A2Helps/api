<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	// $router->get('/batch_items',         '\Api\BatchItems\Controller@getAll');
	// $router->get('/batch_items/{id}',    '\Api\BatchItems\Controller@getById');
	// $router->post('/batch_items',        '\Api\BatchItems\Controller@create');
	// $router->put('/batch_items/{id}',    '\Api\BatchItems\Controller@update');
	// $router->delete('/batch_items/{id}', '\Api\BatchItems\Controller@delete');
});
