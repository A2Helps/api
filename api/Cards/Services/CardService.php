<?php

namespace Api\Cards\Services;

use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\DatabaseManager;
use Spatie\QueryBuilder\QueryBuilder;
use Api\Cards\Exceptions\CardNotFoundException;
use Api\Cards\Models\Card;

class CardService
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

	// public function getAll(): QueryBuilder
	// {
	// 	Log::debug('fetching all cards');
	// }

	// public function getById($id): QueryBuilder
	// {
	// 	Log::debug('fetching card', ['card_id' => $id]);
	// }

	// public function create($data): Card
	// {
	// 	Log::info('created card', ['card_id' => $card->id]);
	// }

	// public function update($id, array $data): Card
	// {
	// 	Log::info('updated card', ['card_id' => $id]);
	// }

	// public function delete($id): void
	// {
	// 	Log::info('deleted card', ['card_id' => $id]);
	// }

	protected function getRequestedCard($id): Card
	{
		$id = expand_uuid($id);
		$card = Card::find($id);

		if (empty($card)) {
			throw new CardNotFoundException();
		}

		return $card;
	}
}
