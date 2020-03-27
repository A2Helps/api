<?php

namespace Infrastructure\Transformers;


use JsonSerializable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Infrastructure\Database\Eloquent\Model;
use Infrastructure\Support\Contracts\Transformable;
use LogicException;
use Optimus\Bruno\LaravelController;

class ModelTransformer
{
	protected $data;
	protected $shallow;

	public static function transform($data, bool $shallow = false)
	{
		$i = new static($data, $shallow);
		return $i->process();
	}

	public function __construct($data, bool $shallow = false)
	{
		$this->data = $data;
		$this->shallow = $shallow;
	}

	public function process()
	{
		if ($this->shallow) {
			return $this->handle($this->data);
		}

		if ($this->data instanceof Collection) {
			return $this->handleCollection($this->data);
		}

		// handle the collection
		foreach ($this->data as $k => $v) {
			$this->data[$k] = $this->handleCollection($v);
		}

		return $this->data;
	}

	public function handleCollection($collection)
	{
		if (! ($collection instanceof Collection)) {
			if (is_array($collection)) {
				return $this->handleArray($collection);
			}

			return $this->handle($collection);
		}

		// if (! ($collection instanceof EloquentCollection)) {
		// 	throw new LogicException('Transformation of generic Collection is not supported');
		// }

		$transformer = $this->getCollectionTransformer($collection);

		if ($transformer) {
			return $transformer::collection($collection);
		}

		return $collection;
	}

	public function getCollectionTransformer($collection)
	{
		$first = $collection->first();
		if (empty($first)) {
			return null;
		}

		$class = get_class($first);

		$collection->each(function($model) use ($class) {
			if (get_class($model) !== $class) {
				throw new LogicException('Transforming collections with multiple model types is not supported.');
			}
		});

		if ($first instanceof Transformable) {
			Log::debug('using collection transformer', ['class' => $class]);
			return $first->getTransformerName();
		}

		Log::debug('collection is not transformable', ['class' => $class]);
		return null;
	}

	protected function handle($data)
	{
		if ($data instanceof Transformable) {
			$transformer = $data->getTransformerName();
			return new $transformer($data);
		}

		// if (! ($data instanceof Model)) {
		// 	return $data;
		// }

		return $data;
	}

	protected function handleArray($data)
	{
		foreach ($data as $k => $d) {
			$data[$k] = $this->handle($d);
		}

		return $data;
	}
}
