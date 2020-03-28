<?php

namespace Api\GiverUsers\Models;

use Api\Givers\Models\Giver;
use Api\Users\Models\User;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class GiverUser extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'giver_user';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'giver_id',
		'user_id',
		'allotment',
		'count_given',
		'enabled'
	];

	protected $casts = [
		'allotment'   => 'int',
		'count_given' => 'int',
		'enabled'     => 'bool',
	];

	public function giver() {
		return $this->belongsTo(Giver::class);
	}

	public function user() {
		return $this->belongsTo(User::class);
	}
}
