<?php

/**
 * 🎖️ Force Navigator Deployment Script
 * Use: php sync_force_data.php
 */

define('LARAVEL_START', microtime(true));

// 1. Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Soldier;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

echo "\n--- STARTING PRODUCTION SYNC ---\n";

// 2. Setup Admin User
echo "[1/3] Updating Admin Credentials...\n";
User::updateOrCreate(
    ['email' => 'admin@gmail.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('123456'),
    ]
);

// 3. Clear Existing Data
echo "[2/3] Clearing Existing Soldier Data...\n";
Soldier::truncate();

// 4. Seed the 9 Personnel
echo "[3/3] Seeding 9 Real Personnel & 5-Level Hierarchy...\n";
$personnel = [
    ['no' => '4069572', 'name' => 'Md. Atiqur Rahman', 'name_bn' => 'মোঃ আতিকুর রহমান', 'rank' => 'Sainik', 'blood' => 'B+', 'district' => 'Naogaon', 'app' => 'LM Gman'],
    ['no' => '4047035', 'name' => 'Md. Al Amin', 'name_bn' => 'মোঃ আল আমিন', 'rank' => 'CPL', 'blood' => 'O+', 'district' => 'Feni', 'app' => 'Section Cmdr'],
    ['no' => '4072323', 'name' => 'Md. Tuhin Al Mamun', 'name_bn' => 'মোঃ তুহিন আল মামুন', 'rank' => 'UP/ LCPL', 'blood' => 'B+', 'district' => 'Jashore', 'app' => 'Rifleman', 'weight' => '60 kg'],
    ['no' => '4064468', 'name' => 'Mo Bashir Mollya Ratan', 'name_bn' => 'মো বশির মোল্যা রতন', 'rank' => 'Sainik', 'blood' => 'O+', 'district' => 'Faridpur'],
    ['no' => '4061682', 'name' => 'Opu Hasan', 'name_bn' => 'অপু হাসান', 'rank' => 'Sainik'],
    ['no' => '4075683', 'name' => 'Md. Didarul Islam', 'rank' => 'Sainik'],
    ['no' => '4060212', 'name' => 'Rashedul islam', 'rank' => 'Sainik'],
    ['no' => '4074383', 'name' => 'Md. Saifur Rahman', 'rank' => 'Sainik'],
    ['no' => '4071124', 'name' => 'Kazi Md. Abid Hossain', 'rank' => 'Sainik'],
];

foreach ($personnel as $p) {
    Soldier::create([
        'personal_no' => $p['no'],
        'number' => $p['no'],
        'name' => $p['name'],
        'name_bn' => $p['name_bn'] ?? $p['name'],
        'rank' => $p['rank'],
        'blood_group' => $p['blood'] ?? 'B+',
        'home_district' => $p['district'] ?? 'N/A',
        'appointment' => $p['app'] ?? 'Rifleman',
        'unit' => '9E Bengal',
        'company' => 'Alpha (A) Coy',
        'platoon' => '1 PL',
        'section' => '1 Sec',
        'user_type' => 'Staff',
        'is_active' => true,
        'weight' => $p['weight'] ?? null,
    ]);
}

echo "--- SYNC COMPLETE! TOTAL SOLDIERS: " . Soldier::count() . " ---\n";
echo "--- ADMIN LOGIN: admin@gmail.com / 123456 ---\n\n";
