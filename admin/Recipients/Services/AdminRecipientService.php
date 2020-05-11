<?php

namespace Admin\Recipients\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Recipients\Exceptions\RecipientNotFoundException;
use Api\Recipients\Models\Recipient;
use Api\Recipients\Services\RecipientService;
use Api\Orgs\Models\Org;
use Cumulati\Monolog\LogContext;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use LogicException;
use Spatie\QueryBuilder\AllowedFilter;

class AdminRecipientService extends RecipientService
{
	private $auth;

	private $database;

	private $dispatcher;

	public function __construct(
		AuthManager $auth,
		DatabaseManager $database,
		Dispatcher $dispatcher
	) {
		$this->auth = $auth;
		$this->database = $database;
		$this->dispatcher = $dispatcher;
	}

	public function getAll(): Collection
	{
		Log::debug('fetching all recipients');

		return QueryBuilder::for(Recipient::class)
			->get();
	}

	public function getById($id): Recipient
	{
		$id = expand_uuid($id);
		Log::debug('fetching recipient', ['recipient_id' => $id]);

		$recipient = QueryBuilder::for(Recipient::where('id', $id))
			->first();

		if (empty($recipient)) {
			throw new RecipientNotFoundException();
		}

		return $recipient;
	}

	public function delete($recipientId): void
	{
		$recipient = $this->getRequestedRecipient($recipientId);

		$lc = new LogContext(['recipient_id' => $recipientId]);
		$lc->info('deleting recipient');

		if ($recipient->user_id) {
			throw new \Exception(sprintf('Recipient belongs to User{%s}', shorten_uuid($recipient->user_id)));
		}

		if ($recipient->org_id) {
			throw new \Exception(sprintf('Recipient belongs to Org{%s}', shorten_uuid($recipient->org_id)));
		}

		$recipient->forceDelete();

		$lc->info('deleted recipient');
	}

	public function deleteByPhone(string $phone): void
	{
		$recipient = $this->getByPhone($phone);

		$this->delete($recipient->id);
	}

	public function deleteByEmail(string $email): void
	{
		$recipient = $this->getByEmail($email);

		$this->delete($recipient->id);
	}
}
