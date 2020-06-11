<?php

$router->get('/orders',         '\Api\Orders\Controller@getAll');
$router->get('/orders/{id}',    '\Api\Orders\Controller@getById');


// $router->post('/orders',        '\Api\Orders\Controller@create');
// $router->put('/orders/{id}',    '\Api\Orders\Controller@update');
// $router->delete('/orders/{id}', '\Api\Orders\Controller@delete');
