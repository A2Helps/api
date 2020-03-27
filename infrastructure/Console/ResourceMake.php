<?php

namespace Infrastructure\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ResourceMake extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'resource:make
		{api : which api namespace (api, api_other, etc...}
		{name : the resource name in snake case}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Stub out a new larapi resource';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		if (config('app.env') === 'production') {
			throw new Exception('Will not create resource in production!');
		}

		$api = strtolower($this->argument('api'));
		$name = Str::singular($this->argument('name'));

		$this->line(sprintf('Creating Resource: %s', $name));

		$names = [
			'uc_camel' => ucfirst(Str::camel($name)),
			'uc_camel_plural' => Str::plural(ucfirst(Str::camel($name))),

			'lc_camel' => lcfirst(Str::camel($name)),
			'lc_camel_plural' => Str::plural(lcfirst(Str::camel($name))),

			'lc_snake' => lcfirst(Str::snake($name)),
			'lc_snake_plural' => Str::plural(lcfirst(Str::snake($name))),
		];

		$apiNs = null;
		$apiDir = null;
		if ($api === 'api') {
			$apiNs = 'Api';
			$apiDir = 'api';
		} else {
			$apiNs = ucfirst(Str::camel($api));
			$apiDir = strtolower(Str::snake($api));
		}

		$templatePath = resource_path('stubs/resource');
		$path = base_path(sprintf('%s/%s', $apiDir, $names['uc_camel_plural']));

		shell_exec("cp -r $templatePath $path");

		shell_exec("find $path -type f -print0 | xargs -0 rename 's/TEMPLATE_UC_CAMEL/${names['uc_camel']}/'");
		shell_exec("find $path -type f -print0 | xargs -0 rename 's/TEMPLATE_UC_PLURAL_CAMEL/${names['uc_camel_plural']}/'");

		shell_exec("find $path -type f -print0 | xargs -0 sed -i '' 's/TEMPLATE_UC_CAMEL/${names['uc_camel']}/g'");
		shell_exec("find $path -type f -print0 | xargs -0 sed -i '' 's/TEMPLATE_LC_CAMEL/${names['lc_camel']}/g'");
		shell_exec("find $path -type f -print0 | xargs -0 sed -i '' 's/TEMPLATE_LC_SNAKE/${names['lc_snake']}/g'");

		shell_exec("find $path -type f -print0 | xargs -0 sed -i '' 's/TEMPLATE_UC_PLURAL_CAMEL/${names['uc_camel_plural']}/g'");
		shell_exec("find $path -type f -print0 | xargs -0 sed -i '' 's/TEMPLATE_LC_PLURAL_CAMEL/${names['lc_camel_plural']}/g'");
		shell_exec("find $path -type f -print0 | xargs -0 sed -i '' 's/TEMPLATE_LC_PLURAL_SNAKE/${names['lc_snake_plural']}/g'");

		shell_exec("find $path -type f -print0 | xargs -0 sed -i '' 's/TEMPLATE_API_NS/$apiNs/g'");

		echo PHP_EOL;
		$this->comment('Remember!');
		$this->line("\t- register the service provider");
		$this->line("\t- check the model db connection");
		echo PHP_EOL;
		$this->info(sprintf('Created %s', $names['uc_camel']));
	}
}
