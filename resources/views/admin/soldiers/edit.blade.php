@extends('layouts.admin')

@section('title', 'Refine Strategic Node')

@section('styles')
<style>
    .tactical-input {
        background: rgba(248, 250, 252, 0.8);
        border: 1.5px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .tactical-input:focus {
        border-color: #2F4F3E;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(47, 79, 62, 0.1);
    }
    .section-header {
        background: linear-gradient(90deg, #1e3a2f, #0f172a);
    }
    .card-title-tactical {
        font-family: 'Inter', 'Hind Siliguri', sans-serif;
        letter-spacing: 0.2em;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 10px;
    }
    [x-cloak] { display: none !important; }
    .tactical-dropdown-menu {
        background: #1e3a2f;
        border: 1px solid rgba(132, 204, 22, 0.2);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }
    .tactical-dropdown-item {
        transition: all 0.2s;
        border-left: 3px solid transparent;
        color: white;
    }
    .tactical-dropdown-item:hover {
        background: rgba(132, 204, 22, 0.1);
        border-left-color: #84cc16;
        padding-left: 1.25rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto pb-20 px-4" x-data="enrollmentForm()">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.soldiers.index') }}" class="group p-3 bg-white border border-slate-200 hover:border-military-primary transition-all shadow-sm">
                <svg class="w-6 h-6 text-slate-400 group-hover:text-military-primary transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="space-y-1">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase">Update <span class="text-military-primary">Record</span></h1>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.4em]">Modify Strategic Personnel Node [তথ্য সংশোধন করুন]</p>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-amber-500/5 p-4 border-l-4 border-amber-500">
            <div class="text-right">
                <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Protocol ID: {{ $soldier->number }}</p>
                <p class="text-[14px] font-black text-slate-700 tracking-tight" x-text="finalUnitName || 'Assigned to Force'"></p>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.soldiers.update', $soldier) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- 1. Combat Node Hierarchical Selection -->
        <div class="bg-white border border-slate-200 p-8 shadow-xl relative">
            <h3 class="text-military-secondary card-title-tactical mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-military-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Current Tactical Assignment [বর্তমান নিযুক্তি]
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- 1. Battalion -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Battalion Level</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" 
                                class="w-full bg-slate-50 border border-slate-200 p-4 text-sm font-bold flex items-center justify-between hover:bg-white transition-all text-left">
                            <span x-text="allUnits.find(u => u.id == selectedBattalionId)?.name || '- Select Battalion -'"></span>
                            <svg class="w-4 h-4 text-military-primary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar shadow-2xl">
                            <template x-for="unit in allUnits.filter(u => u.type === 'battalion')" :key="unit.id">
                                <button type="button" @click="selectedBattalionId = unit.id; resetBelow('battalion'); open = false" 
                                        class="w-full px-4 py-3 text-left text-xs font-bold uppercase tactical-dropdown-item flex items-center justify-between">
                                    <span x-text="unit.name"></span>
                                    <span x-show="selectedBattalionId == unit.id" class="w-2 h-2 bg-military-accent rounded-full"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 2. Company -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Force Element (Coy)</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedBattalionId"
                                class="w-full bg-slate-50 border border-slate-200 p-4 text-sm font-bold flex items-center justify-between hover:bg-white transition-all text-left disabled:opacity-30">
                            <span x-text="allUnits.find(u => u.id == selectedCompanyId)?.name || '- Select Company -'"></span>
                            <svg class="w-4 h-4 text-military-primary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar shadow-2xl">
                            <template x-for="unit in companies" :key="unit.id">
                                <button type="button" @click="selectedCompanyId = unit.id; resetBelow('company'); open = false" 
                                        class="w-full px-4 py-3 text-left text-xs font-bold uppercase tactical-dropdown-item flex items-center justify-between">
                                    <span x-text="unit.name"></span>
                                    <span x-show="selectedCompanyId == unit.id" class="w-2 h-2 bg-military-accent rounded-full"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 3. Platoon -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Tactical Unit (Platoon)</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedCompanyId"
                                class="w-full bg-slate-50 border border-slate-200 p-4 text-sm font-bold flex items-center justify-between hover:bg-white transition-all text-left disabled:opacity-30">
                            <span x-text="allUnits.find(u => u.id == selectedPlatoonId)?.name || '- Select Platoon -'"></span>
                            <svg class="w-4 h-4 text-military-primary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar shadow-2xl">
                            <template x-for="unit in platoons" :key="unit.id">
                                <button type="button" @click="selectedPlatoonId = unit.id; resetBelow('platoon'); open = false" 
                                        class="w-full px-4 py-3 text-left text-xs font-bold uppercase tactical-dropdown-item flex items-center justify-between">
                                    <span x-text="unit.name"></span>
                                    <span x-show="selectedPlatoonId == unit.id" class="w-2 h-2 bg-military-accent rounded-full"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- 4. Section -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Squad/Section</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedPlatoonId"
                                class="w-full bg-slate-50 border border-slate-200 p-4 text-sm font-bold flex items-center justify-between hover:bg-white transition-all text-left disabled:opacity-30">
                            <span x-text="allUnits.find(u => u.id == selectedSectionId)?.name || '- Select Section -'"></span>
                            <svg class="w-4 h-4 text-military-primary transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar shadow-2xl">
                            <template x-for="unit in sections" :key="unit.id">
                                <button type="button" @click="selectedSectionId = unit.id; open = false" 
                                        class="w-full px-4 py-3 text-left text-xs font-bold uppercase tactical-dropdown-item flex items-center justify-between">
                                    <span x-text="unit.name"></span>
                                    <span x-show="selectedSectionId == unit.id" class="w-2 h-2 bg-military-accent rounded-full"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="unit_id" :value="finalUnitId">
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-8">
                <!-- 2. Core Identity -->
                <div class="bg-white border border-slate-200 shadow-xl">
                    <div class="px-8 py-5 section-header flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-01: Strategic Identity [মূল তথ্য]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Full Name [নাম]</label>
                                <input type="text" name="name" value="{{ old('name', $soldier->name) }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Service Number [নং]</label>
                                <input type="text" name="number" value="{{ old('number', $soldier->number) }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Rank [পদবী]</label>
                                <input type="text" name="rank" value="{{ old('rank', $soldier->rank) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Appointment [নিয়োগ]</label>
                                <input type="text" name="appointment" value="{{ old('appointment', $soldier->appointment) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">নাম [বাংলায়]</label>
                                <input type="text" name="name_bn" value="{{ old('name_bn', $soldier->name_bn) }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Personal No [পি নং]</label>
                                <input type="text" name="personal_no" value="{{ old('personal_no', $soldier->personal_no) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">পদবী [বাংলায়]</label>
                                <input type="text" name="rank_bn" value="{{ old('rank_bn', $soldier->rank_bn) }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">নিয়োগ [বাংলায়]</label>
                                <input type="text" name="appointment_bn" value="{{ old('appointment_bn', $soldier->appointment_bn) }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Operational Metrics (TRG CARD) -->
                <div class="bg-white border border-slate-200 shadow-xl">
                    <div class="px-8 py-5 bg-military-primary flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-02: Combat Readiness [যুদ্ধ প্রস্তুতি ও ফলাফল]</h3>
                    </div>
                    <div class="p-8 space-y-10">
                        <!-- Firing Scores -->
                        <div>
                            <p class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-6 border-b border-military-primary/10 pb-2">Firing Efficiency (Shoot Results)</p>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Grouping</label>
                                    <input type="text" name="shoot_ret" value="{{ old('shoot_ret', $soldier->shoot_ret) }}" class="w-full p-4 tactical-input text-sm font-bold text-center">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Hit</label>
                                    <input type="text" name="shoot_ap" value="{{ old('shoot_ap', $soldier->shoot_ap) }}" class="w-full p-4 tactical-input text-sm font-bold text-center">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">ETS Score</label>
                                    <input type="text" name="shoot_ets" value="{{ old('shoot_ets', $soldier->shoot_ets) }}" class="w-full p-4 tactical-input text-sm font-bold text-center">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Night Fire</label>
                                    <input type="text" name="nil_fire" value="{{ old('nil_fire', $soldier->nil_fire) }}" class="w-full p-4 tactical-input text-sm font-bold text-center border-amber-500/30" placeholder="Passed">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Total Score</label>
                                    <input type="text" name="shoot_total" value="{{ old('shoot_total', $soldier->shoot_total) }}" class="w-full p-4 tactical-input text-sm font-black text-military-primary text-center bg-military-primary/5">
                                </div>
                            </div>
                        </div>

                        <!-- Physical & Tactical -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!-- IPFT -->
                            <div class="space-y-6">
                                <p class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-4">Physical Attributes (IPFT)</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Biannual 01</label>
                                        <select name="ipft_biannual_1" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            <option value="">- Select -</option>
                                            <option value="Pass" {{ $soldier->ipft_biannual_1 == 'Pass' ? 'selected' : '' }}>Pass</option>
                                            <option value="Failed" {{ $soldier->ipft_biannual_1 == 'Failed' ? 'selected' : '' }}>Failed</option>
                                            <option value="Attend" {{ $soldier->ipft_biannual_1 == 'Attend' ? 'selected' : '' }}>Attend</option>
                                            <option value="Not Attend" {{ $soldier->ipft_biannual_1 == 'Not Attend' ? 'selected' : '' }}>Not Attend</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Biannual 02</label>
                                        <select name="ipft_biannual_2" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            <option value="">- Select -</option>
                                            <option value="Pass" {{ $soldier->ipft_biannual_2 == 'Pass' ? 'selected' : '' }}>Pass</option>
                                            <option value="Failed" {{ $soldier->ipft_biannual_2 == 'Failed' ? 'selected' : '' }}>Failed</option>
                                            <option value="Attend" {{ $soldier->ipft_biannual_2 == 'Attend' ? 'selected' : '' }}>Attend</option>
                                            <option value="Not Attend" {{ $soldier->ipft_biannual_2 == 'Not Attend' ? 'selected' : '' }}>Not Attend</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Tactical -->
                            <div class="space-y-6">
                                <p class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-4">Tactical Efficiency</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Speed March</label>
                                        <input type="text" name="speed_march" value="{{ old('speed_march', $soldier->speed_march) }}" placeholder="Pass / 3 of 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Grenade Fire</label>
                                        <input type="text" name="grenade_fire" value="{{ old('grenade_fire', $soldier->grenade_fire) }}" placeholder="Pass / 2 of 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Course History -->
                <div class="bg-white border border-slate-200 shadow-xl">
                    <div class="px-8 py-5 bg-slate-800 flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-03: Training & Courses [প্রশিক্ষণ ও কোর্স]</h3>
                        <button type="button" @click="courses.push({name: '', year: '', result: ''})" class="px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-[9px] font-black uppercase tracking-widest transition-all">Add Course Record</button>
                    </div>
                    <div class="p-8">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="p-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Course Designation</th>
                                        <th class="p-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Year</th>
                                        <th class="p-4 text-left text-[9px] font-black text-slate-400 uppercase tracking-widest">Result/Status</th>
                                        <th class="p-4 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(course, index) in courses" :key="index">
                                        <tr class="group hover:bg-slate-50/50 transition-colors">
                                            <td class="p-4">
                                                <input type="text" :name="`courses[${index}][name]`" x-model="course.name" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            </td>
                                            <td class="p-4">
                                                <input type="text" :name="`courses[${index}][year]`" x-model="course.year" class="w-full p-3 tactical-input text-xs font-bold text-center">
                                            </td>
                                            <td class="p-4">
                                                <input type="text" :name="`courses[${index}][result]`" x-model="course.result" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            </td>
                                            <td class="p-4 text-right">
                                                <button type="button" @click="courses.splice(index, 1)" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 5. Strategic Planning -->
                <div class="bg-white border border-slate-200 shadow-xl">
                    <div class="px-8 py-5 bg-amber-600 flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-04: Strategic Forecast [নিযুক্তি ও পরিকল্পনা]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Course/Cdr Plan This Year</label>
                                <input type="text" name="cdr_plan_this_yr" value="{{ old('cdr_plan_this_yr', $soldier->cdr_plan_this_yr) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: BMR IN 2ND CYCLE">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">P.Lve Plan (Cycle)</label>
                                <input type="text" name="leave_plan" value="{{ old('leave_plan', $soldier->leave_plan) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="1ST CYCLE">
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Sports/Games Participation</label>
                                <input type="text" name="sports_participation" value="{{ old('sports_participation', $soldier->sports_participation) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="ATHLETICS">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Sidebar (Photo & Meta) -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Photo -->
                <div class="bg-white border border-slate-200 shadow-xl p-8 sticky top-10">
                    <div class="text-center space-y-8">
                        <div>
                            <h4 class="card-title-tactical text-military-primary mb-2">Upload a Picture</h4>
                        </div>
                        <div x-data="{ photoPreview: '{{ $soldier->photo ? asset('storage/' . $soldier->photo) : null }}' }" class="relative group mx-auto w-Full aspect-[3/4] border-4 border-double border-slate-200 flex items-center justify-center overflow-hidden bg-slate-50">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview">
                                <div class="text-center p-8">
                                    <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Drop Personnel Asset Here</p>
                                </div>
                            </template>
                            <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer z-20"
                                   @change="const reader = new FileReader(); reader.onload = (e) => photoPreview = e.target.result; reader.readAsDataURL($event.target.files[0])">
                        </div>
                        <!-- Deployment Meta -->
                        <div class="space-y-6 pt-6 border-t border-slate-100">
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Rank Implementation Date</label>
                                <input type="date" name="rank_date" value="{{ $soldier->rank_date ? $soldier->rank_date->format('Y-m-d') : '' }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Position Sequence (#)</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $soldier->sort_order) }}" class="w-full p-4 tactical-input text-sm font-bold bg-military-primary/5">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Active Status</label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ $soldier->is_active ? 'checked' : '' }} class="w-5 h-5 text-military-primary rounded">
                                    <span class="text-sm font-bold text-slate-600 uppercase tracking-widest">Deployment Ready</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Extended Bio -->
                <div class="bg-white border border-slate-200 shadow-xl p-8 space-y-6">
                    <h4 class="card-title-tactical mb-4">Extended Bio-Data</h4>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Civil Education</label>
                        <input type="text" name="civil_education" value="{{ old('civil_education', $soldier->civil_education) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Weight (KG)</label>
                        <input type="text" name="weight" value="{{ old('weight', $soldier->weight) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Blood Group</label>
                        <input type="text" name="blood_group" value="{{ old('blood_group', $soldier->blood_group) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex flex-col md:flex-row items-center justify-between py-10 border-t-2 border-slate-100 gap-8">
            <div class="flex items-center gap-6 w-full md:w-auto">
                <a href="{{ route('admin.soldiers.index') }}" class="flex-1 md:flex-none px-12 py-5 bg-white border border-slate-300 text-slate-500 text-[11px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all text-center">Cancel Update</a>
                <button type="submit" class="flex-1 md:flex-none px-16 py-5 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-military-secondary transition-all active:scale-95">Save Changes</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function enrollmentForm() {
        const allUnits = @json($units);
        const currentUnitId = '{{ $soldier->unit_id }}';
        let bId = '', cId = '', pId = '', sId = '';

        if (currentUnitId) {
            const unit = allUnits.find(u => u.id == currentUnitId);
            if (unit) {
                if (unit.type === 'section') {
                    sId = unit.id; bId = unit.p_id_3; cId = unit.p_id_2; pId = unit.parent_id;
                } else if (unit.type === 'platoon') {
                    pId = unit.id; bId = unit.p_id_2; cId = unit.parent_id;
                } // This logic depends on finding parents which we can do via recursive helper
            }
        }

        // Simpler parent finding for Alpine pre-fill
        const findPath = (id) => {
            const path = [];
            let currentId = id;
            while(currentId) {
                const u = allUnits.find(x => parseInt(x.id) === parseInt(currentId));
                if(!u) break;
                path.unshift(u);
                currentId = u.parent_id;
            }
            return path;
        };
        
        const path = findPath(currentUnitId);
        path.forEach(u => {
            if(u.type === 'battalion') bId = u.id;
            if(u.type === 'company') cId = u.id;
            if(u.type === 'platoon') pId = u.id;
            if(u.type === 'section') sId = u.id;
        });

        return {
            allUnits: allUnits,
            selectedBattalionId: bId,
            selectedCompanyId: cId,
            selectedPlatoonId: pId,
            selectedSectionId: sId,
            courses: @json($soldier->courses),

            resetBelow(level) {
                if (level === 'battalion') { this.selectedCompanyId = ''; this.selectedPlatoonId = ''; this.selectedSectionId = ''; }
                else if (level === 'company') { this.selectedPlatoonId = ''; this.selectedSectionId = ''; }
                else if (level === 'platoon') { this.selectedSectionId = ''; }
            },

            get companies() { return this.allUnits.filter(u => u.type === 'company' && u.parent_id == this.selectedBattalionId); },
            get platoons() { return this.allUnits.filter(u => u.type === 'platoon' && u.parent_id == this.selectedCompanyId); },
            get sections() { return this.allUnits.filter(u => u.type === 'section' && u.parent_id == this.selectedPlatoonId); },

            get finalUnitId() { return this.selectedSectionId || this.selectedPlatoonId || this.selectedCompanyId || this.selectedBattalionId; },

            get finalUnitName() {
                if (!this.finalUnitId) return '';
                const unit = this.allUnits.find(u => u.id == this.finalUnitId);
                return unit ? `${unit.type.toUpperCase()}: ${unit.name}` : '';
            }
        }
    }
</script>
@endsection
