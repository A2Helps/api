<?php

namespace Api\Orders\Models;

use Api\OrderCards\Models\OrderCard;
use Api\Orgs\Models\Org;
use Api\Users\Models\User;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class Order extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

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
		'amount',
	];

	protected $casts = [
		'complete' => 'boolean',
		'amount'   => 'integer',
	];

	public function orderCards() {
		return $this->hasMany(OrderCard::class);
	}
}
