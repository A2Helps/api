<?php

namespace Api\Donations\Models;

use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Database\Eloquent\Timestamper;

class Donation extends Model
{
	use SoftDeletes;
	use Timestamper;

	protected $keyType = 'string';
	public $table = 'donation';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'amount',
		'co_session',
		'canceled',
		'canceled_at',
		'completed',
		'completed_at',
		'public',
		'public_name',
		'wired',
		'wired_from',
		'settled',
		'settled_at',
		'email',
	];

	protected $casts = [
		'amount'   => 'int',
		'canceled' => 'bool',
		'wired'    => 'bool',
		'public'   => 'bool',
		'settled'  => 'bool',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
		'canceled_at',
		'completed_at',
		'settled_at',
	];

	public function setCanceledAttribute($value) {
		$this->touchTimestamp($value, 'canceled');
		$this->attributes['canceled'] = $value;
	}

	public function setCompletedAttribute($value) {
		$this->touchTimestamp($value, 'completed');
		$this->attributes['completed'] = $value;
	}

	public function setSettledAttribute($value) {
		$this->touchTimestamp($value, 'settled');
		$this->attributes['settled'] = $value;
	}
}
