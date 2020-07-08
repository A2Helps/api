<?php

namespace Api\Batches\Models;

use Api\BatchItems\Models\BatchItem;
use Api\Merchants\Models\Merchant;
use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Database\Eloquent\Timestamper;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class Batch extends Model implements Transformable
{
	use ModelTransformer;
	use Timestamper;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'batch';

	protected $fillable = [
		'merchant_id',
		'amount',
		'quantity',
		'assigned_to',
		'assigned_at',
		'completed',
		'completed_at',
		'finalized',
		'finalized_at',
	];

	protected $casts = [
		'amount'    => 'integer',
		'quantity'  => 'integer',
		'completed' => 'boolean',
		'finalized' => 'boolean',
	];

	protected $dates = [
		'assigned_at',
		'completed_at',
		'finalized_at',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $appends = [
		'assigned_to_me'
	];

	public function setCompletedAttribute($value) {
		$this->touchTimestamp($value, 'completed');
		$this->attributes['completed'] = $value;
	}

	public function setFinalizedAttribute($value) {
		$this->touchTimestamp($value, 'finalized');
		$this->attributes['finalized'] = $value;
	}

	public function batchItems() {
		return $this->hasMany(BatchItem::class);
	}

	public function merchant() {
		return $this->belongsTo(Merchant::class);
	}

	public function getAssignedToMeAttribute() {
		$user = auth()->user();
		if (empty($user)) {
			return false;
		}

		return $this->assigned_to === $user->id;
	}

	public function scopeCompleted(Builder $query, $completed): Builder {
		return $query->where('completed', (bool) $completed);
	}
}
