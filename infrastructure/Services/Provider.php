<?php

namespace Infrastructure\Services;

use Log;
use Illuminate\Support\ServiceProvider;

abstract class Provider extends ServiceProvider
{
	public function register()
	{
		if (isset($this->resource)) {
			$this->registerResource();

			return;
		}

		Log::warning('This probably shouldnt happen');
	}

	protected function registerResource()
	{
		$parts = explode('\\', $this->resource);

		$this->app->singleton($this->resource);
		$this->app->alias($this->resource, array_pop($parts));
	}

	public function provides()
	{
		if (! isset($this->resource)) {
			return [];
		}

		$parts = explode('\\', $this->resource);

		return [
			$this->resource,
			array_pop($parts)
		];
	}
}
