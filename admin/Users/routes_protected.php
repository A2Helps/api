<?php

$router->get('/users',         '\Admin\Users\Controller@getAll');
$router->post('/users',        '\Admin\Users\Controller@create');
$router->get('/users/{id}',    '\Admin\Users\Controller@getById');
$router->put('/users/{id}',    '\Admin\Users\Controller@update');

$router->post('/users/{id}/token', '\Admin\Users\Controller@createToken');
$router->delete('/users/with-phone/{phone}', '\Admin\Users\Controller@deleteByPhone');
