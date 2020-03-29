<?php

$router->get('/orgs',         '\Admin\Orgs\Controller@getAll');
$router->post('/orgs',        '\Admin\Orgs\Controller@create');
$router->get('/orgs/{id}',    '\Admin\Orgs\Controller@getById');
$router->put('/orgs/{id}',    '\Admin\Orgs\Controller@update');
