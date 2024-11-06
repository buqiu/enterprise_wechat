<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Utils;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    public static function info(mixed $message, array $context = []): void
    {
        Log::build([
            'driver'     => 'single',
            'path'       => storage_path('logs/'.config('app.name').'/we.log'),
            'level'      => env('LOG_LEVEL', 'debug'),
            'permission' => 0666,
        ])->info($message, $context);
    }

    public static function debug(mixed $message, array $context = []): void
    {
        Log::build([
            'driver'     => 'single',
            'path'       => storage_path('logs/'.config('app.name').'/we_debug.log'),
            'level'      => env('LOG_LEVEL', 'debug'),
            'permission' => 0666,
        ])->debug($message, $context);
    }

    public static function error(mixed $message, array $context = []): void
    {
        Log::build([
            'driver'     => 'single',
            'path'       => storage_path('logs/'.config('app.name').'/we_error.log'),
            'level'      => env('LOG_LEVEL', 'debug'),
            'permission' => 0666,
        ])->error($message, $context);
    }

    public static function event(mixed $message, array $context = []): void
    {
        Log::build([
            'driver'     => 'single',
            'path'       => storage_path('logs/'.config('app.name').'/we_event.log'),
            'level'      => env('LOG_LEVEL', 'debug'),
            'permission' => 0666,
        ])->info($message, $context);
    }
}
