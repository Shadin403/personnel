@extends('layouts.admin')

@section('title', 'Operations Dashboard')

@section('styles')
<style>
    #tree {
        width: 100%;
        height: 600px;
        background-color: #F8F9FA;
        border: 1px solid #d1d5db;
    }
    
    .node rect {
        fill: #ffffff !important;
        stroke: #2F4F3E !important;
        stroke-width: 2px !important;
    }

    /* Balkan OrgChart Templates CSS overrides */
    .orgchart-container { background: transparent !important; }
</style>
@endsection

@section('content')
<div class="space-y-10 animate-fade-in pb-20">
    <!-- Welcome Section -->
    <div class="flex items-center justify-between pb-6 border-b border-slate-300">
        <div class="space-y-1">
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Operations Overview [কৌশলগত ড্যাশবোর্ড]</h2>
            <p class="text-[12px] font-semibold text-slate-500 tracking-wide">Real-time Personnel Readiness & Training Matrix</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.soldiers.create') }}" class="btn-military flex items-center gap-2 active:scale-95 shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Enroll Personnel
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Soldiers -->
        <div class="classic-card p-6 border-l-4 border-l-military-secondary flex flex-col justify-between hover:border-l-military-primary transition-all">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest opacity-70">Total Strength [মোট সদস্য]</p>
                <div class="w-8 h-8 rounded-none border border-slate-200 bg-slate-50 flex items-center justify-center text-military-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-military-secondary tabular-nums tracking-tighter">{{ $stats['total'] }}</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-1.5">
                <span class="text-[11px] font-bold text-slate-500 tracking-tight">Active Service Assets Across All Ranks</span>
            </div>
        </div>

        <!-- Active Duty -->
        <div class="classic-card p-6 border-l-4 border-l-military-success flex flex-col justify-between hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest opacity-70">Operationally Ready [প্রস্তুত]</p>
                <div class="w-8 h-8 rounded-none bg-emerald-50 border border-emerald-100 flex items-center justify-center text-military-success">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-military-success tabular-nums tracking-tighter">{{ $stats['active'] }}</h3>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <div class="w-full h-1.5 bg-slate-100 rounded-none overflow-hidden border border-slate-200">
                    <div class="h-full bg-military-success transition-all duration-1000" style="width: {{ $stats['total'] > 0 ? ($stats['active']/$stats['total'])*100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- CO Staff -->
        <div class="classic-card p-6 border-l-4 border-l-military-primary flex flex-col justify-between hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest opacity-70">Commissioned Officers [CO]</p>
                <div class="w-8 h-8 rounded-none bg-military-bg border border-military-primary/20 flex items-center justify-center text-military-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-military-primary tabular-nums tracking-tighter">{{ $stats['co'] }}</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 text-[11px] font-bold text-military-primary tracking-tight">High-Level Leadership Nodes Synchronized</div>
        </div>

        <!-- Support Staff -->
        <div class="classic-card p-6 border-l-4 border-l-military-warning flex flex-col justify-between hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest opacity-70">Other Ranks [OR/Staff]</p>
                <div class="w-8 h-8 rounded-none bg-amber-50 border border-military-warning/20 flex items-center justify-center text-military-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-military-warning tabular-nums tracking-tighter">{{ $stats['staff'] }}</h3>
            <div class="mt-4 pt-4 border-t border-slate-100 text-[11px] font-bold text-military-warning tracking-tight">Support Personnel Logistics Validated</div>
        </div>
    </div>

    <!-- Command & Control Hierarchy (Org Chart) -->
    <div class="classic-card overflow-hidden animate-fade-in shadow-xl">
        <div class="px-8 py-4 classic-card-header flex items-center justify-between">
            <div class="flex items-center gap-4">
                <svg class="w-5 h-5 text-military-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <div>
                  <h3 class="text-[11px] font-bold text-white uppercase tracking-[0.3em]">Command & Control Structure [কমান্ড ও কন্ট্রোল স্ট্রাকচার]</h3>
                  <p class="text-[9px] font-semibold text-white/40 uppercase tracking-widest mt-0.5">Real-time Force Hierarchy & Deployment Visualization</p>
                </div>
            </div>
            <button onclick="chart.fit()" class="px-4 py-1.5 bg-white/10 border border-white/20 text-white text-[9px] font-bold uppercase tracking-widest hover:bg-white/20 transition-all flex items-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                Fit Perspective
            </button>
        </div>
        <div class="p-8 bg-slate-50 border-b border-slate-200">
            <div id="tree" class="shadow-inner"></div>
            
            <div class="mt-6 flex flex-wrap gap-4 items-center border-t border-slate-200 pt-6">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Unit Signature Legend:</span>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-600"></span>
                    <span class="text-[10px] font-bold text-military-secondary">OFFICER / HQ</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-military-primary"></span>
                    <span class="text-[10px] font-bold text-military-secondary">COMPANY</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-military-accent"></span>
                    <span class="text-[10px] font-bold text-military-secondary">PLATOON</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-amber-600"></span>
                    <span class="text-[10px] font-bold text-military-secondary">SECTION</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-slate-500"></span>
                    <span class="text-[10px] font-bold text-military-secondary">SOLDIER</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Training Progress -->
        <div class="lg:col-span-2 classic-card overflow-hidden flex flex-col">
            <div class="px-8 py-4 classic-card-header flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-military-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                    <h3 class="text-[14px] font-bold text-white tracking-widest uppercase">Operational Readiness Metrics (FY-26)</h3>
                </div>
            </div>
            <div class="p-8 space-y-10 flex-1 bg-white">
                <!-- IPFT -->
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <div class="space-y-1">
                            <span class="text-[15px] font-bold text-military-secondary tracking-tight">IPFT (Individual Physical Fitness Test)</span>
                            <p class="text-[12px] font-semibold text-slate-400 tracking-wide">Personnel physical fitness standards tracking</p>
                        </div>
                        <span class="text-xl font-bold text-military-primary tabular-nums">{{ $stats['total'] > 0 ? round(($trainingStats['ipft_pass']/$stats['total'])*100) : 0 }}%</span>
                    </div>
                    <div class="h-3 w-full bg-slate-100 rounded-none overflow-hidden border border-slate-200 shadow-inner">
                        <div class="h-full bg-military-primary transition-all duration-1000 shadow-inner" style="width: {{ $stats['total'] > 0 ? ($trainingStats['ipft_pass']/$stats['total'])*100 : 0 }}%"></div>
                    </div>
                </div>

                <!-- Speed March -->
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <div class="space-y-1">
                            <span class="text-[15px] font-bold text-military-secondary tracking-tight">Speed March (Tactical Endurance)</span>
                            <p class="text-[12px] font-semibold text-slate-400 tracking-wide">Deployment speed and physical stamina logs</p>
                        </div>
                        <span class="text-xl font-bold text-military-primary tabular-nums">{{ $stats['total'] > 0 ? round(($trainingStats['speed_march_pass']/$stats['total'])*100) : 0 }}%</span>
                    </div>
                    <div class="h-3 w-full bg-slate-100 rounded-none overflow-hidden border border-slate-200 shadow-inner">
                        <div class="h-full bg-military-accent transition-all duration-1000 shadow-inner" style="width: {{ $stats['total'] > 0 ? ($trainingStats['speed_march_pass']/$stats['total'])*100 : 0 }}%"></div>
                    </div>
                </div>

                <!-- Grenade -->
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <div class="space-y-1">
                            <span class="text-[15px] font-bold text-military-secondary tracking-tight">Grenade Fire Precision</span>
                            <p class="text-[12px] font-semibold text-slate-400 tracking-wide">Ballistical precision & tactical handling mastery</p>
                        </div>
                        <span class="text-xl font-bold text-military-primary tabular-nums">{{ $stats['total'] > 0 ? round(($trainingStats['grenade_pass']/$stats['total'])*100) : 0 }}%</span>
                    </div>
                    <div class="h-3 w-full bg-slate-100 rounded-none overflow-hidden border border-slate-200 shadow-inner">
                        <div class="h-full bg-military-secondary transition-all duration-1000 shadow-inner" style="width: {{ $stats['total'] > 0 ? ($trainingStats['grenade_pass']/$stats['total'])*100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Blood Logistics -->
            <div class="classic-card bg-military-secondary text-white flex flex-col h-full border-none shadow-2xl">
                <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between bg-black/20">
                    <h3 class="text-[10px] font-bold text-white/50 uppercase tracking-[0.25em]">Med-Log Registry</h3>
                    <div class="w-1.5 h-1.5 rounded-full bg-military-danger animate-pulse shadow-[0_0_8px_#B91C1C]"></div>
                </div>
                <div class="p-6 space-y-7 flex-1 shadow-inner">
                    @foreach($bloodGroups as $bg)
                    <div class="space-y-2">
                        <div class="flex justify-between text-[10px] font-bold uppercase tracking-[0.15em]">
                            <span class="text-white/60">{{ $bg->blood_group }} GROUP</span>
                            <span class="text-military-accent">{{ $bg->count }} UNITs</span>
                        </div>
                        <div class="h-1.5 w-full bg-white/5 overflow-hidden border border-white/10">
                            <div class="h-full bg-military-danger shadow-[0_0_12px_#B91C1C]" style="width: {{ ($bg->count / max(1, $stats['total'])) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-6 py-4 border-t border-white/5 bg-black/20">
                    <p class="text-[9px] font-semibold text-white/30 uppercase tracking-[0.2em] text-center">Ready-Response Medical Data</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Enrollments Table -->
    <div class="classic-card overflow-hidden">
        <div class="px-8 py-4 classic-card-header flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-none bg-white/10 border border-white/20 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-[11px] font-bold text-white uppercase tracking-[0.3em]">Personnel Directory [নাম ও নং]</h3>
                    <p class="text-[9px] font-semibold text-white/40 uppercase tracking-widest mt-0.5">Global Registry Assets &bull; Live DB Link</p>
                </div>
            </div>
            <a href="{{ route('admin.soldiers.index') }}" class="px-5 py-2 bg-white/10 border border-white/20 text-white text-[9px] font-bold uppercase tracking-widest hover:bg-white/20 transition-all flex items-center gap-2">
                Open Full Repository
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        <div class="overflow-x-auto bg-white">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-military-bg">
                        <th class="px-8 py-5 text-[10px] font-bold text-military-secondary uppercase tracking-[0.25em] border-b border-slate-200">Name & No. [নাম ও নং]</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-military-secondary uppercase tracking-[0.25em] border-b border-slate-200">Coy. & Appt [কোম্পানী ও অ্যাপয়েন্টমেন্ট]</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-military-secondary uppercase tracking-[0.25em] border-b border-slate-200">Readiness Grade</th>
                        <th class="px-8 py-5 text-[10px] font-bold text-military-secondary uppercase tracking-[0.25em] border-b border-slate-200 text-right">Data Sync</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($recentSoldiers as $soldier)
                    <tr class="hover:bg-military-bg/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-5">
                                <div class="w-11 h-11 rounded-none border border-slate-300 p-0.5 bg-white shadow-sm transition-all group-hover:border-military-primary">
                                    <img src="{{ $soldier->photo_url }}" alt="" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                                </div>
                                <div class="space-y-0.5">
                                    <p class="text-[13px] font-bold text-military-secondary tracking-tight">{{ $soldier->name }} [নাম]</p>
                                    <p class="text-[11px] font-bold text-slate-400 font-mono">No.: {{ $soldier->number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="text-[13px] font-bold text-military-primary tracking-tight">{{ $soldier->rank }}</p>
                            <p class="text-[11px] font-medium text-slate-500">{{ $soldier->company }} Coy. &bull; Appt: {{ $soldier->appointment }}</p>
                        </td>
                        <td class="px-8 py-5">
                            @php 
                                $statusStyle = match($soldier->overall_status) {
                                    'Excellent' => 'text-white bg-military-success border-military-success shadow-[0_0_8px_rgba(21,128,61,0.3)]',
                                    'Good' => 'text-white bg-military-primary border-military-primary shadow-[0_0_8px_rgba(47,79,62,0.3)]',
                                    'Average' => 'text-white bg-military-warning border-military-warning shadow-[0_0_8px_rgba(217,119,6,0.3)]',
                                    default => 'text-white bg-military-danger border-military-danger shadow-[0_0_8px_rgba(185,28,28,0.3)]'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 text-[11px] font-bold border tracking-wide {{ $statusStyle }}">
                                {{ $soldier->overall_status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300">
                                <a href="{{ route('admin.soldiers.edit', $soldier) }}" class="p-2 border border-slate-200 text-slate-400 hover:text-military-primary hover:border-military-primary transition-all shadow-sm bg-white" title="Modify Record">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <a href="{{ route('admin.soldiers.download-trg', $soldier) }}" class="px-4 py-2 bg-military-secondary text-white hover:bg-military-primary transition-all font-bold text-[9px] uppercase tracking-widest shadow-md">
                                    GEN REPORT
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://balkan.app/js/orgchart.js"></script>
<script>
    var chart;
    document.addEventListener('DOMContentLoaded', function() {
        var data = @json($treeNodes);

        OrgChart.templates.military = Object.assign({}, OrgChart.templates.ana);
        OrgChart.templates.military.size = [200, 80];
        OrgChart.templates.military.node = '<rect x="0" y="0" height="80" width="200" fill="#ffffff" stroke-width="1.5" stroke="#2F4F3E" rx="0" ry="0"></rect>';
        OrgChart.templates.military.field_0 = '<text style="font-size: 13px; font-weight: 900;" fill="#2F4F3E" x="100" y="32" text-anchor="middle">{val}</text>';
        OrgChart.templates.military.field_1 = '<text style="font-size: 10px; font-weight: 700; opacity: 0.7;" fill="#6B8E23" x="100" y="52" text-anchor="middle">{val}</text>';
        
        // Tags
        OrgChart.templates.military_officer = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_officer.node = '<rect x="0" y="0" height="80" width="200" fill="#fef2f2" stroke-width="2" stroke="#B91C1C" rx="0" ry="0"></rect>';

        OrgChart.templates.military_company = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_company.node = '<rect x="0" y="0" height="80" width="200" fill="#f0fdf4" stroke-width="2" stroke="#2F4F3E" rx="0" ry="0"></rect>';

        OrgChart.templates.military_platoon = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_platoon.node = '<rect x="0" y="0" height="80" width="200" fill="#f7fee7" stroke-width="2" stroke="#6B8E23" rx="0" ry="0"></rect>';

        OrgChart.templates.military_section = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_section.node = '<rect x="0" y="0" height="80" width="200" fill="#fffbeb" stroke-width="2" stroke="#D97706" rx="0" ry="0"></rect>';

        chart = new OrgChart(document.getElementById("tree"), {
            template: "military",
            enableSearch: false,
            mouseWheel: OrgChart.action.zoom,
            nodeBinding: {
                field_0: "name",
                field_1: "title"
            },
            nodes: data,
            tags: {
                "officer": { template: "military_officer" },
                "company": { template: "military_company" },
                "platoon": { template: "military_platoon" },
                "section": { template: "military_section" },
                "soldier": { template: "military" }
            }
        });

        chart.on('click', function(sender, args) {
            var nodeData = chart.get(args.node.id);
            if(nodeData && nodeData.profile_url) {
                window.location.href = nodeData.profile_url;
                return false;
            }
        });
    });
</script>
@endsection
