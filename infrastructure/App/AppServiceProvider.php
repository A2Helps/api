<?php

namespace Infrastructure\App;

use Cumulati\Monolog\LogContext;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{
	private $appQueryCount = 0;

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		JsonResource::withoutWrapping();

		//
		// uuid
		//
		Validator::extend('uuid', function($attribute, $value, $parameters, $validator){
			$matches = preg_match(
				'/(?:[0-9]+)|(?:[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})/',
				$value
			);

			return (bool) $matches;
		});

		/**
		 * compact uuid
		 *
		 * accepts:
		 *   - 3d707740d6db4d4c9e13d78947a9ac0f
		 *   - 3d707740-d6db-4d4c-9e13-d78947a9ac0f
		 */
		Validator::extend('cuuid', function($attribute, $value, $parameters, $validator){
			return valid_cuuid($value);
		});

		$ac = $this->app['config'];
		if ($ac['app.env'] === 'local' && $ac['app.debug'] && $ac['app.debug_sql']) {
			DB::listen(function($query) {
				Log::debug('db_statement', [
					'sql' => $query->sql,
					'bindings' => $query->bindings,
					'time' => $query->time,
					'queryCount' => ++$this->appQueryCount,
					'connection' => $query->connectionName,
				]);
			});
		}

		$monolog = Log::getLogger();
		$monolog->pushProcessor(function ($record) {
			$r = request();

			// Request Id
			if ($rid = $r->get('xtra-request_id')) {
				$record['extra']['request_id'] = $rid;
			}

			// User Id
			if ($uid = $r->get('xtra-user_id')) {
				$record['extra']['user_id'] = $uid;
			}

			$record['extra']['ip'] = $r->get('client_ip');

			return $record;
		});

		LogContext::setDefaultAppendCtxId(true);
		LogContext::setDefaultLogger($monolog);
		LogContext::setDefaultKeyCounter('_c');
		LogContext::setDefaultKeyTimer('_t');
	}
}
