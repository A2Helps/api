<?php

namespace Api\Merchants\Models;

use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'merchant';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'img_url',
		'active',
		'amounts',
	];

	protected $casts = [
		'active'  => 'bool',
		'amounts' => 'array',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
}
