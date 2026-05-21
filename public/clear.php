<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// Menjalankan Artisan command lewat script murni
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->handle(
    new Symfony\Component\Console\Input\ArrayInput([
        'command' => 'optimize:clear',
    ]),
    new Symfony\Component\Console\Output\BufferedOutput()
);
$kernel->handle(
    new Symfony\Component\Console\Input\ArrayInput([
        'command' => 'migrate',
        '--force' => true,
    ]),
    new Symfony\Component\Console\Output\BufferedOutput()
);

echo "<h1>Sukses!</h1><p>Cache berhasil dibersihkan dan Database berhasil di-migrate.</p>";
