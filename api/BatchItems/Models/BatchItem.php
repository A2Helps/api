<?php

namespace Api\BatchItems\Models;

use Api\Batches\Models\Batch;
use Api\OrderCards\Models\OrderCard;
use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class BatchItem extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'batch_item';

	protected $fillable = [
		'batch_id',
		'number',
		'order_card_id',
		'card_id',
	];

	protected $casts = [
		'number' => 'string',
	];

	protected $hidden = [

	];

	public function orderCard() {
		return $this->belongsTo(OrderCard::class);
	}

	public function batch() {
		return $this->belongsto(Batch::class);
	}
}
