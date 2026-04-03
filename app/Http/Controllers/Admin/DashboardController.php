<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentCompany = $request->query('company');
        $currentPlatoon = $request->query('platoon');
        $currentSection = $request->query('section');

        $stats = [
            'total' => Soldier::count(),
            'active' => Soldier::where('is_active', true)->count(),
        ];

        // 🏗️ 5-Level Hierarchy Definitions
        $companies = ['Alpha (A) Coy', 'Bravo (B) Coy', 'Charlie (C) Coy', 'Delta (D) Coy', 'HQ Coy'];
        $platoons = ['1 PL', '2 PL', '3 PL', 'SP PL', 'Coy HQ'];
        $sections = ['1 Sec', '2 Sec', '3 Sec', 'PL HQ'];

        $viewData = [
            'level' => 1,
            'title' => '9 E Bengal (Battalion)',
            'items' => $companies,
            'type' => 'company',
            'breadcrumbs' => [],
        ];

        if ($currentCompany) {
            $viewData['level'] = 2;
            $viewData['title'] = $currentCompany;
            $viewData['items'] = $platoons;
            $viewData['type'] = 'platoon';
            $viewData['breadcrumbs'][] = ['name' => '9E Bengal', 'url' => route('admin.dashboard')];
        }

        if ($currentPlatoon) {
            $viewData['level'] = 3;
            $viewData['title'] = $currentPlatoon;
            $viewData['items'] = $sections;
            $viewData['type'] = 'section';
            $viewData['breadcrumbs'][] = ['name' => $currentCompany, 'url' => route('admin.dashboard', ['company' => $currentCompany])];
        }

        if ($currentSection) {
            $viewData['level'] = 4;
            $viewData['title'] = $currentSection;
            $viewData['items'] = Soldier::where('company', $currentCompany)
                ->where('platoon', $currentPlatoon)
                ->where('section', $currentSection)
                ->get();
            $viewData['type'] = 'personnel';
            $viewData['breadcrumbs'][] = ['name' => $currentPlatoon, 'url' => route('admin.dashboard', ['company' => $currentCompany, 'platoon' => $currentPlatoon])];
        }

        return view('admin.dashboard', compact('stats', 'viewData', 'currentCompany', 'currentPlatoon', 'currentSection'));
    }
}
