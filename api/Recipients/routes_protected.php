<?php

$router->post('/recipients',        'RecipientController@create');
$router->get('/recipients',         'RecipientController@getAll');
$router->get('/recipients/{id}',    'RecipientController@getById');
$router->delete('/recipients/{id}', 'RecipientController@delete');

// $router->put('/recipients/{id}',    'RecipientController@update');
