<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $treeNodes = [];

        // 1. Fetch Units (Level 1-4)
        $units = Unit::all();
        foreach ($units as $u) {
            $treeNodes[] = [
                'id' => (int)$u->id,
                'pid' => (int)$u->parent_id,
                'name' => $u->name,
                'rank' => $u->appointment, // Using appointment for additional info
                'unit_type' => $u->type,
                'appointment' => $u->appointment,
                'img' => null, // Units don't have photos
                'profile_url' => '#'
            ];
        }

        // 2. Fetch Soldiers (Level 5)
        $soldiers = Soldier::all();
        foreach ($soldiers as $s) {
            $treeNodes[] = [
                'id' => 'sol_' . $s->id,
                'pid' => (int)$s->unit_id,
                'name' => $s->name,
                'rank' => $s->rank,
                'number' => $s->number,
                'appointment' => $s->appointment ?? 'Rifleman',
                'unit_type' => 'soldier',
                'img' => $s->photo_url,
                'profile_url' => route('admin.soldiers.show', $s->id)
            ];
        }

        return view('admin.dashboard', compact('treeNodes'));
    }
}
