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

        // 1. Root Officer (CO)
        $root = Soldier::create([
            'name' => 'Lt Col Mahfuzur Rahman',
            'number' => 'BA-7241',
            'rank' => 'Lt Col',
            'unit_type' => 'officer',
            'appointment' => 'Commanding Officer (9EB)',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // 2. Alpha Company (Coy Cdr)
        $coy = Soldier::create([
            'name' => 'Maj Tanvir Ahmed',
            'number' => 'BA-8512',
            'rank' => 'Major',
            'parent_id' => $root->id,
            'unit_type' => 'company',
            'appointment' => 'Alpha Company Commander',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // 3. Company Level Units
        // 3.1 Company Headquarter (CHQ)
        $chq = Soldier::create([
            'name' => 'MWO Karim Uddin',
            'number' => '7045123',
            'rank' => 'MWO',
            'parent_id' => $coy->id,
            'unit_type' => 'officer', // Using officer style for CHQ head
            'appointment' => 'CHM (Company HQ)',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // 3.2 Support Platoon
        $supportPl = Soldier::create([
            'name' => 'Captain Sifat Hasan',
            'number' => 'BA-9642',
            'rank' => 'Captain',
            'parent_id' => $coy->id,
            'unit_type' => 'platoon',
            'appointment' => 'Support Platoon Commander',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // 3.3 Numbered Platoons
        for ($p = 1; $p <= 3; $p++) {
            $pl = Soldier::create([
                'name' => "Lieutenant Faisal ($p PL)",
                'number' => "BA-102$p",
                'rank' => 'Lieutenant',
                'parent_id' => $coy->id,
                'unit_type' => 'platoon',
                'appointment' => "Platoon Commander ($p PL)",
                'is_active' => true,
                'sort_order' => $p + 2, // PL 1 starts at 3
            ]);

            // 4. Sections for Platoon 1
            if ($p === 1) {
                for ($s = 1; $s <= 3; $s++) {
                    $sec = Soldier::create([
                        'name' => "Sgt Nazmul (Section $s)",
                        'number' => "SN-500$s",
                        'rank' => 'Sergeant',
                        'parent_id' => $pl->id,
                        'unit_type' => 'section',
                        'appointment' => "Section Commander ($s SEC)",
                        'is_active' => true,
                        'sort_order' => $s,
                    ]);

                    // 5. Soldiers for Section 1
                    if ($s === 1) {
                        for ($sol = 1; $sol <= 3; $sol++) {
                            Soldier::create([
                                'name' => "Soldier No. $sol",
                                'number' => "10254$sol",
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
}
