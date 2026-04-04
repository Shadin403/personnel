<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use App\Models\Course;
use App\Models\TrainingPlan;
use App\Models\UnitTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Unit;
use App\Helpers\PdfHelper;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class SoldierController extends Controller
{
    public function weak(Request $request)
    {
        $soldiers = Soldier::where('unit_type', 'soldier')
            ->where(function ($q) {
                $q->where('ipft_biannual_1', 'Failed')
                  ->orWhere('ipft_biannual_2', 'Failed')
                  ->orWhere('speed_march', 'Fail')
                  ->orWhere('grenade_fire', 'Fail')
                  ->orWhereRaw('CAST(shoot_total AS UNSIGNED) < 180');
            })
            ->latest()
            ->paginate(20);

        return view('admin.soldiers.weak', compact('soldiers'));
    }

    public function index(Request $request)
    {
        $query = Soldier::query()->orderBy('sort_order', 'asc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('number', 'like', '%' . $request->search . '%')
                  ->orWhere('rank', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        if ($request->filled('company')) {
            $query->where('company', $request->company);
        }

        $companies = Unit::where('type', 'company')->orderBy('sort_order')->get();
        $soldiers = $query->paginate(50)->withQueryString();

        $stats = [
            'total' => Soldier::count(),
            'active' => Soldier::where('is_active', true)->count(),
            'co' => Soldier::where('user_type', 'CO')->count(),
            'staff' => Soldier::where('user_type', 'Staff')->count(),
        ];

        return view('admin.soldiers.index', compact('soldiers', 'stats', 'companies'));
    }

    public function create()
    {
        $units = \App\Models\Unit::all();
        $nextOrder = Soldier::max('sort_order') + 1;
        
        // Group units by type for clearer selection
        $groupedUnits = [
            'battalion' => $units->where('type', 'battalion'),
            'company' => $units->where('type', 'company'),
            'platoon' => $units->where('type', 'platoon'),
            'section' => $units->where('type', 'section'),
        ];

        return view('admin.soldiers.create', compact('units', 'groupedUnits', 'nextOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_bn' => 'nullable|string|max:255',
            'number' => 'required|string|unique:soldiers,number',
            'personal_no' => 'nullable|string|max:255',
            'user_type' => 'required|string',
            'rank' => 'nullable|string',
            'rank_bn' => 'nullable|string',
            'company' => 'nullable|string',
            'platoon' => 'nullable|string',
            'section' => 'nullable|string',
            'appointment' => 'nullable|string',
            'appointment_bn' => 'nullable|string',
            'batch' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'home_district' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'enrolment_date' => 'nullable|date',
            'rank_date' => 'nullable|date',
            'civil_education' => 'nullable|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'unit' => 'nullable|string',
            'sub_unit' => 'nullable|string',
            'ipft_biannual_1' => 'nullable|string',
            'ipft_biannual_2' => 'nullable|string',
            'ipft_1_status' => 'nullable|string',
            'ipft_2_status' => 'nullable|string',
            'shoot_ret' => 'nullable|string',
            'ret_status' => 'nullable|string',
            'shoot_ap' => 'nullable|string',
            'shoot_ets' => 'nullable|string',
            'shoot_total' => 'nullable|string',
            'speed_march' => 'nullable|string',
            'speed_march_status' => 'nullable|string',
            'grenade_fire' => 'nullable|string',
            'grenade_firing_status' => 'nullable|string',
            'ni_firing_status' => 'nullable|string',
            'nil_fire' => 'nullable|string',
            'course_status' => 'nullable|string',
            'commander_status' => 'nullable|string',
            'cdr_plan_this_yr' => 'nullable|string',
            'leave_plan' => 'nullable|string',
            'sports_participation' => 'nullable|string',
            'unit_id' => 'nullable|exists:units,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'religion' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'dob' => 'nullable|date',
            'nid' => 'nullable|string|max:255',
            'special_courses' => 'nullable|array',
            'annual_career_plans' => 'nullable|array',
            'field_trainings_summer' => 'nullable|array',
            'field_trainings_winter' => 'nullable|array',
            'firing_records' => 'nullable|array',
            'night_firing_records' => 'nullable|array',
            'night_trainings' => 'nullable|array',
            'group_trainings' => 'nullable|array',
            'cycle_ending_exercises' => 'nullable|array',
            'firing_date' => 'nullable|date',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('soldiers', 'public');
        }

        $soldier = Soldier::create($validated);

        // Save Relationships
        if ($request->has('courses')) {
            foreach ($request->courses as $course) {
                if (!empty($course['name'])) {
                    $soldier->courses()->create($course);
                }
            }
        }

        return redirect()->route('admin.soldiers.index')
            ->with('success', 'Strategic node enrolled successfully!');
    }

    public function show(Soldier $soldier)
    {
        return view('admin.soldiers.show', compact('soldier'));
    }

    public function edit(Soldier $soldier)
    {
        $units = \App\Models\Unit::all();
        $groupedUnits = [
            'battalion' => $units->where('type', 'battalion'),
            'company' => $units->where('type', 'company'),
            'platoon' => $units->where('type', 'platoon'),
            'section' => $units->where('type', 'section'),
        ];
        return view('admin.soldiers.edit', compact('soldier', 'units', 'groupedUnits'));
    }

    public function update(Request $request, Soldier $soldier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_bn' => 'nullable|string|max:255',
            'number' => 'required|string|unique:soldiers,number,' . $soldier->id,
            'personal_no' => 'nullable|string|max:255',
            'user_type' => 'required|string',
            'rank' => 'nullable|string',
            'rank_bn' => 'nullable|string',
            'company' => 'nullable|string',
            'platoon' => 'nullable|string',
            'section' => 'nullable|string',
            'appointment' => 'nullable|string',
            'appointment_bn' => 'nullable|string',
            'batch' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'home_district' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'enrolment_date' => 'nullable|date',
            'rank_date' => 'nullable|date',
            'civil_education' => 'nullable|string',
            'height' => 'nullable|string',
            'weight' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'unit' => 'nullable|string',
            'sub_unit' => 'nullable|string',
            'ipft_biannual_1' => 'nullable|string',
            'ipft_biannual_2' => 'nullable|string',
            'ipft_1_status' => 'nullable|string',
            'ipft_2_status' => 'nullable|string',
            'shoot_ret' => 'nullable|string',
            'ret_status' => 'nullable|string',
            'shoot_ap' => 'nullable|string',
            'shoot_ets' => 'nullable|string',
            'shoot_total' => 'nullable|string',
            'speed_march' => 'nullable|string',
            'speed_march_status' => 'nullable|string',
            'grenade_fire' => 'nullable|string',
            'grenade_firing_status' => 'nullable|string',
            'ni_firing_status' => 'nullable|string',
            'nil_fire' => 'nullable|string',
            'course_status' => 'nullable|string',
            'commander_status' => 'nullable|string',
            'cdr_plan_this_yr' => 'nullable|string',
            'leave_plan' => 'nullable|string',
            'sports_participation' => 'nullable|string',
            'unit_id' => 'nullable|exists:units,id',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'religion' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'dob' => 'nullable|date',
            'nid' => 'nullable|string|max:255',
            'special_courses' => 'nullable|array',
            'annual_career_plans' => 'nullable|array',
            'field_trainings_summer' => 'nullable|array',
            'field_trainings_winter' => 'nullable|array',
            'firing_records' => 'nullable|array',
            'night_firing_records' => 'nullable|array',
            'night_trainings' => 'nullable|array',
            'group_trainings' => 'nullable|array',
            'cycle_ending_exercises' => 'nullable|array',
            'firing_date' => 'nullable|date',
        ]);

        if ($request->hasFile('photo')) {
            if ($soldier->photo) {
                Storage::disk('public')->delete($soldier->photo);
            }
            $validated['photo'] = $request->file('photo')->store('soldiers', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $soldier->update($validated);

        // Sync Relationships
        if ($request->has('courses')) {
            $soldier->courses()->delete();
            foreach ($request->courses as $course) {
                if (!empty($course['name'])) {
                    $soldier->courses()->create($course);
                }
            }
        }

        return redirect()->route('admin.soldiers.index')
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy(Soldier $soldier)
    {
        if ($soldier->photo) {
            Storage::disk('public')->delete($soldier->photo);
        }
        $soldier->delete();

        return redirect()->route('admin.soldiers.index')
            ->with('success', 'Soldier removed successfully!');
    }

    public function downloadTrg(Soldier $soldier)
    {
        // Generate a simple text-based TRG report
        $content = $this->generateTrgContent($soldier);
        $filename = 'TRG_' . str_replace(' ', '_', $soldier->name) . '_' . $soldier->number . '.txt';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function downloadRecordBook(Soldier $soldier)
    {
        // Delegate PDF generation to the strategic helper
        $pdf = PdfHelper::generateRecordBook($soldier);
        
        $filename = 'Record_Book_' . str_replace(' ', '_', $soldier->number) . '.pdf';
        return $pdf->download($filename);
    }

    public function printRecordBook(Soldier $soldier)
    {
        // Generate PDF with tactical helper and auto-print enabled
        $pdf = PdfHelper::generateRecordBook($soldier, true);
        
        return $pdf->stream('Record_Book_' . $soldier->number . '.pdf');
    }

    private function generateTrgContent(Soldier $soldier): string
    {
        $date = now()->format('d M Y');
        $unitPath = 'N/A';
        if ($soldier->unit) {
            $path = [];
            $curr = $soldier->unit;
            while($curr) {
                $path[] = $uName = $curr->name;
                $curr = $curr->parent;
            }
            $unitPath = implode(' > ', array_reverse($path));
        }

        return <<<TEXT
================================================================================
                    TRAINING RECORD GENERATION (TRG)
                         Bangladesh Armed Forces
================================================================================
Date: {$date}
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
STRATEGIC IDENTITY [সদস্যের তথ্য]
--------------------------------------------------------------------------------
Name [নাম]      : {$soldier->name} ({$soldier->name_bn})
No. [নং]        : {$soldier->number}
Rank [পদবী]     : {$soldier->rank} ({$soldier->rank_bn})
Unit Hierarchy  : {$unitPath}
Appointment     : {$soldier->appointment} ({$soldier->appointment_bn})
Batch [ব্যাচ]   : {$soldier->batch}
Blood Group     : {$soldier->blood_group} [রক্ত]
Home District   : {$soldier->home_district} [জেলা]
Readiness       : {$soldier->overall_status}

--------------------------------------------------------------------------------
TACTICAL DRILLS [প্রশিক্ষণ ফলাফল]
--------------------------------------------------------------------------------
IPFT (Biannual 1): {$soldier->ipft_biannual_1}
IPFT (Biannual 2): {$soldier->ipft_biannual_2}
Speed march     : {$soldier->speed_march} [X/4 Format]
Grenade firing  : {$soldier->grenade_fire} [X/4 Format]

--------------------------------------------------------------------------------
NI FIRING (STH) RESULTS [ফায়ারিং ফলাফল]
--------------------------------------------------------------------------------
Grouping [গ্রুপিং] : {$soldier->shoot_ret}
Hit [হিট]         : {$soldier->shoot_ap}
ETS [ইটিএস]       : {$soldier->shoot_ets}
Total [মোট]       : {$soldier->shoot_total}
Grade           : {$soldier->shooting_grade}

--------------------------------------------------------------------------------
COURSE & COMMANDER STATUS [কোর্স ও কমান্ডার স্ট্যাটাস]
--------------------------------------------------------------------------------
Course/Cdr Comp : {$soldier->course_status}
Course/Cdr Plan : {$soldier->cdr_plan_this_yr}

--------------------------------------------------------------------------------
OTHER INFORMATION [অন্যান্য তথ্য]
--------------------------------------------------------------------------------
P.lve Plan      : {$soldier->leave_plan}
Sports/Games    : {$soldier->sports_participation} [খেলাধুলায় অংশগ্রহণ]
Ni firing       : {$soldier->nil_fire}
--------------------------------------------------------------------------------

================================================================================
                          END OF STRATEGIC RECORD
================================================================================
TEXT;
    }
}
