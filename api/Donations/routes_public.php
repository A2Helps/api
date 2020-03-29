<?php

$router->post('/donations',        '\Api\Donations\Controller@create');
$router->put('/donations/{id}',    '\Api\Donations\Controller@update');
