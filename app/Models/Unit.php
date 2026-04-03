<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'type',
        'appointment',
        'sort_order',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Unit::class, 'parent_id')->orderBy('sort_order');
    }

    public function soldiers()
    {
        return $this->hasMany(Soldier::class, 'unit_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
