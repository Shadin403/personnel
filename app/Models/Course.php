<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'soldier_id',
        'name',
        'chance',
        'year',
        'result',
        'authority',
    ];

    public function soldier()
    {
        return $this->belongsTo(Soldier::class);
    }
}
