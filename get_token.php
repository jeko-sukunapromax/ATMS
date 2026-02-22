<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sessions = DB::table('sessions')->get();
foreach ($sessions as $session) {
    if ($session->payload) {
        $data = base64_decode($session->payload);
        if (strpos($data, 'ihri_token') !== false) {
            $parsed = unserialize($data);
            echo "Token found: " . ($parsed['ihri_token'] ?? 'nope') . "\n";
        }
    }
}
