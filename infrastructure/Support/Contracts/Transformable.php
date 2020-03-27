<?php

namespace Infrastructure\Support\Contracts;

interface Transformable
{
	public function getTransformerName(): string;

	public static function getDefaultTransformerName(): string;
}
