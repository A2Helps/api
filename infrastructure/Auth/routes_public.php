<?php

$router->post('/v1/login', 'LoginController@login');
$router->post('/v1/login/refresh', 'LoginController@refresh');
