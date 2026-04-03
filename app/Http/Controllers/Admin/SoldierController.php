<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use App\Models\Course;
use App\Models\TrainingPlan;
use App\Models\UnitTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $query = Soldier::query();

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

        $soldiers = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Soldier::count(),
            'active' => Soldier::where('is_active', true)->count(),
            'co' => Soldier::where('user_type', 'CO')->count(),
            'staff' => Soldier::where('user_type', 'Staff')->count(),
        ];

        return view('admin.soldiers.index', compact('soldiers', 'stats'));
    }

    public function create()
    {
        $units = \App\Models\Unit::all();
        return view('admin.soldiers.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|unique:soldiers,number',
            'user_type' => 'required|string',
            'rank' => 'nullable|string',
            'company' => 'nullable|string',
            'appointment' => 'nullable|string',
            'batch' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'home_district' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'enrolment_date' => 'nullable|date',
            'rank_date' => 'nullable|date',
            'civil_education' => 'nullable|string',
            'weight' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'unit' => 'nullable|string',
            'sub_unit' => 'nullable|string',
            'ipft_biannual_1' => 'nullable|string',
            'ipft_biannual_2' => 'nullable|string',
            'shoot_ret' => 'nullable|string',
            'shoot_ap' => 'nullable|string',
            'shoot_ets' => 'nullable|string',
            'shoot_total' => 'nullable|string',
            'speed_march' => 'nullable|string',
            'grenade_fire' => 'nullable|string',
            'course_status' => 'nullable|string',
            'commander_status' => 'nullable|string',
            'cdr_plan_this_yr' => 'nullable|string',
            'leave_plan' => 'nullable|string',
            'sports_participation' => 'nullable|string',
            'nil_fire' => 'nullable|string',
            'parent_id' => 'nullable|exists:soldiers,id',
            'unit_type' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
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

        if ($request->has('training_plans')) {
            foreach ($request->training_plans as $plan) {
                if (!empty($plan['year'])) {
                    $soldier->trainingPlans()->create($plan);
                }
            }
        }

        if ($request->has('unit_trainings')) {
            foreach ($request->unit_trainings as $ut) {
                if (!empty($ut['year'])) {
                    $soldier->unitTrainings()->create($ut);
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
        return view('admin.soldiers.edit', compact('soldier', 'units'));
    }

    public function update(Request $request, Soldier $soldier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|unique:soldiers,number,' . $soldier->id,
            'user_type' => 'required|string',
            'rank' => 'nullable|string',
            'company' => 'nullable|string',
            'appointment' => 'nullable|string',
            'batch' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'home_district' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'enrolment_date' => 'nullable|date',
            'rank_date' => 'nullable|date',
            'civil_education' => 'nullable|string',
            'weight' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'unit' => 'nullable|string',
            'sub_unit' => 'nullable|string',
            'ipft_biannual_1' => 'nullable|string',
            'ipft_biannual_2' => 'nullable|string',
            'shoot_ret' => 'nullable|string',
            'shoot_ap' => 'nullable|string',
            'shoot_ets' => 'nullable|string',
            'shoot_total' => 'nullable|string',
            'speed_march' => 'nullable|string',
            'grenade_fire' => 'nullable|string',
            'course_status' => 'nullable|string',
            'parent_id' => 'nullable|exists:soldiers,id',
            'unit_type' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
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

        if ($request->has('training_plans')) {
            $soldier->trainingPlans()->delete();
            foreach ($request->training_plans as $plan) {
                if (!empty($plan['year'])) {
                    $soldier->trainingPlans()->create($plan);
                }
            }
        }

        if ($request->has('unit_trainings')) {
            $soldier->unitTrainings()->delete();
            foreach ($request->unit_trainings as $ut) {
                if (!empty($ut['year'])) {
                    $soldier->unitTrainings()->create($ut);
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
        $pdf = Pdf::loadView('admin.soldiers.record-book-pdf', compact('soldier'))
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isFontSubsettingEnabled' => true, // Important for Unicode
            ]);
        
        $filename = 'Record_Book_' . str_replace(' ', '_', $soldier->number) . '.pdf';
        return $pdf->download($filename);
    }

    private function generateTrgContent(Soldier $soldier): string
    {
        $date = now()->format('d M Y');
        return <<<TEXT
================================================================================
                    TRAINING RECORD GENERATION (TRG)
                         Bangladesh Armed Forces
================================================================================
Date: {$date}
--------------------------------------------------------------------------------
--------------------------------------------------------------------------------
PERSONAL INFORMATION [ব্যক্তিগত তথ্য]
--------------------------------------------------------------------------------
Name [নাম]      : {$soldier->name}
No. [নং]        : {$soldier->number}
Rank [পদবী]     : {$soldier->rank}
User Type       : {$soldier->user_type}
Coy. (Company)  : {$soldier->company}
Appt            : {$soldier->appointment}
Batch [ব্যাচ]   : {$soldier->batch}
Blood Group     : {$soldier->blood_group} [রক্তের গ্রুপ]
Home District   : {$soldier->home_district} [নিজ জেলা]
Status          : {$soldier->overall_status}

--------------------------------------------------------------------------------
TRAINING RESULTS [প্রশিক্ষণ ফলাফল]
--------------------------------------------------------------------------------
IPFT (Biannual 1): {$soldier->ipft_biannual_1}
IPFT (Biannual 2): {$soldier->ipft_biannual_2}
Speed march     : {$soldier->speed_march}
Grenade firing  : {$soldier->grenade_fire}

--------------------------------------------------------------------------------
FIRING RESULT SECTION (Ret) [ফায়ারিং ফলাফল]
--------------------------------------------------------------------------------
Ni firing (STH) : {$soldier->shoot_ret} [টার্গেটে hit score]
AP              : {$soldier->shoot_ap} [ফায়ারিং সাব-স্কোর]
ETS             : {$soldier->shoot_ets} [ইটিএস স্কোর]
Total [মোট]     : {$soldier->shoot_total} [মোট score]
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
                          END OF RECORD
================================================================================
TEXT;
    }
}
