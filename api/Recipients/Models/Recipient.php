<?php

namespace Api\Recipients\Models;

use Api\Codes\Models\Code;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class Recipient extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'recipient';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'phone',
		'name',
		'user_id',
	];

	protected $casts = [
		'phone' => 'string'
	];

	public function codes() {
		return $this->hasMany(Code::class);
	}
}
