<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$userRole = \Spatie\Permission\Models\Role::where('name', 'user')->first();
if ($userRole) {
    echo 'user role permissions: ' . json_encode($userRole->permissions->pluck('name')) . PHP_EOL;
}

$adminRole = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
if ($adminRole) {
    echo 'admin role permissions: ' . json_encode($adminRole->permissions->pluck('name')) . PHP_EOL;
}

$users = \App\Models\User::all();
foreach ($users as $u) {
    $roles = $u->getRoleNames()->toArray();
    if (in_array('user', $roles)) {
        echo "User {$u->email} has roles: " . json_encode($roles) . " and permissions: " . json_encode($u->getAllPermissions()->pluck('name')) . PHP_EOL;
    }
}
