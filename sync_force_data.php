<?php

/**
 * 🎖️ Force Navigator Deployment Script (V3 - Normalized Tables)
 * Use: php sync_force_data.php
 */

define('LARAVEL_START', microtime(true));

// 1. Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Soldier;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "\n--- STARTING NORMALIZED DATA SYNC ---\n";

// 2. Setup Admin User
echo "[1/4] Updating Admin Credentials...\n";
User::updateOrCreate(
    ['email' => 'admin@gmail.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('123456'),
    ]
);

// 3. Clear Existing Data
echo "[2/4] Clearing Existing Data...\n";
DB::statement('PRAGMA foreign_keys = OFF;');
Soldier::truncate();
Unit::truncate();
DB::statement('PRAGMA foreign_keys = ON;');

// 4. Build Organizational Units (Level 1-4)
echo "[3/4] Building Organizational Units in 'units' table...\n";

$targetSectionId = null;

// A. Battalion (Level 1)
$battalion = Unit::create([
    'name' => '9 E Bengal',
    'type' => 'battalion',
    'appointment' => 'CO',
    'is_active' => true,
]);

$coys = [
    ['id' => 'A', 'name' => 'A Coy', 'full' => 'Alpha Coy'],
    ['id' => 'B', 'name' => 'B Coy', 'full' => 'Bravo Coy'],
    ['id' => 'C', 'name' => 'C Coy', 'full' => 'Charlie Coy'],
    ['id' => 'D', 'name' => 'D Coy', 'full' => 'Delta Coy'],
    ['id' => 'HQ', 'name' => 'HQ Coy', 'full' => 'HQ Coy'],
];

$plats = ['1 PL', '2 PL', '3 PL', 'SP PL', 'Coy HQ'];
$secs = ['1 Sec', '2 Sec', '3 Sec', 'PL HQ'];

foreach ($coys as $c) {
    $coy = Unit::create([
        'parent_id' => $battalion->id,
        'name' => $c['name'],
        'type' => 'company',
        'appointment' => 'OC ' . $c['id'],
        'is_active' => true,
    ]);

    foreach ($plats as $pName) {
        $pl = Unit::create([
            'parent_id' => $coy->id,
            'name' => $pName,
            'type' => 'platoon',
            'appointment' => 'PL CDR',
            'is_active' => true,
        ]);

        foreach ($secs as $sName) {
            $section = Unit::create([
                'parent_id' => $pl->id,
                'name' => $sName,
                'type' => 'section',
                'appointment' => 'SEC CDR',
                'is_active' => true,
            ]);

            // Save the target section (A Coy -> 1 PL -> 1 Sec) for the 9 soldiers
            if ($c['name'] === 'A Coy' && $pName === '1 PL' && $sName === '1 Sec') {
                $targetSectionId = $section->id;
            }
        }
    }
}

// 5. Seed the 9 Personnel (Level 5)
echo "[4/4] Seed 9 Personnel in 'soldiers' table (Linked to Unit ID: $targetSectionId)...\n";

$personnel = [
    ['no' => '4069572', 'name' => 'Md. Atiqur Rahman', 'name_bn' => 'মোঃ আতিকুর রহমান', 'rank' => 'Sainik', 'rank_bn' => 'সৈনিক', 'blood' => 'B+', 'district' => 'Naogaon', 'app' => 'LM Gman'],
    ['no' => '4047035', 'name' => 'Md. Al Amin', 'name_bn' => 'মোঃ আল আমিন', 'rank' => 'CPL', 'rank_bn' => 'কর্পোরাল'],
    ['no' => '4072323', 'name' => 'Md. Tuhin Al Mamun', 'name_bn' => 'মোঃ তুহিন আল মামুন', 'rank' => 'UP/ LCPL', 'rank_bn' => 'ইউপি ল্যান্স কর্পোরাল'],
    ['no' => '4064468', 'name' => 'Mo Bashir Mollya Ratan', 'name_bn' => 'মো বশির মোল্যা রতন', 'rank' => 'Sainik', 'rank_bn' => 'সৈনিক'],
    ['no' => '4061682', 'name' => 'Opu Hasan', 'name_bn' => 'অপু হাসান', 'rank' => 'Sainik', 'rank_bn' => 'সৈনিক'],
    ['no' => '4075683', 'name' => 'Md. Didarul Islam', 'rank' => 'Sainik', 'rank_bn' => 'সৈনিক'],
    ['no' => '4060212', 'name' => 'Rashedul islam', 'rank' => 'Sainik', 'rank_bn' => 'সৈনিক'],
    ['no' => '4074383', 'name' => 'Md. Saifur Rahman', 'rank' => 'Sainik', 'rank_bn' => 'সৈনিক'],
    ['no' => '4071124', 'name' => 'Kazi Md. Abid Hossain', 'rank' => 'Sainik', 'rank_bn' => 'সৈনিক'],
];

foreach ($personnel as $p) {
    Soldier::create([
        'unit_id' => $targetSectionId,
        'personal_no' => $p['no'],
        'number' => $p['no'],
        'name' => $p['name'],
        'name_bn' => $p['name_bn'] ?? $p['name'],
        'rank' => $p['rank'],
        'rank_bn' => $p['rank_bn'] ?? $p['rank'],
        'blood_group' => $p['blood'] ?? 'B+',
        'home_district' => $p['district'] ?? 'N/A',
        'appointment' => $p['app'] ?? 'Rifleman',
        'is_active' => true,
    ]);
}

echo "--- SYNC COMPLETE! ---\n\n";
