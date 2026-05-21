<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';
// FORCE CLEAR CACHE TEMPORARY
if (isset($_GET['force_clear'])) {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->call('optimize:clear');
    $kernel->call('migrate', ['--force' => true]);
    die("<h1>Sukses!</h1><p>Cache berhasil dibersihkan dan Database berhasil di-migrate.</p>");
}

$app->handleRequest(Request::capture());
