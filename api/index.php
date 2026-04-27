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
] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Injecter les chemins dans l'environnement avant le boot Laravel
putenv("LARAVEL_STORAGE_PATH=$storagePath");
putenv("LARAVEL_BOOTSTRAP_CACHE=$cachePath");

require __DIR__ . '/../public/index.php';
