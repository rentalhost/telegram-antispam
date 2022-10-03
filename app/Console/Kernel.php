<?php

declare(strict_types = 1);

namespace Rentalhost\TelegramAntispam\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel
    extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule): void
    {
    }
}
