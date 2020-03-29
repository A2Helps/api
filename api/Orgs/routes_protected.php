<?php

$router->get('/orgs',         '\Api\Orgs\Controller@getAll');
$router->get('/orgs/{id}',    '\Api\Orgs\Controller@getById');

// $router->post('/orgs',        '\Api\Orgs\Controller@create');
// $router->put('/orgs/{id}',    '\Api\Orgs\Controller@update');
// $router->delete('/orgs/{id}', '\Api\Orgs\Controller@delete');
