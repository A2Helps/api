<?php

namespace Infrastructure\Api\Controllers;

use Illuminate\Support\Facades\Log;
use Infrastructure\Http\Controller as BaseController;
use Infrastructure\Version;

class DefaultApiController extends BaseController
{
	public function index()
	{
		Log::info('Resolving version');

		$v = [
			'title'   => config('app.name'),
			'version' => Version::getGitTag(),
			'request_id' => request()->get('xtra-request_id'),
		];

		$env = app()->env;
		if ($env !== 'production') {
			$v['env'] = $env;
		}

		return response()->json($v);
	}

	public function authCheck()
	{
		Log::info('Successful token check');

		return response()->json([ 'success' => true ]);
	}
}
