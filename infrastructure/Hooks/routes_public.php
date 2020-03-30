<?php

$router->post('/hooks/test/v1', '\Infrastructure\Hooks\Controller@receive_test');
// $router->post('/hooks/pusher/v1', '\Infrastructure\Hooks\Controller@receive_pusher');

$router->post('/hooks/stripe/v1', '\Infrastructure\Hooks\Controller@receive_stripe');
