<?php

namespace Api\Givers\Models;

use Api\GiverUsers\Models\GiverUser;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class Giver extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'giver';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'allotment',
		'count_given',
		'enabled',
	];

	protected $casts = [
		'allotment'   => 'int',
		'count_given' => 'int',
		'enabled'     => 'bool',
	];

	public function giverUsers() {
		return $this->hasMany(GiverUser::class);
	}
}
