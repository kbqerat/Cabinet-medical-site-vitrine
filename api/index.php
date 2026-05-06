<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Vercel: only /tmp is writable
$storagePath = '/tmp/laravel-storage';
$cachePath   = '/tmp/laravel-cache';

foreach ([
    "$storagePath/app/public",
    "$storagePath/framework/cache/data",
    "$storagePath/framework/sessions",
    "$storagePath/framework/testing",
    "$storagePath/framework/views",
    "$storagePath/logs",
    $cachePath,
    "$cachePath/cache",
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

putenv("LARAVEL_STORAGE_PATH=$storagePath");
putenv("LARAVEL_BOOTSTRAP_CACHE=$cachePath");
$_ENV['LARAVEL_STORAGE_PATH']       = $storagePath;
$_ENV['LARAVEL_BOOTSTRAP_CACHE']    = $cachePath;
$_SERVER['LARAVEL_STORAGE_PATH']    = $storagePath;
$_SERVER['LARAVEL_BOOTSTRAP_CACHE'] = $cachePath;

if (file_exists($maintenance = $storagePath . '/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__ . '/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->handleRequest(Request::capture());
