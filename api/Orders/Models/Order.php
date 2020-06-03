<?php

namespace Api\Orders\Models;

use Api\OrderCards\Models\OrderCard;
use Api\Orgs\Models\Org;
use Api\Users\Models\User;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Database\Eloquent\Timestamper;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class Order extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;
	use Timestamper;

	protected $keyType = 'string';
	public $table = 'order';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'code_id',
		'recipient_id',
		'user_id',
		'complete',
		'complete_at',
		'cards_sent',
		'cards_sent_at',
		'amount',
		'batched',
		'batched_at',
	];

	protected $casts = [
		'batched' => 'boolean',
		'complete' => 'boolean',
		'cards_sent' => 'boolean',
		'amount'   => 'integer',
	];

	protected $dates = [
		'batched_at',
		'cards_sent_at',
		'complete_at',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	public function setCompleteAttribute($value) {
		$this->touchTimestamp($value, 'complete');
		$this->attributes['complete'] = $value;
	}

	public function setCardsSentAttribute($value) {
		$this->touchTimestamp($value, 'cards_sent');
		$this->attributes['cards_sent'] = $value;
	}

	public function setBatchedAttribute($value) {
		$this->touchTimestamp($value, 'batched');
		$this->attributes['batched'] = $value;
	}

	public function orderCards() {
		return $this->hasMany(OrderCard::class);
	}
}
