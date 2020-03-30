<?php

namespace Api\Codes\Models;

use Api\OrgMembers\Models\OrgMember;
use Api\Orgs\Models\Org;
use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Database\Eloquent\Timestamper;

class Code extends Model
{
	use SoftDeletes;
	use Timestamper;

	protected $keyType = 'string';
	public $table = 'code';

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
		'used',
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

	public function getUsedAttribute() {
		return $this->email || $this->phone || $this->printed;
	}

	public function scopeOfUsed(Builder $query, $used): Builder {
		$used = (bool) $used;

		if ($used) {
			// only select onces with an email or phone or printed

			return $query->where(function($q) {
				return $q->whereNotNull('email')
					->orWhereNotNull('phone')
					->orWhere('printed', true);
			});
		}

		// where not used
		return $query->whereNull('email')->whereNull('phone')->where('printed', false);
	}

	public function org() {
		return $this->belongsTo(Org::class);
	}

	public function org_member() {
		return $this->belongsTo(OrgMember::class);
	}
}
