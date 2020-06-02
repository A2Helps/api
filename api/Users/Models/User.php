<?php

namespace Api\Users\Models;

use Api\OrgMembers\Models\OrgMember;
use Api\Recipients\Models\Recipient;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class User extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'user';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'email',
		'phone',
		'name_first',
		'name_last',
	];

	protected $casts = [
		'phone'    => 'string',

		'operator' => 'boolean',
		'admin'    => 'boolean',
	];

	public function orgMember() {
		return $this->hasOne(OrgMember::class);
	}

	public function recipients() {
		return $this->hasMany(Recipient::class);
	}
}
