<?php

use Symfony\Component\HttpKernel\Exception as SymfonyException;
use Optimus\Heimdal\Formatters;
use Infrastructure\Exceptions\Formatters as IFormatters;

$c = [
	'add_cors_headers' => false,

	// Has to be in prioritized order, e.g. highest priority first.
	'formatters' => [
		SymfonyException\UnauthorizedHttpException::class        => IFormatters\UnauthorizedHttpExceptionFormatter::class,

		// Illuminate\Auth\AuthenticationException::class =>

		Infrastructure\Exceptions\AuthenticationException::class   => IFormatters\AuthenticationExceptionFormatter::class,
		Infrastructure\Exceptions\UnauthorizedException::class   => IFormatters\UnauthorizedHttpExceptionFormatter::class,
		Infrastructure\Exceptions\ForbiddenException::class      => IFormatters\ForbiddenExceptionFormatter::class,
		Infrastructure\Exceptions\RequestFailedException::class      => IFormatters\RequestFailedExceptionFormatter::class,

		Infrastructure\Exceptions\CriticalException::class       => IFormatters\ExceptionFormatter::class,
		Infrastructure\Exceptions\AlertException::class          => IFormatters\ExceptionFormatter::class,
		Infrastructure\Exceptions\EmergencyException::class       => IFormatters\ExceptionFormatter::class,

		Infrastructure\Exceptions\ImATeapotHttpException::class  => IFormatters\ImATeapotHttpExceptionFormatter::class,

		SymfonyException\UnprocessableEntityHttpException::class => IFormatters\UnprocessableEntityHttpExceptionFormatter::class,

		SymfonyException\HttpException::class                    => Formatters\HttpExceptionFormatter::class,
		Exception::class                                         => IFormatters\ExceptionFormatter::class,

		Throwable::class                                         => IFormatters\ExceptionFormatter::class,
	],

	'response_factory' => \Optimus\Heimdal\ResponseFactory::class,

	'reporters' => [],

	'server_error_production' => 'An error occurred.'
];

$sentryDsn = env('SENTRY_DSN', false);
if ($sentryDsn) {
	$c['reporters']['sentry'] = [
		'class'  => \Optimus\Heimdal\Reporters\SentryReporter::class,
		'config' => [
			'dsn' => '',
			// For extra options see https://docs.sentry.io/clients/php/config/
			// php version and environment are automatically added.
			'sentry_options' => []
		]
	];
}

return $c;
