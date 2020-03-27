<?php

namespace Infrastructure\Database\Eloquent;

use Illuminate\Support\Facades\Log;

trait Timestamper
{
	protected function touchTimestamp(
		Model &$model,
		string $property,
		array &$data,
		string $atKey = null
	) {
		if (! array_key_exists($property, $data)) {
			return;
		}

		// if we are not changing anything, return
		if ($model->{$property} == $data[$property]) {
			return;
		}

		$atKey = $atKey ?? sprintf('%s_at', $property);

		if (! $data[$property]) {
			$model->{$atKey} = null;
		} else {
			$now = now();
			Log::debug('timestamping attribute', [
				'model'    => get_class($model),
				'property' => $atKey,
				'time'     => $now,
			]);

			$model->{$atKey} = $now;
		}

		unset($data[$atKey]);
	}
}
