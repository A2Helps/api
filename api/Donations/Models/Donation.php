<?php

namespace Api\Donations\Models;

use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
	use SoftDeletes;

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
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [

	];
}
