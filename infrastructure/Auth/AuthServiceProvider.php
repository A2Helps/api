<?php

namespace Infrastructure\Auth;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;
use Infrastructure\Auth\Guards\ApiTokenGuard;
use Infrastructure\Auth\Guards\FirebaseGuard;
use Infrastructure\Auth\Providers\ApiTokenUserProvider;
use Infrastructure\Auth\Providers\FirebaseUserProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		Auth::provider('api_token', function($app, array $config) {
			return new ApiTokenUserProvider();
		});

		Auth::extend('api_token', function ($app, $name, array $config) {
			$guard = new ApiTokenGuard(
				Auth::createUserProvider($config['provider']),

				$app['request'],
				$config['input_key'] ?? 'api_token',
				$config['storage_key'] ?? 'api_token',
				$config['hash'] ?? true
			);

			return $guard;
		});

		Auth::provider('firebase', function($app, array $config) {
			return new FirebaseUserProvider();
		});

		Auth::extend('firebase', function ($app, $name, array $config) {
			$guard = new FirebaseGuard(
				Auth::createUserProvider($config['provider']),

				$app['request'],
				$config['input_key'] ?? 'token',
				$config['storage_key'] ?? 'token',
				$config['hash'] ?? true
			);

			return $guard;
		});
	}
}
