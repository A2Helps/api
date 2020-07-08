<?php

use Infrastructure\Http\Middleware\OperatorEnforcement;

$router->get('/v1/authcheck', 'DefaultApiController@authCheck');

$router->middleware([OperatorEnforcement::class])->group(function ($r) {
	$r->get('/v1/_/stats', 'DefaultApiController@stats');
	$r->post('/v1/_/search', 'DefaultApiController@search');
});
