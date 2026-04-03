<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 🏗️ Fetch all records that form the hierarchy (Companies, Platoons, Sections + Soldiers)
        $soldiers = Soldier::all();
        
        $treeNodes = $soldiers->map(function ($s) {
            return [
                'id' => $s->unit_type === 'soldier' ? 'sol_' . $s->id : (int)$s->id,
                'pid' => (int)$s->parent_id,
                'name' => $s->name,
                'rank' => $s->rank,
                'number' => $s->number,
                'appointment' => $s->appointment ?? 'N/A',
                'img' => $s->photo_url,
                'profile_url' => $s->unit_type === 'soldier' ? route('admin.soldiers.show', $s->id) : '#',
                'unit_type' => $s->unit_type
            ];
        });

        return view('admin.dashboard', compact('treeNodes'));
    }
}
