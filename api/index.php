<?php

// Vercel : seul /tmp est writable — créer les dossiers nécessaires à Laravel
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

// Injecter les chemins dans l'environnement avant le boot Laravel
putenv("LARAVEL_STORAGE_PATH=$storagePath");
putenv("LARAVEL_BOOTSTRAP_CACHE=$cachePath");
$_ENV['LARAVEL_STORAGE_PATH']    = $storagePath;
$_ENV['LARAVEL_BOOTSTRAP_CACHE'] = $cachePath;
$_SERVER['LARAVEL_STORAGE_PATH']    = $storagePath;
$_SERVER['LARAVEL_BOOTSTRAP_CACHE'] = $cachePath;

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    error_log('[VERCEL-BOOT] ' . get_class($e) . ': ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    http_response_code(500);
    header('Content-Type: text/plain');
    echo get_class($e) . ': ' . $e->getMessage() . "\n\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}
