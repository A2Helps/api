<?php

$router->post('/recipients',        '\Api\Recipients\Controller@create');
$router->get('/recipients',         '\Api\Recipients\Controller@getAll');
$router->get('/recipients/{id}',    '\Api\Recipients\Controller@getById');

// $router->put('/recipients/bulk',    '\Api\Recipients\Controller@updateBulk');
$router->put('/recipients/{id}',    '\Api\Recipients\Controller@update');

