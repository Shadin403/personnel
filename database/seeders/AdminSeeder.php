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
            'number' => 'HQ-001',
            'rank' => 'Lt Col',
            'unit_type' => 'officer',
            'appointment' => 'CO: Lt Col Mahfuzur Rahman',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // 2. Alpha Company
        $coy = Soldier::create([
            'name' => 'ALPHA COMPANY',
            'number' => 'COY-ALPHA',
            'rank' => 'Major',
            'parent_id' => $root->id,
            'unit_type' => 'company',
            'appointment' => 'OC: Maj Tanvir Ahmed',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // 3. Company Level Units
        // 3.1 Company Headquarter (CHQ)
        $chq = Soldier::create([
            'name' => 'COMPANY HQ (CHQ)',
            'number' => 'CHQ-001',
            'rank' => 'MWO',
            'parent_id' => $coy->id,
            'unit_type' => 'platoon',
            'appointment' => 'CHM: MWO Karim Uddin',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // 3.2 Support Platoon
        $supportPl = Soldier::create([
            'name' => 'SUPPORT PLATOON',
            'number' => 'SUP-PL',
            'rank' => 'Captain',
            'parent_id' => $coy->id,
            'unit_type' => 'platoon',
            'appointment' => 'PL CDR: Captain Sifat Hasan',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // 3.3 Numbered Platoons
        for ($p = 1; $p <= 3; $p++) {
            $pl = Soldier::create([
                'name' => "$p PLATOON",
                'number' => "PL-00$p",
                'rank' => 'Lieutenant',
                'parent_id' => $coy->id,
                'unit_type' => 'platoon',
                'appointment' => "PL CDR: Lieutenant Faisal ($p PL)",
                'is_active' => true,
                'sort_order' => $p + 2,
            ]);

            // 4. Sections for Platoon 1
            if ($p === 1) {
                for ($s = 1; $s <= 3; $s++) {
                    $sec = Soldier::create([
                        'name' => "SECTION $s",
                        'number' => "SEC-00$s",
                        'rank' => 'Sergeant',
                        'parent_id' => $pl->id,
                        'unit_type' => 'section',
                        'appointment' => "SEC CDR: Sgt Nazmul",
                        'is_active' => true,
                        'sort_order' => $s,
                    ]);

                    // 5. Soldiers for ALL Sections
                    for ($sol = 1; $sol <= 3; $sol++) {
                        Soldier::create([
                            'name' => "Soldier No. $sol (SEC $s)",
                            'number' => "10254" . $s . $sol,
                            'rank' => 'Sainik',
                            'parent_id' => $sec->id,
                            'unit_type' => 'soldier',
                            'appointment' => 'Rifleman',
                            'is_active' => true,
                            'sort_order' => $sol,
                            'ipft_biannual_1' => 'Excellent',
                            'shoot_total' => '245',
                        ]);
                    }
                }
            }
        }
    }
}
