<?php

declare(strict_types = 1);

use Rentalhost\TelegramAntispam\Controllers\Controller;

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(dirname(__DIR__)))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(dirname(__DIR__));
$app->withFacades();
// $app->withEloquent();

$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Rentalhost\TelegramAntispam\Exceptions\Handler::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, Rentalhost\TelegramAntispam\Console\Kernel::class);

$app->configure('app');

Controller::initializeRoutes();

return $app;
