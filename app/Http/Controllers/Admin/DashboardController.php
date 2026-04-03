<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soldier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $treeNodes = [];

        // 🎖️ Standard Organization Data
        $coys = [
            ['id' => 1, 'short' => 'A Coy', 'full' => 'Alpha Coy'],
            ['id' => 2, 'short' => 'B Coy', 'full' => 'Bravo Coy'],
            ['id' => 3, 'short' => 'C Coy', 'full' => 'Charlie Coy'],
            ['id' => 4, 'short' => 'D Coy', 'full' => 'Delta Coy'],
            ['id' => 5, 'short' => 'HQ Coy', 'full' => 'HQ Coy'],
        ];

        $plats = ['1 PL', '2 PL', '3 PL', 'SP PL', 'Coy HQ'];
        $secs = ['1 Sec', '2 Sec', '3 Sec', 'PL HQ'];

        // 1. Build Companies (Level 2)
        foreach ($coys as $c) {
            $treeNodes[] = [
                'id' => $c['id'],
                'name' => $c['short'],
                'appointment' => 'OC ' . explode(' ', $c['short'])[0],
                'unit_type' => 'company',
                'pid' => null
            ];

            // 2. Build Platoons (Level 3 - for each company)
            foreach ($plats as $pIdx => $pName) {
                $pId = ($c['id'] * 10) + ($pIdx + 1);
                $treeNodes[] = [
                    'id' => $pId,
                    'name' => $pName,
                    'appointment' => 'PL CDR',
                    'unit_type' => 'platoon',
                    'pid' => $c['id']
                ];

                // 3. Build Sections (Level 4 - for each platoon)
                foreach ($secs as $sIdx => $sName) {
                    $sId = ($pId * 10) + ($sIdx + 1);
                    $treeNodes[] = [
                        'id' => $sId,
                        'name' => $sName,
                        'appointment' => 'SEC CDR',
                        'unit_type' => 'section',
                        'pid' => $pId
                    ];
                }
            }
        }

        // 4. Build Soldiers (Level 5 - ONLY Alpha Coy -> 1 Platoon -> 1 Section)
        // Alpha Coy (ID 1) -> 1 PL (ID 11) -> 1 Sec (ID 111)
        $targetSectionId = 111; 
        
        $soldiers = Soldier::all();
        foreach ($soldiers as $soldier) {
            $treeNodes[] = [
                'id' => 'sol_' . $soldier->id,
                'pid' => $targetSectionId, 
                'name' => $soldier->name,
                'rank' => $soldier->rank,
                'number' => $soldier->number,
                'appointment' => $soldier->appointment ?? 'Rifleman',
                'img' => $soldier->photo_url,
                'profile_url' => route('admin.soldiers.show', $soldier->id),
                'unit_type' => 'soldier'
            ];
        }

        return view('admin.dashboard', compact('treeNodes'));
    }
}
