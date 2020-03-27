<?php

$router->get('/givers',         'GiverController@getAll');
$router->post('/givers',        'GiverController@create');
$router->get('/givers/{id}',    'GiverController@getById');
$router->put('/givers/{id}',    'GiverController@update');
