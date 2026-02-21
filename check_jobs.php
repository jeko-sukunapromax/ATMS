<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jobs = DB::table('jobs')->count();
$failedJobs = DB::table('failed_jobs')->count();
$users = DB::table('users')->count();

echo "Jobs pending: $jobs\n";
echo "Jobs failed: $failedJobs\n";
echo "Total users: $users\n";
