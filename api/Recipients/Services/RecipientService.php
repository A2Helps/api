<?php

namespace Api\Recipients\Services;

use Api\Codes\Jobs\DistributeCodeJob;
use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Api\Recipients\Exceptions\RecipientNotFoundException;
use Api\Recipients\Models\Recipient;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RecipientService
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

	public function getByPhone(string $phone): Recipient
	{
		$recipient = Recipient::where('phone', $phone)->first();

		if (empty($recipient)) {
			throw new RecipientNotFoundException();
		}

		return $recipient;
	}

	public function getByEmail(string $email): Recipient
	{
		$recipient = Recipient::where('email', $email)->first();

		if (empty($recipient)) {
			throw new RecipientNotFoundException();
		}

		return $recipient;
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

	public function getAll(): Collection
	{
		Log::debug('fetching all recipients');

		return QueryBuilder::for(Recipient::class)
			->allowedFilters([
				AllowedFilter::scope('selected'),
			])
			->get();
	}

	public function create($data): Recipient
	{
		if (! empty($data['phone'])) {
			try {
				$recipient = $this->getByPhone($data['phone']);

				throw new \Exception('Phone exists');
			} catch (RecipientNotFoundException $e) {}
		}

		if (!empty($data['email'])) {
			$data['email'] = strtolower($data['email']);
		}

		$recipient = Recipient::create(
			Arr::only($data, ['user_id', 'email', 'phone', 'name_first', 'name_last'])
		);

		Log::info('created recipient', ['recipient_id' => $recipient->id]);

		return $recipient;
	}

	public function reset($id) {
		try {
			$r = $this->getRequestedRecipient($id);
		} catch(RecipientNotFoundException $e) {
			return ['error' => 'Recipient not found'];
		}

		if (empty($r->code_id)) {
			return ['error' => 'Recipient was not offered a code'];
		}

		if ($r->code->redeemed) {
			return ['error' => 'Recipient already successfuly redeemed code'];
		}

		$r->phone = null;
		$r->save();

		$r->code->phone = null;
		$r->code->save();

		DistributeCodeJob::dispatch($r->code);

		return ['success' => true];
	}

	protected function getRequestedRecipient($id): Recipient
	{
		$id = expand_uuid($id);
		$recipient = Recipient::find($id);

		if (empty($recipient)) {
			throw new RecipientNotFoundException();
		}

		return $recipient;
	}
}
