<?php

$router->get('/orgs',         'OrgController@getAll');
$router->post('/orgs',        'OrgController@create');
$router->get('/orgs/{id}',    'OrgController@getById');
$router->put('/orgs/{id}',    'OrgController@update');
