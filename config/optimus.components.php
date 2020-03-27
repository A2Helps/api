<?php

return [
	'namespaces' => [
		'Api' => [
			'path' => base_path() . DIRECTORY_SEPARATOR . 'api',
			'route' => [
				'prefix' => '/v1',
			]
		],

		'Admin' => [
			'path' => base_path() . DIRECTORY_SEPARATOR . 'admin',
			'route' => [
				'prefix' => '/admin/v1',
				'middleware' => []
			],
			'protection_middleware' => [
				'admin'
			],
		],

		'Infrastructure' => [
			'path' => base_path() . DIRECTORY_SEPARATOR . 'infrastructure',
		],
	],

	// WIP:
	// 'register_service_provider_namespaces' => [
	// 	'Api'
	// ],

	'protection_middleware' => [
		'auth'
	],

	'resource_namespace' => 'resources',

	'language_folder_name' => 'lang',

	'view_folder_name' => 'views'
];
