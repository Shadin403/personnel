<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Define temporary SQLite connection for migration source
Config::set('database.connections.sqlite_temp', [
    'driver' => 'sqlite',
    'database' => base_path('database/database.sqlite'),
    'prefix' => '',
]);

$tables = ['units', 'soldiers', 'users', 'courses', 'training_plans', 'unit_trainings'];

echo "Starting data transfer from SQLite to MySQL...\n";

// Disable foreign key checks to prevent transfer order issues
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

foreach ($tables as $table) {
    echo "Transferring table: {$table}...\n";
    
    // Clear existing data in destination MySQL to prevent duplicates
    DB::table($table)->truncate();
    
    // Get all records from source SQLite
    $records = DB::connection('sqlite_temp')->table($table)->get();
    
    foreach ($records as $record) {
        $data = (array) $record;
        DB::table($table)->insert($data);
    }
    
    echo "Done with {$table}. Count: " . count($records) . "\n";
}

// Re-enable foreign key checks for database integrity
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

echo "Data transfer completed successfully!\n";
