<?php

// $router->get('/users',         '\Api\Users\Controller@getAll');
// $router->get('/users/{id}',    '\Api\Users\Controller@getById');
// $router->post('/users',        '\Api\Users\Controller@create');
// $router->put('/users/{id}',    '\Api\Users\Controller@update');
// $router->delete('/users/{id}', '\Api\Users\Controller@delete');

$router->get('/users/me',    '\Api\Users\Controller@getMe');
