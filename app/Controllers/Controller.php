<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Controllers;

use Illuminate\Support\Facades\Route;
use Laravel\Lumen\Routing\Controller as BaseController;
use Rentalhost\TelegramAntispam\Services\AntispamService;

class Controller
    extends BaseController
{
    /** @noinspection AnonymousFunctionStaticInspection */
    public static function initializeRoutes(): void
    {
        Route::post('/api/v1/antispam', fn() => AntispamService::handle());
    }
}
