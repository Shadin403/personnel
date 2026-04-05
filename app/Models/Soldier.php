<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soldier extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'name',
        'name_bn',
        'number',
        'personal_no',
        'rank',
        'rank_bn',
        'user_type',
        'company',
        'platoon',
        'section',
        'appointment',
        'appointment_bn',
        'batch',
        'blood_group',
        'home_district',
        'photo',
        'enrolment_date',
        'rank_date',
        'civil_education',
        'weight',
        'permanent_address',
        'unit',
        'sub_unit',
        'ipft_biannual_1',
        'ipft_biannual_2',
        'ipft_1_status',
        'ipft_2_status',
        'ret_status',
        'shoot_ret',
        'shoot_ap',
        'shoot_ets',
        'shoot_total',
        'speed_march',
        'speed_march_status',
        'grenade_fire',
        'grenade_firing_status',
        'ni_firing_status',
        'course_status',
        'commander_status',
        'cdr_plan_this_yr',
        'leave_plan',
        'sports_participation',
        'nil_fire',
        'is_active',
        'sort_order',
        'father_name',
        'mother_name',
        'spouse_name',
        'religion',
        'gender',
        'marital_status',
        'dob',
        'nid',
        'special_courses',
        'annual_career_plans',
        'field_trainings_summer',
        'field_trainings_winter',
        'firing_records',
        'firing_date',
        'night_firing_records',
        'night_trainings',
        'group_trainings',
        'cycle_ending_exercises',
        'height_inch',
        'waist_inch',
        'hip_inch',
        'wrist_cm',
        'is_pregnant',
        'is_athlete',
        'medical_not_obese',
    ];

    public function getAgeAttribute(): int
    {
        return $this->dob ? $this->dob->age : 0;
    }

    public function getBodyFrameAttribute(): string
    {
        if (!$this->wrist_cm) return 'Standard';
        
        $threshold = ($this->gender === 'Female') ? 15 : 17;
        return $this->wrist_cm >= $threshold ? 'Large' : 'Standard';
    }

    public function getWhrAttribute(): ?float
    {
        if (!$this->waist_inch || !$this->hip_inch || $this->hip_inch == 0) return null;
        return round($this->waist_inch / $this->hip_inch, 2);
    }

    public function getWeightAllowanceAttribute(): int
    {
        $allowance = 0;
        
        // Body Frame Allowance
        if ($this->body_frame === 'Large') {
            $allowance += 4.5; // 10lb approx 4.5kg
        }

        // Athlete Allowance (Boxer/Wrestler/Weightlifter)
        if ($this->is_athlete) {
            $allowance += 9.1; // 20lb approx 9.1kg
        }

        // Special Medical/PET Allowance
        if ($this->medical_not_obese) {
            $allowance += 6.8; // 15lb approx 6.8kg
        }

        return $allowance;
    }

    public function getStandardWeightAttribute(): ?int
    {
        if (!$this->height_inch) return null;

        $h = (int) $this->height_inch;
        $age = $this->age;

        // Weight Chart Lookup (Upper limits from manual chart, converted to KG)
        // Format: Height => [Age<=30, Age 31-40, Age 41-50]
        $chart = [
            62 => [59.4, 63.5, 67.6],
            63 => [61.2, 65.3, 69.8],
            64 => [63.5, 67.6, 72.1],
            65 => [65.3, 69.8, 74.4],
            66 => [67.1, 71.7, 76.2],
            67 => [68.5, 73.0, 78.0],
            68 => [69.4, 73.5, 77.6],
            69 => [71.7, 76.2, 80.7],
            70 => [73.5, 78.0, 83.0],
            71 => [75.3, 80.3, 84.8],
            72 => [77.6, 82.1, 87.1],
        ];

        // Find closest height or floor to nearest inch
        $targetH = max(62, min(72, $h));
        $row = $chart[$targetH] ?? $chart[62];

        if ($age <= 30) return $row[0];
        if ($age <= 40) return $row[1];
        return $row[2];
    }

    public function getWeightStatusAttribute(): string
    {
        // 1. WHR Obesity Check (Absolute Override)
        $whr = $this->whr;
        if ($whr > 1.0) return 'Obese (WHR)';

        // 2. Weight Check
        if (!$this->weight || !$this->standard_weight) return 'N/A';

        // Extract numeric weight
        preg_match('/(\d+)/', $this->weight, $matches);
        $actualWeight = isset($matches[1]) ? (int) $matches[1] : 0;
        if ($actualWeight === 0) return 'N/A';

        // Dress subtraction (3.2 KG approx 7 lbs)
        $adjustedWeight = $actualWeight - 3.2;
        
        $std = $this->standard_weight;
        $allowance = $this->weight_allowance;
        $limit = $std + $allowance;

        if ($adjustedWeight < 45) return 'Underweight'; // Generic floor (45kg/100lb)
        if ($adjustedWeight > $limit + 6.8) return 'Obese'; // +15lb approx 6.8kg
        if ($adjustedWeight > $limit) return 'Overweight';
        
        return 'Normal';
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    protected $casts = [
        'is_active' => 'boolean',
        'enrolment_date' => 'date',
        'rank_date' => 'date',
        'dob' => 'date',
        'special_courses' => 'array',
        'annual_career_plans' => 'array',
        'field_trainings_summer' => 'array',
        'field_trainings_winter' => 'array',
        'firing_records' => 'array',
        'firing_date' => 'date',
        'night_firing_records' => 'array',
        'night_trainings' => 'array',
        'group_trainings' => 'array',
        'cycle_ending_exercises' => 'array',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        // Generate a dynamic placeholder using the soldier's name
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=2F4F3E&color=fff&bold=true";
    }

    public function getShootingGradeAttribute(): string
    {
        $total = (int) $this->shoot_total;
        if ($total >= 270) return 'Expert';
        if ($total >= 240) return 'Sharpshooter';
        if ($total >= 210) return 'Marksman';
        return 'Trainee';
    }

    /**
     * Strategic Battalion Resolver.
     * Recursively traverses up the unit hierarchy to find the top-level Battalion.
     */
    public function getBattalionNameAttribute(): string
    {
        $unit = $this->unit()->first(); // Avoid collision with 'unit' column
        if (!$unit) return 'Unmapped';

        // Traverse up to find the Battalion level or the root unit
        $current = $unit;
        while ($current) {
            if ($current->type === 'battalion') {
                return $current->name;
            }
            if (!$current->parent_id) {
                return $current->name;
            }
            $current = $current->parent;
        }

        return $unit->name;
    }

    public function getOverallStatusAttribute(): string
    {
        $checks = [
            $this->ipft_biannual_1 === 'Pass',
            $this->ipft_biannual_2 === 'Pass',
            $this->speed_march === 'Pass',
            $this->grenade_fire === 'Pass',
        ];

        $passed = array_sum($checks);
        $total = count($checks);

        if ($passed === $total) return 'Excellent';
        if ($passed >= $total * 0.75) return 'Good';
        if ($passed >= $total * 0.5) return 'Average';
        return 'Needs Improvement';
    }

    public function parent()
    {
        return $this->belongsTo(Soldier::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Soldier::class, 'parent_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function trainingPlans()
    {
        return $this->hasMany(TrainingPlan::class);
    }

    public function unitTrainings()
    {
        return $this->hasMany(UnitTraining::class);
    }
}
