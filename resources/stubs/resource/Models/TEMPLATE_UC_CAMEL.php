<?php

namespace TEMPLATE_API_NS\TEMPLATE_UC_PLURAL_CAMEL\Models;

use Infrastructure\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Infrastructure\Models\ModelTransformer;
use Infrastructure\Support\Contracts\Transformable;

class TEMPLATE_UC_CAMEL extends Model implements Transformable
{
	use ModelTransformer;
	use SoftDeletes;

	protected $keyType = 'string';
	public $table = 'TEMPLATE_LC_SNAKE';

	protected $fillable = [

	];

	protected $casts = [

	];

	protected $hidden = [

	];
}
