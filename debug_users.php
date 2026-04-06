<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

try {
    $users = User::all(['id', 'name', 'email', 'soldier_id']);
    foreach ($users as $user) {
        echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, SoldierID: {$user->soldier_id}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
