<?php

declare(strict_types=1);

return [
	'host' => env('RABBITMQ_HOST', 'localhost'),
	'port' => env('RABBITMQ_PORT', 5672),
	'vhost' => env('RABBITMQ_VHOST', '/'),
	'user' => env('RABBITMQ_USER', 'guest'),
	'password' => env('RABBITMQ_PASSWORD', 'guest'),
];