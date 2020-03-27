<?php

$router->get('/users',         'UserController@getAll');
$router->post('/users',        'UserController@create');
$router->get('/users/{id}',    'UserController@getById');
$router->put('/users/{id}',    'UserController@update');
