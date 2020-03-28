<?php

namespace Api\OrgMembers\Models;

use Api\Orgs\Models\Org;
use Api\Users\Models\User;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class OrgMember extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'org_member';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'org_id',
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

	public function org() {
		return $this->belongsTo(Org::class);
	}

	public function user() {
		return $this->belongsTo(User::class);
	}
}
