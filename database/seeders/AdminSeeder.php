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

        // Create sample soldiers
        $soldiers = [
            [
                'name' => 'SGT. Rahman, Abdur',
                'number' => 'BD-001',
                'rank' => 'Sergeant',
                'user_type' => 'CO',
                'company' => 'Alpha',
                'appointment' => 'Platoon Commander',
                'batch' => '2020',
                'blood_group' => 'O+',
                'home_district' => 'Dhaka',
                'ipft_biannual_1' => 'Pass',
                'ipft_biannual_2' => 'Pass',
                'shoot_ret' => '85',
                'shoot_ap' => '78',
                'shoot_ets' => '90',
                'shoot_total' => '253',
                'speed_march' => 'Pass',
                'grenade_fire' => 'Pass',
                'course_status' => 'Completed',
                'commander_status' => 'Approved',
                'leave_plan' => 'Planned for Dec 2026',
                'sports_participation' => 'Football, Volleyball',
                'nil_fire' => 'None',
            ],
            [
                'name' => 'CPL. Islam, Md. Nazrul',
                'number' => 'BD-002',
                'rank' => 'Corporal',
                'user_type' => 'Staff',
                'company' => 'Bravo',
                'appointment' => 'Section Commander',
                'batch' => '2021',
                'blood_group' => 'A+',
                'home_district' => 'Chittagong',
                'ipft_biannual_1' => 'Pass',
                'ipft_biannual_2' => 'Fail',
                'shoot_ret' => '75',
                'shoot_ap' => '80',
                'shoot_ets' => '70',
                'shoot_total' => '225',
                'speed_march' => 'Pass',
                'grenade_fire' => 'Pass',
                'course_status' => 'In Progress',
                'commander_status' => 'Pending',
                'leave_plan' => 'Planned for Aug 2026',
                'sports_participation' => 'Basket Ball',
                'nil_fire' => 'None',
            ],
            [
                'name' => 'PVT. Hossain, Kamal',
                'number' => 'BD-003',
                'rank' => 'Private',
                'user_type' => 'CO',
                'company' => 'Charlie',
                'appointment' => 'Rifleman',
                'batch' => '2022',
                'blood_group' => 'B+',
                'home_district' => 'Sylhet',
                'ipft_biannual_1' => 'Pass',
                'ipft_biannual_2' => 'Pass',
                'shoot_ret' => '92',
                'shoot_ap' => '88',
                'shoot_ets' => '95',
                'shoot_total' => '275',
                'speed_march' => 'Pass',
                'grenade_fire' => 'Fail',
                'course_status' => 'Completed',
                'commander_status' => 'Approved',
                'leave_plan' => 'Planned for June 2026',
                'sports_participation' => 'Cricket',
                'nil_fire' => 'None',
            ],
            [
                'name' => 'LT. Ahmed, Farhan',
                'number' => 'BD-004',
                'rank' => 'Lieutenant',
                'user_type' => 'Staff',
                'company' => 'HQ',
                'appointment' => 'Intelligence Officer',
                'batch' => '2019',
                'blood_group' => 'AB+',
                'home_district' => 'Rajshahi',
                'ipft_biannual_1' => 'Pass',
                'ipft_biannual_2' => 'Pass',
                'shoot_ret' => '95',
                'shoot_ap' => '92',
                'shoot_ets' => '98',
                'shoot_total' => '285',
                'speed_march' => 'Pass',
                'grenade_fire' => 'Pass',
                'course_status' => 'Completed',
                'commander_status' => 'Approved',
                'leave_plan' => 'Planned for Nov 2026',
                'sports_participation' => 'Tennis',
                'nil_fire' => 'None',
            ],
            [
                'name' => 'SGT. Khan, Mizanur',
                'number' => 'BD-005',
                'rank' => 'Sergeant',
                'user_type' => 'CO',
                'company' => 'Delta',
                'appointment' => 'Medical Sergeant',
                'batch' => '2020',
                'blood_group' => 'O-',
                'home_district' => 'Khulna',
                'ipft_biannual_1' => 'Fail',
                'ipft_biannual_2' => 'Pass',
                'shoot_ret' => '70',
                'shoot_ap' => '65',
                'shoot_ets' => '72',
                'shoot_total' => '207',
                'speed_march' => 'Fail',
                'grenade_fire' => 'Pass',
                'course_status' => 'Not Started',
                'commander_status' => 'Pending',
                'leave_plan' => 'Planned for Sept 2026',
                'sports_participation' => 'Badminton',
                'nil_fire' => 'None',
            ],
        ];

        foreach ($soldiers as $soldier) {
            Soldier::create($soldier);
        }
    }
}
