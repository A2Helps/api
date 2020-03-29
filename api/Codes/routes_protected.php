<?php

$router->post('/codes',        '\Api\Codes\Controller@create');
$router->get('/codes',         '\Api\Codes\Controller@getAll');
$router->get('/codes/{id}',    '\Api\Codes\Controller@getById');

$router->put('/codes/bulk',    '\Api\Codes\Controller@bulkUpdate');
$router->put('/codes/{id}',    '\Api\Codes\Controller@update');

