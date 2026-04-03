<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'soldier_id',
        'year',
        'cycle',
        'appointment',
        'standard_remarks',
    ];

    public function soldier()
    {
        return $this->belongsTo(Soldier::class);
    }
}
