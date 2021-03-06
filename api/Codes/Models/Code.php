<?php

namespace Api\Codes\Models;

use Api\OrgMembers\Models\OrgMember;
use Api\Orgs\Models\Org;
use Api\Recipients\Models\Recipient;
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
		'recipient_id',
		'redeemed',
		'redeemed_at',
	];

	protected $casts = [
		'code'        => 'string',
		'phone'       => 'string',
		'sent'        => 'bool',
		'printed'     => 'bool',
		'distributed' => 'bool',
		'redeemed'    => 'bool',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
		'distributed_at',
		'printed_at',
		'sent_at',
		'redeemed_at',
	];

	protected $appends = [
		'distributing',
		'used',
		'claimed',
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

	public function setRedeemedAttribute($value) {
		$this->touchTimestamp($value, 'redeemed');
		$this->attributes['redeemed'] = $value;
	}

	public function getDistributingAttribute() {
		return $this->sent && ! $this->distributed;
	}

	public function getUsedAttribute() {
		return $this->email || $this->phone || $this->printed;
	}

	public function scopeUsed(Builder $query, $used): Builder {
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

	public function getClaimedAttribute() {
		return $this->recipient_id !== null;
	}

	public function scopeClaimed(Builder $query, $claimed): Builder {
		$claimed = (bool) $claimed;

		if ($claimed) {
			return $query->whereNotNull('recipient_id');
		}

		return $query->whereNull('recipient_id');
	}

	public function org() {
		return $this->belongsTo(Org::class);
	}

	public function org_member() {
		return $this->belongsTo(OrgMember::class);
	}

	public function recipient() {
		return $this->belongsTo(Recipient::class);
	}
}
