<?php

namespace Api\Recipients\Models;

use Api\OrgMembers\Models\OrgMember;
use Api\Orgs\Models\Org;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'recipient';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'code',
		'phone',
		'email',
		'name',
		'org_id',
		'org_member_id',
	];

	protected $casts = [
		'code'  => 'string',
		'phone' => 'string',
	];

	public function org() {
		return $this->belongsTo(Org::class);
	}

	public function org_member() {
		return $this->belongsTo(OrgMember::class);
	}
}
