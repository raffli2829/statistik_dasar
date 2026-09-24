<?php

// Buat berkas database SQLite di direktori ephemeral Vercel jika belum ada
$databasePath = '/tmp/database.sqlite';
if (!file_exists($databasePath)) {
    touch($databasePath);
}

// Buat direktori storage yang dibutuhkan Laravel
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
    '/tmp/storage/logs',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

require __DIR__ . '/../public/index.php';