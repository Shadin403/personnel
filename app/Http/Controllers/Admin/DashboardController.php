<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Soldier::count(),
            'active' => Soldier::where('is_active', true)->count(),
            'co' => Soldier::where('user_type', 'CO')->count(),
            'staff' => Soldier::where('user_type', 'Staff')->count(),
        ];

        $recentSoldiers = Soldier::latest()->take(5)->get();

        // Training stats
        $trainingStats = [
            'ipft_pass' => Soldier::where('ipft_biannual_1', 'Pass')->where('ipft_biannual_2', 'Pass')->count(),
            'speed_march_pass' => Soldier::where('speed_march', 'Pass')->count(),
            'grenade_pass' => Soldier::where('grenade_fire', 'Pass')->count(),
            'courses_completed' => Soldier::where('course_status', 'Completed')->count(),
        ];

        // Blood group distribution
        $bloodGroups = Soldier::selectRaw('blood_group, COUNT(*) as count')
            ->whereNotNull('blood_group')
            ->groupBy('blood_group')
            ->get();

        // Company distribution
        $companies = Soldier::selectRaw('company, COUNT(*) as count')
            ->whereNotNull('company')
            ->groupBy('company')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSoldiers', 'trainingStats', 'bloodGroups', 'companies'));
    }
}
