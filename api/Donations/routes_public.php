<?php

$router->post('/donations',        '\Api\Donations\Controller@create');
$router->put('/donations/{id}',    '\Api\Donations\Controller@update');
$router->get('/donations',         '\Api\Donations\Controller@getAll');
