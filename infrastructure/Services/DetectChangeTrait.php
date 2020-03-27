<?php

namespace Infrastructure\Services;

use Illuminate\Database\Eloquent\Model;

trait DetectChangeTrait
{
	public function detectChange($key, Model $model, $data)
	{
		if (! isset($data[$key])) return false;

		return $model->$key !== $data[$key];
	}
}
