<?php

use PascalDeVink\ShortUuid\ShortUuid;

function money_round ($amount): int {
	return (int) (floor(round($amount) * 1000) / 1000);
}

function money_float (int $amount): float {
	return $amount / 100;
}

function money_human (int $amount): string {
	// TODO: use money_format

	return number_format($amount / 100, 2);
}

function trim_lower(string $str): string {
	return trim(strtolower($str));
}

function strip_breaks (string $str): string {
	return (string) preg_replace('/(\r\n)|\r|\n/', '', $str);
}

function implode_breaks (string $glue, $str): string {
	$breaks = preg_split('/(\r\n)|\r|\n/', $str);

	if ($breaks === false) {
		$breaks = [];
	}

	$breaks = array_filter($breaks, function($x) {
		return ! empty($x);
	});

	return implode($glue, $breaks);
}

function uuid(): string {
	return \Ramsey\Uuid\Uuid::uuid4()->toString();
}

function expand_uuid(string $uuid): string {
	if (strlen($uuid) === 22) {
		$su = new PascalDeVink\ShortUuid\ShortUuid();
		return $su->decode($uuid);
	}

	return Ramsey\Uuid\Uuid::fromString($uuid)->toString();
}

function compact_uuid(string $uuid): string {
	return preg_replace('/-/', '', Ramsey\Uuid\Uuid::fromString($uuid)->toString());
}

function shorten_uuid(string $uuid = null):? string {
	if ($uuid === null) {
		return null;
	}

	$su = new PascalDeVink\ShortUuid\ShortUuid();
	return $su->encode(Ramsey\Uuid\Uuid::fromString($uuid));
}

function shorten_array_uuids(array $arr, array $include = [], array $except = []): array {
	foreach ($arr as $k => $v) {
		if (in_array($k, $except)) {
			continue;
		}

		$isId = $k === 'id' || Illuminate\Support\Str::endsWith($k, ['_id']);
		if ($isId || in_array($k, $include)) {
			$arr[$k] = shorten_uuid($v);
		}
	}

	return $arr;
}

function valid_cuuid(string $uuid): bool {
	try {
		Ramsey\Uuid\Uuid::fromString($uuid);
		return true;
	} catch (Ramsey\Uuid\Exception\InvalidUuidStringException $e) { }

	return false;
}

function valid_suuid(string $uuid): bool {
	try {
		$su = new PascalDeVink\ShortUuid\ShortUuid();
		$su->decode($uuid);
		return true;
	} catch (Ramsey\Uuid\Exception\InvalidUuidStringException $e) { }

	return false;
}


function normalize_street_zip(string $street, $zip) {
	$addr = implode(', ', [
		implode_breaks(', ', $street),
		str_pad($zip, 5, '0', STR_PAD_LEFT),
	]);

	return trim_lower($addr);
}
