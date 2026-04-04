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
    ];

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
