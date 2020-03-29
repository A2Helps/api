<?php

namespace Infrastructure\Services;

use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Exceptions\UnauthorizedException;

abstract class BaseService
{
	protected function checkUserOrgPerm(string $orgId): void
	{
		$user = Auth::user();

		if (empty($user->orgMember)) {
			throw new UnauthorizedException();
		}

		if ($user->orgMember->org_id !== $orgId) {
			throw new UnauthorizedException();
		}
	}
}
