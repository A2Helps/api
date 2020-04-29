<?php

namespace Api\Cards\Models;

use Api\Merchants\Models\Merchant;
use Api\Orgs\Models\Org;
use Api\Recipients\Models\Recipient;
use Api\Users\Models\User;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class Card extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'card';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'merchant_id',
		'amount',
		'number',
		'assigned',
		'order_card_id',
		'recipient_id',
	];

	protected $casts = [
		'amount'   => 'int',
		'number'   => 'string',
		'assigned' => 'bool',
	];

	public function merchant() {
		return $this->belongsTo(Merchant::class);
	}

	public function recipient() {
		return $this->belongsTo(Recipient::class);
	}
}
