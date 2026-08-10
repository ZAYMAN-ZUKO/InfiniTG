<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Capture any output from Composer autoloading (e.g. MadelineProto Windows warning)
ob_start();

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Flush captured output into log instead of sending to browser
$buffered = ob_get_clean();

if ($buffered !== '' && PHP_SAPI !== 'cli') {
    try {
        \Illuminate\Support\Facades\Log::channel('daily')->warning(
            'Composer autoloader output captured: ' . trim($buffered)
        );
    } catch (\Throwable $e) {
        error_log('Composer autoloader output (log failed): ' . trim($buffered));
    }
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());