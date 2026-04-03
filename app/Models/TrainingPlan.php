<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'soldier_id',
        'year',
        'annual_leave',
        'unit_training',
        'personal_training',
        'administration',
        'mootw',
    ];

    public function soldier()
    {
        return $this->belongsTo(Soldier::class);
    }
}
