<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller
    extends BaseController
{
    private static function antispamHandle(): JsonResponse
    {
        return new JsonResponse([ 'test' ]);
    }

    /** @noinspection AnonymousFunctionStaticInspection */
    public static function initializeRoutes(): void
    {
        Route::get('/api/v1/antispam', fn() => self::antispamHandle());
    }
}
