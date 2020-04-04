<?php

$router->get('/merchants',         '\Admin\Merchants\Controller@getAll');
$router->get('/merchants/{id}',    '\Admin\Merchants\Controller@getById');
$router->post('/merchants',        '\Admin\Merchants\Controller@create');
$router->put('/merchants/{id}',    '\Admin\Merchants\Controller@update');
