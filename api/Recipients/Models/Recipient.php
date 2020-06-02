<?php

namespace Api\Recipients\Models;

use Api\Codes\Models\Code;
use Illuminate\Database\Eloquent\Builder;
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
		'email',
		'name_first',
		'name_last',
		'user_id',
		'org_id',
		'code_id', // default code
	];

	protected $casts = [
		'phone' => 'string'
	];

	public function codes() {
		return $this->hasMany(Code::class);
	}

	public function code() {
		return $this->hasOne(Code::class);
	}

	public function scopeSelected(Builder $query, $selected): Builder {
		return (bool) $selected
			? $query->whereNotNull('code_id')
			: $query->whereNull('code_id');
	}
}
