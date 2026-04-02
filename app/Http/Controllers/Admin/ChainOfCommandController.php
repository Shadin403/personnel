<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use Illuminate\Http\Request;

class ChainOfCommandController extends Controller
{
    public function index()
    {
        $soldiers = Soldier::all()->map(function ($soldier) {
            return [
                'id' => $soldier->id,
                'pid' => $soldier->parent_id,
                'name' => $soldier->name,
                'title' => $soldier->rank . ' - ' . $soldier->appointment,
                'unit_type' => $soldier->unit_type,
                'img' => $soldier->photo_url,
                'profile_url' => route('admin.soldiers.show', $soldier->id),
                'tags' => [$soldier->unit_type ?? 'soldier'],
            ];
        });

        return view('admin.soldiers.tree', compact('soldiers'));
    }
}
