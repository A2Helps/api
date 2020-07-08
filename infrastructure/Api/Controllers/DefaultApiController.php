<?php

namespace Infrastructure\Api\Controllers;

use Api\Orgs\Models\Org;
use Api\Recipients\Models\Recipient;
use Api\Recipients\Transformers\RecipientTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

	public function stats()
	{
		Log::info('fetching stats');

		$stats = [
			'orgs' => [],
		];

		$orgs = Org::all()
			->filter(fn($o) => strtolower($o->name) !== 'test')
			->map(function($org) {
				$x = ['name' => $org->name];

				$q = DB::table('code')
					->select(DB::raw('count(1) filter (where code.sent) as sent, count(1) filter (where code.recipient_id is null) as avail, count(1) filter (where code.redeemed) as redeemed'))
					->where('org_id', $org->id)
					->first();

				$x['sent'] = $q->sent;
				$x['avail'] = $q->avail;
				$x['redeemed'] = $q->redeemed;

				return $x;
			})
			->values();

		$stats['orgs'] = $orgs;

		return $stats;
	}

	public function search(Request $request)
	{
		$search = $request->get('search');
		$r = ['recipients' => []];

		$search = strtolower(preg_replace('/[%]/', '', $search));

		if (empty($search)) {
			return $r;
		}

		$phone = preg_replace('/[^0-9]/', '', $search);

		Log::warning('search query', ['phone' => $phone, 'search' => $search]);

		$recipients = Recipient::whereNotNull('code_id')
			->where(function($query) use ($search, $phone) {
				$query->where(DB::raw('lower(email)'), $search)
				->orWhere(DB::raw('lower(concat_ws(\' \', name_first, name_last))'), 'ilike', "%$search%");

				if ($phone)
					$query->orWhere('phone', $phone);
			});

		$r['recipients'] = RecipientTransformer::collection($recipients->get());
		return $r;
	}
}
