<?php

$router->post('/hooks/test/v1', 'WebhookController@receive_test');
$router->post('/hooks/pusher/v1', 'WebhookController@receive_pusher');
