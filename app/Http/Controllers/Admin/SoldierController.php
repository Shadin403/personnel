<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use App\Models\Course;
use App\Models\TrainingPlan;
use App\Models\UnitTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Unit;
use App\Models\User;
use App\Helpers\PdfHelper;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class SoldierController extends Controller
{
    public function weak(Request $request)
    {
        $category = $request->get('category', 'all');
        $query = Soldier::query();

        // Base query for test failures
        if ($category === 'IP50') {
            $query->whereIn('ipft_biannual_1', ['Failed', 'Fail', 'FAIL', 'failed'])
                ->orWhereIn('ipft_biannual_2', ['Failed', 'Fail', 'FAIL', 'failed']);
        } elseif ($category === 'RT') {
            $query->where(function ($q) {
                $q->whereRaw('CAST(shoot_total AS UNSIGNED) < 180 AND CAST(shoot_total AS UNSIGNED) > 0')
                    ->orWhere('firing_records', 'like', '%"status":"Fail"%')
                    ->orWhere('night_firing_records', 'like', '%"status":"Fail"%');
            });
        } elseif ($category === 'Overweight') {
            // Handled after fetching because it's a dynamic attribute
            $query->whereRaw('1=1'); // Fetch all to filter in collection
        } else {
            // Default "Needs Improvement" (all categories)
            $query->where(function ($q) {
                $q->whereIn('ipft_biannual_1', ['Failed', 'Fail', 'FAIL', 'failed'])
                    ->orWhereIn('ipft_biannual_2', ['Failed', 'Fail', 'FAIL', 'failed'])
                    ->orWhere('speed_march', 'Fail')
                    ->orWhere('speed_march', 'FAIL')
                    ->orWhere('grenade_fire', 'Fail')
                    ->orWhere('grenade_fire', 'FAIL')
                    ->orWhereRaw('CAST(shoot_total AS UNSIGNED) < 180 AND CAST(shoot_total AS UNSIGNED) > 0')
                    ->orWhere('firing_records', 'like', '%"status":"Fail"%')
                    ->orWhere('night_firing_records', 'like', '%"status":"Fail"%');
            });
        }

        $soldiers = $query->latest()->get();

        // Filter collection for Weight Status if Overweight is requested, or merge if 'all'
        $soldiers = $soldiers->filter(function ($s) use ($category) {
            $status = $s->weight_status;
            $isOverweight = in_array($status, ['Overweight', 'Obese', 'Obese (WHR)']);

            if ($category === 'Overweight') return $isOverweight;
            if ($category === 'all' && $isOverweight) return true;
            if ($category === 'all') return true; // Already filtered by query

            return true; // Already filtered by query for IP50/RT
        });

        // If 'all', we must explicitly ensure those who are ONLY overweight are included
        if ($category === 'all') {
            $overweights = Soldier::all()->filter(function ($s) {
                return in_array($s->weight_status, ['Overweight', 'Obese', 'Obese (WHR)']);
            });
            $soldiers = $soldiers->merge($overweights)->unique('id');
        }

        // Manual pagination for the filtered collection
        $perPage = 100; // Increased limit for categorized nominal rolls
        $page = $request->get('page', 1);
        $paginatedSoldiers = new \Illuminate\Pagination\LengthAwarePaginator(
            $soldiers->forPage($page, $perPage),
            $soldiers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $soldiers = $paginatedSoldiers;

        // Categorize for grouped display (for ALL view or Registry PDF)
        $ipft_fails = $soldiers->filter(function ($s) {
            return in_array(strtoupper($s->ipft_biannual_1), ['FAIL', 'FAILED', 'F']) ||
                in_array(strtoupper($s->ipft_biannual_2), ['FAIL', 'FAILED', 'F']);
        });

        $ret_fails = $soldiers->filter(function ($s) {
            $hasFailRecord = false;
            if (is_array($s->firing_records)) {
                foreach ($s->firing_records as $rec) {
                    if (isset($rec['status']) && strtoupper($rec['status']) === 'FAIL') $hasFailRecord = true;
                }
            }
            if (is_array($s->night_firing_records)) {
                foreach ($s->night_firing_records as $rec) {
                    if (isset($rec['status']) && strtoupper($rec['status']) === 'FAIL') $hasFailRecord = true;
                }
            }
            return ((int)$s->shoot_total < 180 && (int)$s->shoot_total > 0) || $hasFailRecord;
        });

        $overweight_fails = $soldiers->filter(function ($s) {
            return in_array($s->weight_status, ['Overweight', 'Obese', 'Obese (WHR)']);
        });

        return view('admin.soldiers.weak', compact('soldiers', 'category', 'ipft_fails', 'ret_fails', 'overweight_fails'));
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
            'number' => 'nullable|string|unique:soldiers,number',
            'personal_no' => 'nullable|string|max:255|unique:soldiers,personal_no',
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
            'email' => 'nullable|email|max:255|unique:users,email|unique:soldiers,email',
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
            'height_inch' => 'nullable|integer',
            'height_ft' => 'nullable|integer|min:3|max:8',
            'height_in' => 'nullable|integer|min:0|max:11',
            'wrist_cm' => 'nullable|numeric',
            'is_pregnant' => 'nullable|boolean',
            'password' => 'required_if:user_type,CO,2IC,ADJT,COY COMD,COY Clk|nullable|string|min:6',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            if (empty($validated['number']) && !empty($validated['personal_no'])) {
                $validated['number'] = $validated['personal_no'];
            }

            if ($request->has('height_ft')) {
                $validated['height_inch'] = ((int)$request->height_ft * 12) + ((int)$request->height_in ?? 0);
            }

            // Standardize IPFT status to "Pass"/"Fail"
            foreach (['ipft_biannual_1', 'ipft_biannual_2'] as $field) {
                if ($request->filled($field)) {
                    $val = strtoupper($request->$field);
                    if (str_starts_with($val, 'P')) $validated[$field] = 'Pass';
                    elseif (str_starts_with($val, 'F')) $validated[$field] = 'Fail';
                }
            }

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('soldiers', 'public');
            }

            $validated['created_by'] = Auth::id();
            $soldier = Soldier::create($validated);

            // Save Relationships
            if ($request->has('courses')) {
                foreach ($request->courses as $course) {
                    if (!empty($course['name'])) {
                        $soldier->courses()->create($course);
                    }
                }
            }

            // Create User Account
            User::create([
                'name' => $soldier->name,
                'email' => $request->email ?: (strtolower(str_replace([' ', '-'], '_', $soldier->personal_no ?: $soldier->number)) . '@system.com'),
                'password' => Hash::make($request->password ?: 'password123'),
                'user_type' => $soldier->user_type,
                'soldier_id' => $soldier->id,
            ]);

            return redirect()->route('admin.soldiers.index')
                ->with('success', 'Strategic node enrolled successfully!');
        });
    }

    public function show(Soldier $soldier)
    {
        return view('admin.soldiers.show', compact('soldier'));
    }

    public function edit(Soldier $soldier)
    {
        Gate::authorize('manage-soldiers');

        $units = Unit::all();
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
            'number' => 'nullable|string|unique:soldiers,number,' . $soldier->id,
            'personal_no' => 'nullable|string|max:255|unique:soldiers,personal_no,' . $soldier->id,
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
            'email' => 'nullable|email|max:255|unique:users,email,' . ($soldier->user->id ?? 'NULL') . '|unique:soldiers,email,' . $soldier->id,
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
            'height_inch' => 'nullable|integer',
            'height_ft' => 'nullable|integer|min:3|max:8',
            'height_in' => 'nullable|integer|min:0|max:11',
            'wrist_cm' => 'nullable|numeric',
            'is_pregnant' => 'nullable|boolean',
            'password' => 'required_if:user_type,CO,2IC,ADJT,COY COMD,COY Clk|nullable|string|min:6',
        ]);

        Gate::authorize('manage-soldiers');

        return DB::transaction(function () use ($request, $soldier, $validated) {
            if (empty($validated['number']) && !empty($validated['personal_no'])) {
                $validated['number'] = $validated['personal_no'];
            }

            if ($request->has('height_ft')) {
                $validated['height_inch'] = ((int)$request->height_ft * 12) + ((int)$request->height_in ?? 0);
            }

            // Standardize IPFT status to "Pass"/"Fail"
            foreach (['ipft_biannual_1', 'ipft_biannual_2'] as $field) {
                if ($request->filled($field)) {
                    $val = strtoupper($request->$field);
                    if (str_starts_with($val, 'P')) $validated[$field] = 'Pass';
                    elseif (str_starts_with($val, 'F')) $validated[$field] = 'Fail';
                }
            }

            if ($request->hasFile('photo')) {
                if ($soldier->photo) {
                    Storage::disk('public')->delete($soldier->photo);
                }
                $validated['photo'] = $request->file('photo')->store('soldiers', 'public');
            }

            $validated['is_active'] = $request->has('is_active') ? true : false;
            $validated['updated_by'] = Auth::id();
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

            // Update associated User account
            $user = User::where('soldier_id', $soldier->id)->first();
            $userData = [
                'name' => $soldier->name,
                'user_type' => $soldier->user_type,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            if ($user) {
                $user->update($userData);
                
                // Keep login email in sync with soldier email if provided
                if ($request->filled('email')) {
                    $user->update(['email' => $request->email]);
                }
            } else {
                User::create(array_merge($userData, [
                    'email' => $request->email ?: (strtolower(str_replace([' ', '-'], '_', $soldier->personal_no ?: $soldier->number)) . '@system.com'),
                    'password' => Hash::make($request->password ?: 'password123'),
                    'soldier_id' => $soldier->id,
                ]));
            }

            return redirect()->route('admin.soldiers.index')
                ->with('success', 'Profile updated successfully!');
        });
    }

    public function destroy(Soldier $soldier)
    {
        Gate::authorize('manage-soldiers');

        if ($soldier->photo) {
            Storage::disk('public')->delete($soldier->photo);
        }
        $soldier->delete();

        return redirect()->route('admin.soldiers.index')
            ->with('success', 'Soldier removed successfully!');
    }

    public function downloadTrg(Soldier $soldier)
    {
        $content = $this->generateTrgContent($soldier);
        $filename = 'TRG_' . str_replace(' ', '_', $soldier->name) . '_' . $soldier->number . '.txt';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function downloadRecordBook(Soldier $soldier)
    {
        $pdf = PdfHelper::generateRecordBook($soldier);
        $filename = 'Record_Book_' . str_replace(' ', '_', $soldier->number) . '.pdf';
        return $pdf->download($filename);
    }

    public function printRecordBook(Soldier $soldier)
    {
        $pdf = PdfHelper::generateRecordBook($soldier, true);
        return $pdf->stream('Record_Book_' . $soldier->number . '.pdf');
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids', []);
        $action = $request->input('action', 'download');
        $category = $request->input('category', 'all');

        if (empty($ids)) {
            return back()->with('error', 'No soldiers selected.');
        }

        if ($action === 'delete') {
            Soldier::destroy($ids);
            return back()->with('success', count($ids) . ' soldiers removed successfully.');
        }

        $soldiers = Soldier::whereIn('id', $ids)->get();
        $printable = ($action === 'print');

        $ipft_fails = $soldiers->filter(fn($s) => in_array(strtoupper($s->ipft_biannual_1), ['FAIL', 'FAILED', 'F']) || in_array(strtoupper($s->ipft_biannual_2), ['FAIL', 'FAILED', 'F']));
        $ret_fails = $soldiers->filter(function ($s) {
            $hasF = false;
            if (is_array($s->firing_records)) foreach ($s->firing_records as $r) if (isset($r['status']) && strtoupper($r['status']) === 'FAIL') $hasF = true;
            if (is_array($s->night_firing_records)) foreach ($s->night_firing_records as $r) if (isset($r['status']) && strtoupper($r['status']) === 'FAIL') $hasF = true;
            return ((int)$s->shoot_total < 180 && (int)$s->shoot_total > 0) || $hasF;
        });
        $overweight_fails = $soldiers->filter(fn($s) => in_array($s->weight_status, ['Overweight', 'Obese', 'Obese (WHR)']));

        if ($action === 'registry-pdf') {
            $pdf = \App\Helpers\PdfHelper::generateRegistryPdf($ipft_fails, $ret_fails, $overweight_fails, $printable, $category);
            $filename = 'improvement-registry-' . now()->format('Y-m-d-His') . '.pdf';
        } else {
            $pdf = \App\Helpers\PdfHelper::generateBulkRecordBooks($soldiers, $printable, $ipft_fails, $ret_fails, $overweight_fails);
            $filename = 'bulk-records-' . now()->format('Y-m-d-His') . '.pdf';
        }

        if ($printable) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    private function generateTrgContent(Soldier $soldier): string
    {
        $date = now()->format('d M Y');
        $unitPath = 'N/A';
        if ($soldier->unit) {
            $path = [];
            $curr = $soldier->unit;
            while ($curr) {
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
ETS [イティーエス]       : {$soldier->shoot_ets}
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
