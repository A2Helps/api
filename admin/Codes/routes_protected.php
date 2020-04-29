<?php

$router->get('/codes',         '\Admin\Codes\Controller@getAll');
$router->get('/codes/{id}',    '\Admin\Codes\Controller@getById');

// $router->post('/code',        '\Admin\Codes\Controller@create');
// $router->put('/code/{id}',    '\Admin\Codes\Controller@update');
