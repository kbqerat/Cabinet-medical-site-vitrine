<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Serve static assets directly — bypasses Vercel's unreliable filesystem handler
$uri  = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH);
$file = __DIR__ . '/../public' . $path;

if ($path !== '/' && file_exists($file) && is_file($file)) {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $mime = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'webp'  => 'image/webp',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'txt'   => 'text/plain',
        'json'  => 'application/json',
    ];
    if (isset($mime[$ext])) {
        header('Content-Type: ' . $mime[$ext]);
        header('Cache-Control: public, max-age=31536000, immutable');
        readfile($file);
        exit;
    }
}

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
