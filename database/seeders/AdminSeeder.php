<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Soldier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
            ]
        );

        // Clear existing soldiers
        Soldier::truncate();

        // 🎖️ The 9 Real Personnel Data
        $personnel = [
            [
                'personal_no' => '4069572',
                'name' => 'Md. Atiqur Rahman',
                'name_bn' => 'মোঃ আতিকুর রহমান',
                'rank' => 'Sainik',
                'rank_bn' => 'সৈনিক',
                'blood_group' => 'B+',
                'home_district' => 'Naogaon',
                'appointment' => 'LM Gman',
                'appointment_bn' => 'এলএম জিম্যান',
                'batch' => '21',
                'ipft_1_status' => 'Pass',
                'ipft_2_status' => 'Pass',
                'ret_status' => 'Pass',
                'speed_march_status' => '2/4',
                'grenade_firing_status' => '2/4',
                'is_active' => true,
            ],
            [
                'personal_no' => '4047035',
                'name' => 'Md. Al Amin',
                'name_bn' => 'মোঃ আল আমিন',
                'rank' => 'CPL',
                'rank_bn' => 'কর্পোরাল',
                'blood_group' => 'O+',
                'home_district' => 'Feni',
                'appointment' => 'Section Cmdr',
                'batch' => '15',
                'ipft_1_status' => 'Pass',
                'ipft_2_status' => 'Pass',
                'ret_status' => 'Pass',
                'is_active' => true,
            ],
            [
                'personal_no' => '4072323',
                'name' => 'Md. Tuhin Al Mamun',
                'name_bn' => 'মোঃ তুহিন আল মামুন',
                'rank' => 'UP/ LCPL',
                'rank_bn' => 'ইউপি/ এলসিপিএল',
                'blood_group' => 'B+',
                'home_district' => 'Jashore',
                'appointment' => 'Rifleman',
                'appointment_bn' => 'রাইফেলম্যান',
                'batch' => '23',
                'weight' => '60 kg',
                'ipft_1_status' => 'Pass',
                'ipft_2_status' => 'Pass',
                'ret_status' => 'Pass',
                'is_active' => true,
            ],
            [
                'personal_no' => '4064468',
                'name' => 'Mo Bashir Mollya Ratan',
                'name_bn' => 'মো বশির মোল্যা রতন',
                'rank' => 'Sainik',
                'rank_bn' => 'সৈনিক',
                'blood_group' => 'O+',
                'home_district' => 'Faridpur',
                'batch' => '19',
                'ipft_1_status' => 'Pass',
                'ret_status' => 'করিনি',
                'is_active' => true,
            ],
            [
                'personal_no' => '4061682',
                'name' => 'Opu Hasan',
                'name_bn' => 'অপু হাসান',
                'rank' => 'Sainik',
                'rank_bn' => 'সৈনিক',
                'blood_group' => 'A+',
                'home_district' => 'Cumilla',
                'is_active' => true,
            ],
            [
                'personal_no' => '4075683',
                'name' => 'Md. Didarul Islam',
                'name_bn' => 'মোঃ দিদারুল ইসলাম',
                'rank' => 'Sainik',
                'is_active' => true,
            ],
            [
                'personal_no' => '4060212',
                'name' => 'Rashedul islam',
                'is_active' => true,
            ],
            [
                'personal_no' => '4074383',
                'name' => 'Md. Saifur Rahman',
                'name_bn' => 'মোঃ সাইফুর রহমান',
                'is_active' => true,
            ],
            [
                'personal_no' => '4071124',
                'name' => 'Kazi Md. Abid Hossain',
                'is_active' => true,
            ],
        ];

        // 🏗️ Strict 5-Level Hierarchy (Target: Alpha Coy -> 1 Platoon -> 1 Section)
        foreach ($personnel as $p) {
            Soldier::create(array_merge($p, [
                'unit' => '9E Bengal',
                'company' => 'Alpha (A) Coy',
                'platoon' => '1 PL',
                'section' => '1 Sec',
                'number' => $p['personal_no'],
                'user_type' => 'Staff',
            ]));
        }

        $this->command->info('Seeded exactly 9 personnel into Alpha Coy > 1 PL > 1 Sec.');
    }
}
