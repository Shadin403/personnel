<?php

namespace Database\Factories;

use App\Models\Soldier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Soldier>
 */
class SoldierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ranks = ['Sainik', 'L/CPL', 'CPL', 'SGT'];
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

        return [
            'name' => $this->faker->name,
            'personal_no' => (string) $this->faker->unique()->numberBetween(4000000, 4999999),
            'number' => (string) $this->faker->numberBetween(4000000, 4999999),
            'rank' => $this->faker->randomElement($ranks),
            'user_type' => 'Staff',
            'appointment' => 'Rifleman',
            'batch' => (string) $this->faker->numberBetween(10, 30),
            'blood_group' => $this->faker->randomElement($bloodGroups),
            'home_district' => $this->faker->city,
            'ipft_1_status' => 'Pass',
            'ipft_2_status' => 'Pass',
            'ret_status' => 'Pass',
            'speed_march_status' => '2/4',
            'is_active' => true,
        ];
    }
}
