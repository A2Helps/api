<?php

$router->get('/org_members',         '\Admin\OrgMembers\Controller@getAll');
$router->get('/org_members/{id}',    '\Admin\OrgMembers\Controller@getById');
$router->post('/org_members',        '\Admin\OrgMembers\Controller@create');
$router->put('/org_members/{id}',    '\Admin\OrgMembers\Controller@update');
