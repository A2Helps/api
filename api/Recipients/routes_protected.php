<?php

$router->post('/recipients',        '\Api\Recipients\Controller@create');
$router->get('/recipients',         '\Api\Recipients\Controller@getAll');
$router->get('/recipients/{id}',    '\Api\Recipients\Controller@getById');
$router->delete('/recipients/{id}', '\Api\Recipients\Controller@delete');

// $router->put('/recipients/{id}',    '\Api\Recipients\Controller@update');
