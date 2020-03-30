<?php

namespace Api\Orgs\Models;

use Api\OrgMembers\Models\OrgMember;
use Api\Codes\Models\Code;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class Org extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'org';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'allotment',
		'count_distributed',
		'enabled',
	];

	protected $casts = [
		'allotment'         => 'int',
		'count_distributed' => 'int',
		'enabled'           => 'bool',
	];

	public function orgMembers() {
		return $this->hasMany(OrgMember::class);
	}

	public function codes() {
		return $this->hasMany(Code::class);
	}
}
