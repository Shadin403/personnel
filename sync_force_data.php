<?php

/**
 * 🎖️ Force Navigator Deployment Script (V2 - Persistent Hierarchy)
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
use Illuminate\Support\Facades\DB;

echo "\n--- STARTING PERSISTENT HIERARCHY SYNC ---\n";

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
DB::statement('PRAGMA foreign_keys = ON;');

// 4. Build Persistent Hierarchy
echo "[3/4] Creating Organizational Units (Companies, Platoons, Sections)...\n";

$targetSectionId = null;

// A. Battalion (Level 1)
$battalion = Soldier::create([
    'name' => '9 E Bengal',
    'number' => '9EB',
    'rank' => 'Battalion',
    'unit_type' => 'battalion',
    'is_active' => true,
]);

$coys = [
    ['short' => 'A Coy', 'full' => 'Alpha Coy'],
    ['short' => 'B Coy', 'full' => 'Bravo Coy'],
    ['short' => 'C Coy', 'full' => 'Charlie Coy'],
    ['short' => 'D Coy', 'full' => 'Delta Coy'],
    ['short' => 'HQ Coy', 'full' => 'HQ Coy'],
];

$plats = ['1 PL', '2 PL', '3 PL', 'SP PL', 'Coy HQ'];
$secs = ['1 Sec', '2 Sec', '3 Sec', 'PL HQ'];

foreach ($coys as $c) {
    $coy = Soldier::create([
        'parent_id' => $battalion->id,
        'name' => $c['short'],
        'number' => $c['short'],
        'rank' => $c['full'],
        'unit_type' => 'company',
        'appointment' => 'OC ' . explode(' ', $c['short'])[0],
        'is_active' => true,
    ]);

    foreach ($plats as $pIdx => $pName) {
        $pl = Soldier::create([
            'parent_id' => $coy->id,
            'name' => $pName,
            'number' => $c['short'] . '-' . $pName,
            'unit_type' => 'platoon',
            'appointment' => 'PL CDR',
            'is_active' => true,
        ]);

        foreach ($secs as $sIdx => $sName) {
            $section = Soldier::create([
                'parent_id' => $pl->id,
                'name' => $sName,
                'number' => $c['short'] . '-' . $pName . '-' . $sName,
                'unit_type' => 'section',
                'appointment' => 'SEC CDR',
                'is_active' => true,
            ]);

            // Save the target section (Alpha Coy -> 1 PL -> 1 Sec) for the 9 soldiers
            if ($c['short'] === 'A Coy' && $pName === '1 PL' && $sName === '1 Sec') {
                $targetSectionId = $section->id;
            }
        }
    }
}

// 5. Seed the 9 Personnel (Level 5)
echo "[4/4] Mapping 9 Real Personnel to " . ($targetSectionId ? 'A Coy > 1 PL > 1 Sec' : 'NULL') . "...\n";

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
        'parent_id' => $targetSectionId,
        'personal_no' => $p['no'],
        'number' => $p['no'],
        'name' => $p['name'],
        'name_bn' => $p['name_bn'] ?? $p['name'],
        'rank' => $p['rank'],
        'rank_bn' => $p['rank_bn'] ?? $p['rank'],
        'blood_group' => $p['blood'] ?? 'B+',
        'home_district' => $p['district'] ?? 'N/A',
        'appointment' => $p['app'] ?? 'Rifleman',
        'unit_type' => 'soldier',
        'is_active' => true,
    ]);
}

echo "--- SYNC COMPLETE! ---\n";
echo "--- ADMIN LOGIN: admin@gmail.com / 123456 ---\n\n";
