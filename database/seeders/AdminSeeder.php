<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Soldier;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing soldiers to avoid duplicates
        Soldier::truncate();

        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
            ]
        );

        // 1. Root Office (HQ)
        $root = Soldier::create([
            'name' => 'BATTALION HQ',
            'number' => '9EB-HQ',
            'rank' => 'Lt Col',
            'unit_type' => 'officer',
            'appointment' => 'CO: Lt Col Mahfuzur Rahman',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Define the structure
        $companies = [
            ['name' => 'A Coy', 'id' => 'COY-A', 'commander' => 'Major Tanvir'],
            ['name' => 'B Coy', 'id' => 'COY-B', 'commander' => 'Major Sadat'],
            ['name' => 'C Coy', 'id' => 'COY-C', 'commander' => 'Major Rakib'],
            ['name' => 'D Coy', 'id' => 'COY-D', 'commander' => 'Major Nafis'],
            ['name' => 'HQ Coy', 'id' => 'COY-HQ', 'commander' => 'Major Arif'],
        ];

        $platoonNames = ['1 PL', '2 PL', '3 PL', 'SP PL', 'Coy HQ'];
        $sectionNames = ['1 Sec', '2 Sec', '3 Sec', 'PL HQ'];

        foreach ($companies as $cIndex => $cData) {
            // Level 2: Company
            $coy = Soldier::create([
                'name' => $cData['name'],
                'number' => $cData['id'],
                'rank' => 'Major',
                'parent_id' => $root->id,
                'unit_type' => 'company',
                'appointment' => "OC: {$cData['commander']}",
                'is_active' => true,
                'sort_order' => $cIndex + 1,
            ]);

            foreach ($platoonNames as $pIndex => $pName) {
                // Level 3: Platoon
                $pl = Soldier::create([
                    'name' => $pName,
                    'number' => "{$cData['id']}-{$pName}",
                    'rank' => 'Lieutenant',
                    'parent_id' => $coy->id,
                    'unit_type' => 'platoon',
                    'appointment' => "PL CDR: Lt. Faisal ({$pName})",
                    'is_active' => true,
                    'sort_order' => $pIndex + 1,
                ]);

                foreach ($sectionNames as $sIndex => $sName) {
                    // Level 4: Section
                    $sec = Soldier::create([
                        'name' => $sName,
                        'number' => "{$cData['id']}-{$pName}-{$sName}",
                        'rank' => 'Sergeant',
                        'parent_id' => $pl->id,
                        'unit_type' => 'section',
                        'appointment' => "SEC CDR: Sgt Nazmul",
                        'is_active' => true,
                        'sort_order' => $sIndex + 1,
                    ]);

                    // Level 5: Personnel (9 members per section)
                    for ($sol = 1; $sol <= 9; $sol++) {
                        Soldier::create([
                            'name' => "Soldier $sol ({$sName})",
                            'number' => "SN-" . ($cIndex + 1) . ($pIndex + 1) . ($sIndex + 1) . $sol,
                            'rank' => 'Sainik',
                            'parent_id' => $sec->id,
                            'unit_type' => 'soldier',
                            'appointment' => 'Rifleman',
                            'is_active' => true,
                            'sort_order' => $sol,
                            'ipft_biannual_1' => 'Pass',
                            'ipft_biannual_2' => 'Pass',
                            'speed_march' => 'Pass',
                            'grenade_fire' => 'Pass',
                        ]);
                    }
                }
            }
        }
    }
}
