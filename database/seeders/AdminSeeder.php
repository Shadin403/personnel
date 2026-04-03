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
        // Clear existing data
        Soldier::truncate();

        // Ensure Admin user exists
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
            ]
        );

        // 1. Root Unit (HQ)
        $hq = Soldier::create([
            'name' => 'BATTALION HQ',
            'number' => '9EB-HQ',
            'rank' => 'Lt Col',
            'unit_type' => 'officer',
            'appointment' => 'CO: Commanding Officer',
            'is_active' => true,
        ]);

        // 2. Company Node
        $coy = Soldier::create([
            'name' => 'Alpha Coy',
            'number' => 'COY-A',
            'rank' => 'Major',
            'parent_id' => $hq->id,
            'unit_type' => 'company',
            'appointment' => 'OC: Major Tanvir',
            'is_active' => true,
        ]);

        // 3. Platoon Node
        $pl = Soldier::create([
            'name' => '1 PL',
            'number' => 'PL-1',
            'rank' => 'Subedar',
            'parent_id' => $coy->id,
            'unit_type' => 'platoon',
            'appointment' => 'PL CDR: Subedar Rahim',
            'is_active' => true,
        ]);

        // 4. Section Node (Lead by Corporal Al Amin)
        $sec = Soldier::create([
            'name' => '1 Sec',
            'number' => 'SEC-1',
            'rank' => 'Corporal',
            'parent_id' => $pl->id,
            'unit_type' => 'section',
            'appointment' => 'Section Commander',
            'is_active' => true,
        ]);

        // REAL SOLDIER DATA (7 Records)
        
        // 1. Md. Atiqur Rahman
        $atiqur = Soldier::create([
            'name' => 'Md. Atiqur Rahman (মোঃ আতিকুর রহমান)',
            'number' => '4069572',
            'rank' => 'Sainik (সৈনিক)',
            'parent_id' => $sec->id,
            'unit_type' => 'soldier',
            'user_type' => 'Staff',
            'blood_group' => 'B+',
            'home_district' => 'Naogaon (নওগাঁ)',
            'appointment' => 'LM Gman (এলএম জিম্যান)',
            'batch' => '21',
            'ipft_biannual_1' => 'Pass',
            'ipft_biannual_2' => 'Pass',
            'shoot_ret' => 'Pass', // RET
            'speed_march' => '2/4',
            'sports_participation' => 'Kabaddi and Athletics (কাবাডি এবং অ্যাথলেটিক্স)',
            'course_status' => 'RGW90',
            'leave_plan' => '3rd Cycle (৩য় চক্র)',
            'weight' => '81',
            'is_active' => true,
        ]);

        // 2. Md. Ariful Islam
        $ariful = Soldier::create([
            'name' => 'Md. Ariful Islam (মো আরিফুল ইসলাম)',
            'number' => '4071124',
            'rank' => 'Sainik (সৈনিক)',
            'parent_id' => $sec->id,
            'unit_type' => 'soldier',
            'user_type' => 'Staff',
            'blood_group' => 'A+',
            'home_district' => 'Sirajganj (সিরাজগঞ্জ)',
            'appointment' => 'LM Gman 2 (এলএম জিম্যান২)',
            'batch' => '22',
            'ipft_biannual_1' => 'Pass',
            'ipft_biannual_2' => 'Pass',
            'shoot_ret' => 'Pass',
            'speed_march' => '2/4',
            'sports_participation' => 'Basketball (বাস্কেট বল)',
            'course_status' => 'INT',
            'leave_plan' => '2nd Cycle (২য় চক্র)',
            'weight' => '70',
            'is_active' => true,
        ]);

        // 3. Md. Didarul Islam
        $didarul = Soldier::create([
            'name' => 'Md. Didarul Islam (মোঃ দিদারুল ইসলাম)',
            'number' => '4075683',
            'rank' => 'Sainik (সৈনিক)',
            'parent_id' => $sec->id,
            'unit_type' => 'soldier',
            'user_type' => 'Staff',
            'blood_group' => 'B+',
            'home_district' => 'Nilphamari (নীলফামারী)',
            'appointment' => 'GF Man (জি এফ ম্যান)',
            'batch' => '25',
            'ipft_biannual_1' => 'Pass',
            'ipft_biannual_2' => 'Pass',
            'shoot_ret' => 'Pass',
            'speed_march' => '2/4',
            'sports_participation' => 'Bayonet Fighting (বেয়নেট ফাইটিং)',
            'weight' => '60 kg',
            'is_active' => true,
        ]);

        // 4. Rashedul islam
        $rashedul = Soldier::create([
            'name' => 'Rashedul islam',
            'number' => '4060212',
            'rank' => 'Sainik (সৈনিক)',
            'parent_id' => $sec->id,
            'unit_type' => 'soldier',
            'user_type' => 'Staff',
            'blood_group' => 'O+',
            'home_district' => 'Ctg',
            'appointment' => 'Ranar/Operator',
            'batch' => '17-2',
            'ipft_biannual_1' => 'Pass',
            'ipft_biannual_2' => 'Pass',
            'shoot_ret' => 'Pass',
            'speed_march' => '2/4',
            'sports_participation' => 'Nai',
            'course_status' => 'Metis+CIED',
            'leave_plan' => '3th Cycle (৩য় চক্র)',
            'weight' => '72kg',
            'is_active' => true,
        ]);

        // 5. Md. Saifur Rahman
        $saifur = Soldier::create([
            'name' => 'Md. Saifur Rahman (মোঃ সাইফুর রহমান)',
            'number' => '4074383',
            'rank' => 'Sainik (সৈনিক)',
            'parent_id' => $sec->id,
            'unit_type' => 'soldier',
            'user_type' => 'Staff',
            'blood_group' => 'A+',
            'home_district' => 'Patuakhali (পটুয়াখালী)',
            'appointment' => 'LM Gman 2 (এলএম জিম্যান২)',
            'batch' => '24',
            'ipft_biannual_1' => 'Pass',
            'ipft_biannual_2' => 'Pass',
            'shoot_ret' => 'Pass',
            'speed_march' => '2/4',
            'sports_participation' => 'Firing Team (ফায়ারিং টিম)',
            'course_status' => 'Marksman/Cadre',
            'leave_plan' => '2nd Cycle (২য় চক্র)',
            'weight' => '62 kg',
            'shoot_ap' => '3/5', // Night Fire
            'is_active' => true,
        ]);

        // 6. Corporal Md. Al Amin (Also listed as Section Commander in input)
        $alamin = Soldier::create([
            'name' => 'Md. Al Amin (মোঃ আল আমিন)',
            'number' => '4047035',
            'rank' => 'Corporal (কর্পোরাল)',
            'parent_id' => $sec->id,
            'unit_type' => 'soldier',
            'user_type' => 'Staff',
            'blood_group' => 'A Negative (এ নেগেটিভ)',
            'home_district' => 'Cumilla, Debidwar (কুমিল্লা, দেবিদ্বার)',
            'appointment' => 'Section Commander (সেকশন কমান্ডার)',
            'batch' => '67, 2007',
            'ipft_biannual_1' => 'Pass',
            'ipft_biannual_2' => 'Pass',
            'shoot_ret' => 'Pass',
            'speed_march' => '2/4',
            'sports_participation' => 'Boxing (বক্সিং)',
            'course_status' => 'DIC 62, ATWPF 98, BTT, Commando, PC, ATT, Promotion Related.',
            'cdr_plan_this_yr' => 'UT in 4th Cycle (২০২৬ সালে ৪র্থ চক্রে ইউ টি)',
            'leave_plan' => '1st Cycle (১ম চক্রে)',
            'weight' => '74',
            'is_active' => true,
        ]);

        // 7. Opu Hasan
        $opu = Soldier::create([
            'name' => 'Opu Hasan (অপু হাসান)',
            'number' => '4061682',
            'rank' => 'Sainik (সৈনিক)',
            'parent_id' => $sec->id,
            'unit_type' => 'soldier',
            'user_type' => 'Staff',
            'blood_group' => 'B+',
            'home_district' => 'Natore (নাটোর)',
            'appointment' => 'LM Gman (এলএম জিম্যান)',
            'batch' => '18-1',
            'ipft_biannual_1' => 'Pass',
            'ipft_biannual_2' => 'Pass',
            'shoot_ret' => 'Pass',
            'sports_participation' => 'Football, Athletic (ফুটবল, এ্যাথলেটিক)',
            'course_status' => 'First Aid, ATGW',
            'cdr_plan_this_yr' => 'BMR in 2nd Cycle (দ্বিতীয় চক্রে বিএমআর)',
            'leave_plan' => '1st Cycle (১ম চক্র")',
            'weight' => '70 kg',
            'is_active' => true,
        ]);
        
        // Add Detailed Course History for Corporal Al Amin
        $alamin->courses()->createMany([
            ['name' => 'DIC 62', 'year' => '2010', 'result' => 'Graduated'],
            ['name' => 'ATWPF 98', 'year' => '2012', 'result' => 'Good'],
            ['name' => 'Commando', 'year' => '2015', 'result' => 'Ex'],
        ]);
    }
}
