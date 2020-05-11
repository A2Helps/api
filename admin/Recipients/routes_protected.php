<?php

// $router->get('/recipients',         '\Admin\Recipients\Controller@getAll');
// $router->get('/recipients/{id}',    '\Admin\Recipients\Controller@getById');
// $router->post('/recipients',        '\Admin\Recipients\Controller@create');
// $router->put('/recipients/{id}',    '\Admin\Recipients\Controller@update');

$router->delete('/recipients/with-phone/{phone}', '\Admin\Recipients\Controller@deleteByPhone');
$router->delete('/recipients/with-email/{email}', '\Admin\Recipients\Controller@deleteByEmail');
