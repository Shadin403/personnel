@extends('layouts.admin')

@section('title', 'Chain of Command')

@section('styles')
<style>
    #tree {
        width: 100%;
        height: 700px;
        background-color: #F5F1E8;
        border: 1px solid #d1d5db;
    }

    /* Custom OrgChart CSS to match military theme */
    .node {
        fill: #2F4F3E !important;
        stroke: #1F2937 !important;
    }
    
    .node rect {
        fill: #ffffff !important;
        stroke: #2F4F3E !important;
        stroke-width: 2px !important;
    }

    .node text {
        fill: #1F2937 !important;
        font-family: 'Roboto', sans-serif !important;
    }

    .boc-edit-form-header {
        background-color: #2F4F3E !important;
    }

    .unit-officer { border-top: 4px solid #B91C1C !important; }
    .unit-company { border-top: 4px solid #2F4F3E !important; }
    .unit-platoon { border-top: 4px solid #6B8E23 !important; }
    .unit-section { border-top: 4px solid #D97706 !important; }
    .unit-soldier { border-top: 4px solid #64748b !important; }

    /* OrgChart.js Template Customization */
    .orgchart-container {
        background: transparent !important;
    }
</style>
@endsection

@section('content')
<div class="animate-fade-in">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-black text-military-secondary tracking-tight uppercase">Chain of Command</h2>
            <p class="text-[11px] font-bold text-military-accent uppercase tracking-widest mt-1">Force Hierarchical Structure Visualization</p>
        </div>
        <div class="flex gap-3">
            <button onclick="chart.fit()" class="btn-military flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                Fit to Screen
            </button>
            <a href="{{ route('admin.soldiers.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-military-primary text-[13px] font-bold hover:bg-slate-50 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                Back to Directory
            </a>
        </div>
    </div>

    <div class="classic-card">
        <div class="classic-card-header flex items-center gap-3">
            <svg class="w-5 h-5 text-military-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-400">Tactical Tree View</span>
        </div>
        <div class="p-4 bg-slate-50">
             <div id="tree"></div>
        </div>
    </div>

    <!-- Legend -->
    <div class="mt-6 flex flex-wrap gap-6 items-center bg-white p-4 border border-slate-200">
        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Unit Legend:</span>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-red-600"></span>
            <span class="text-[11px] font-bold text-military-secondary">OFFICER / HQ</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-military-primary"></span>
            <span class="text-[11px] font-bold text-military-secondary">COMPANY</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-military-accent"></span>
            <span class="text-[11px] font-bold text-military-secondary">PLATOON</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-amber-600"></span>
            <span class="text-[11px] font-bold text-military-secondary">SECTION</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-slate-500"></span>
            <span class="text-[11px] font-bold text-military-secondary">SOLDIER</span>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://balkan.app/js/orgchart.js"></script>
<script>
    var chart;
    window.onload = function () {
        var data = @json($soldiers);

        OrgChart.templates.military = Object.assign({}, OrgChart.templates.ana);
        OrgChart.templates.military.size = [250, 100];
        OrgChart.templates.military.node = '<rect x="0" y="0" height="100" width="250" fill="#ffffff" stroke-width="1" stroke="#2F4F3E" rx="0" ry="0"></rect>';
        OrgChart.templates.military.field_0 = '<text style="font-size: 14px; font-weight: bold;" fill="#2F4F3E" x="125" y="40" text-anchor="middle">{val}</text>';
        OrgChart.templates.military.field_1 = '<text style="font-size: 11px;" fill="#6B8E23" x="125" y="65" text-anchor="middle">{val}</text>';
        OrgChart.templates.military.img_0 = '<image preserveAspectRatio="xMidYMid slice" xlink:href="{val}" x="10" y="10" width="80" height="80"></image>';
        
        // Custom color based on unit_type
        OrgChart.templates.military_officer = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_officer.node = '<rect x="0" y="0" height="100" width="250" fill="#fef2f2" stroke-width="2" stroke="#B91C1C" rx="0" ry="0"></rect>';

        OrgChart.templates.military_company = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_company.node = '<rect x="0" y="0" height="100" width="250" fill="#f0fdf4" stroke-width="2" stroke="#2F4F3E" rx="0" ry="0"></rect>';

        OrgChart.templates.military_platoon = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_platoon.node = '<rect x="0" y="0" height="100" width="250" fill="#f7fee7" stroke-width="2" stroke="#6B8E23" rx="0" ry="0"></rect>';

        OrgChart.templates.military_section = Object.assign({}, OrgChart.templates.military);
        OrgChart.templates.military_section.node = '<rect x="0" y="0" height="100" width="250" fill="#fffbeb" stroke-width="2" stroke="#D97706" rx="0" ry="0"></rect>';

        chart = new OrgChart(document.getElementById("tree"), {
            template: "military",
            enableSearch: true,
            mouseWheel: OrgChart.action.zoom,
            nodeBinding: {
                field_0: "name",
                field_1: "title",
                img_0: "img"
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

        chart.draw();
    };
</script>
@endsection
