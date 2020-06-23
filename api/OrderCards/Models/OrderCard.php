<?php

namespace Api\OrderCards\Models;

use Api\BatchItems\Models\BatchItem;
use Api\Cards\Models\Card;
use Api\Merchants\Models\Merchant;
use Api\Orders\Models\Order;
use Api\Orgs\Models\Org;
use Api\Users\Models\User;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class OrderCard extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'order_card';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'order_id',
		'recipient_id',
		'merchant_id',
		'amount',
		'card_id',
		'batch_item_id',
	];

	protected $casts = [
		'amount' => 'int',
	];

	public function merchant() {
		return $this->belongsTo(Merchant::class);
	}

	public function order() {
		return $this->belongsTo(Order::class);
	}

	public function card() {
		return $this->belongsTo(Card::class);
	}

	public function batchItem() {
		return $this->belongsTo(BatchItem::class);
	}
}
