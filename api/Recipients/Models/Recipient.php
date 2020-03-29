<?php

namespace Api\Recipients\Models;

use Api\OrgMembers\Models\OrgMember;
use Api\Orgs\Models\Org;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Database\Eloquent\Timestamper;

class Recipient extends Model
{
	use SoftDeletes;
	use Timestamper;

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
		'sent',
		'sent_at',
		'printed',
		'printed_at',
		'distributed',
		'distributed_at',
	];

	protected $casts = [
		'code'        => 'string',
		'phone'       => 'string',
		'sent'        => 'bool',
		'printed'     => 'bool',
		'distributed' => 'bool',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
		'distributed_at',
		'printed_at',
		'sent_at',
	];

	protected $appends = [
		'distributing',
	];

	public function setPrintedAttribute($value) {
		$this->touchTimestamp($value, 'printed');
		$this->attributes['printed'] = $value;
	}

	public function setSentAttribute($value) {
		$this->touchTimestamp($value, 'sent');
		$this->attributes['sent'] = $value;
	}

	public function setDistributedAttribute($value) {
		$this->touchTimestamp($value, 'distributed');
		$this->attributes['distributed'] = $value;
	}

	public function getDistributingAttribute() {
		return $this->sent && ! $this->distributed;
	}

	public function org() {
		return $this->belongsTo(Org::class);
	}

	public function org_member() {
		return $this->belongsTo(OrgMember::class);
	}
}
