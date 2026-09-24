<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Inisialisasi basis data SQLite sementara di /tmp
$databasePath = '/tmp/database.sqlite';
if (!file_exists($databasePath)) {
    touch($databasePath);
}

// 2. Siapkan direktori storage ephemeral
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/logs',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 3. Muat Autoloader Composer
require __DIR__ . '/../vendor/autoload.php';

// 4. Inisialisasi Aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Arahkan path storage dan bootstrap cache ke /tmp
$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp/storage/bootstrap');

// 5. Eksekusi Request
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);