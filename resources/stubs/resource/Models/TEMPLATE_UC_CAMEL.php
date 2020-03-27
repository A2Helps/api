<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Models;

use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TEMPLATE_UC_CAMEL extends Model
{
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'TEMPLATE_LC_SNAKE';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [

	];
}
