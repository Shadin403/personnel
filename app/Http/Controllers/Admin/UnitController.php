<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('parent')->orderBy('type')->orderBy('name')->paginate(20);
        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        $parents = Unit::whereIn('type', ['battalion', 'company', 'platoon'])->get();
        return view('admin.units.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:battalion,company,platoon,section',
            'parent_id' => 'nullable|exists:units,id',
            'appointment' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        Unit::create($validated);

        return redirect()->route('admin.units.index')->with('success', 'Organizational unit established successfully.');
    }

    public function edit(Unit $unit)
    {
        $parents = Unit::where('id', '!=', $unit->id)
            ->whereIn('type', ['battalion', 'company', 'platoon'])
            ->get();
        return view('admin.units.edit', compact('unit', 'parents'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:battalion,company,platoon,section',
            'parent_id' => 'nullable|exists:units,id',
            'appointment' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $unit->update($validated);

        return redirect()->route('admin.units.index')->with('success', 'Organizational unit updated.');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->children()->count() > 0 || $unit->soldiers()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot dissolve unit: Sub-units or personnel are still linked.');
        }

        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'Organizational unit dissolved.');
    }
}
