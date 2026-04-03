@extends('layouts.admin')

@section('title', 'New Personnel Enrollment')

@section('styles')
<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
        height: 12px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #1e3a2f;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    [x-cloak] {
        display: none !important;
    }

    .tactical-glass {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(30, 58, 47, 0.1);
    }

    .dark .tactical-glass {
        background: rgba(15, 23, 42, 0.8);
        border-color: rgba(132, 204, 22, 0.1);
    }

    .card-zoom {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-zoom:hover {
        transform: translateY(-2px);
    }

    .tactical-input {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        transition: all 0.2s;
        color: #1e293b;
    }

    .tactical-input:focus {
        border-color: #1e3a2f;
        box-shadow: 0 0 0 4px rgba(30, 58, 47, 0.05);
        outline: none;
    }

    .section-header {
        background: #1e3a2f;
    }

    .card-title-tactical {
        font-family: 'Inter', 'Hind Siliguri', sans-serif;
        letter-spacing: 0.15em;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 11px;
    }

    .font-bengali {
        font-family: 'Hind Siliguri', sans-serif;
    }
    .tactical-dropdown-menu {
        background: #1e3a2f;
        border: 1px solid rgba(132, 204, 22, 0.2);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }
    .tactical-dropdown-item {
        transition: all 0.2s;
        border-left: 3px solid transparent;
    }
    .tactical-dropdown-item:hover {
        background: rgba(132, 204, 22, 0.1);
        border-left-color: #84cc16;
        padding-left: 1.25rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-[1400px] mx-auto px-4 py-10" x-data="enrollmentForm()" x-cloak>
    <!-- Header Navigation -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
        <div>
            <h1 class="text-4xl font-black text-military-primary tracking-tight uppercase flex items-center gap-3">
                <span class="w-2 h-10 bg-military-accent"></span>
                Personnel Enrollment
            </h1>
            <p class="text-slate-400 font-bold text-xs mt-2 uppercase tracking-[0.2em] ml-5">New Strategic Asset Entry</p>
        </div>
        <div class="flex items-center gap-4 bg-white p-2 rounded shadow-sm border border-slate-100">
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest px-3">Status:</span>
            <span class="px-4 py-2 bg-military-accent/10 text-military-accent text-[10px] font-black uppercase tracking-widest rounded-sm border border-military-accent/20">Awaiting Data</span>
        </div>
    </div>

    <form action="{{ route('admin.soldiers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf

        <!-- 1. Deployment Hierarchy -->
        <div class="bg-military-primary text-white p-8 shadow-2xl border-b-4 border-military-accent">
            <h3 class="card-title-tactical mb-8 text-military-accent flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 20l-5.447-2.724A2 2 0 013 15.382V6.618a2 2 0 011.553-1.944L9 4m0 16l4-2m-4 2V4m4 14l5.447 2.724A2 2 0 0021 18.618V9.82a2 2 0 00-1.553-1.944L14 6m0 12V6m0 0L9 4"></path></svg>
                Chain of Command Allocation
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Battalion -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Battalion Level</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" 
                                class="w-full bg-white/5 border border-white/10 p-4 text-sm font-bold flex items-center justify-between hover:bg-white/10 transition-all text-left">
                            <span x-text="allUnits.find(u => u.id == selectedBattalionId)?.name || '- Select Battalion -'"></span>
                            <svg class="w-4 h-4 text-military-accent transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar">
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

                <!-- Company -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Force Element (Coy)</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedBattalionId"
                                class="w-full bg-white/5 border border-white/10 p-4 text-sm font-bold flex items-center justify-between hover:bg-white/10 transition-all text-left disabled:opacity-30">
                            <span x-text="allUnits.find(u => u.id == selectedCompanyId)?.name || '- Select Company -'"></span>
                            <svg class="w-4 h-4 text-military-accent transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar">
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

                <!-- Platoon -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Tactical Unit (Platoon)</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedCompanyId"
                                class="w-full bg-white/5 border border-white/10 p-4 text-sm font-bold flex items-center justify-between hover:bg-white/10 transition-all text-left disabled:opacity-30">
                            <span x-text="allUnits.find(u => u.id == selectedPlatoonId)?.name || '- Select Platoon -'"></span>
                            <svg class="w-4 h-4 text-military-accent transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar">
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

                <!-- Section -->
                <div class="space-y-2" x-data="{ open: false }">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Squad/Section</label>
                    <div class="relative">
                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedPlatoonId"
                                class="w-full bg-white/5 border border-white/10 p-4 text-sm font-bold flex items-center justify-between hover:bg-white/10 transition-all text-left disabled:opacity-30">
                            <span x-text="allUnits.find(u => u.id == selectedSectionId)?.name || '- Select Section -'"></span>
                            <svg class="w-4 h-4 text-military-accent transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-50 w-full mt-2 py-2 tactical-dropdown-menu max-h-60 overflow-y-auto custom-scrollbar">
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

            <div class="mt-8 p-4 bg-white/5 border border-white/10 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-military-accent flex items-center justify-center">
                        <svg class="w-5 h-5 text-military-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Active Deployment Path</p>
                        <p class="text-lg font-black text-military-accent mt-1" x-text="finalUnitName || 'Waiting for Selection...'"></p>
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
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="JOHN DOE">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Service Number [নং]</label>
                                <input type="text" name="number" value="{{ old('number') }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="123456">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Rank [পদবী]</label>
                                <input type="text" name="rank" value="{{ old('rank') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="MAJOR">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Appointment [নিয়োগ]</label>
                                <input type="text" name="appointment" value="{{ old('appointment') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="CHM">
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">নাম [বাংলায়]</label>
                                <input type="text" name="name_bn" value="{{ old('name_bn') }}" class="w-full p-4 tactical-input text-sm font-bold" placeholder="মোঃ জন ডো">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Personal No [পি নং]</label>
                                <input type="text" name="personal_no" value="{{ old('personal_no') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="BA-1234">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">পদবী [বাংলায়]</label>
                                <input type="text" name="rank_bn" value="{{ old('rank_bn') }}" class="w-full p-4 tactical-input text-sm font-bold" placeholder="মেজর">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">নিয়োগ [বাংলায়]</label>
                                <input type="text" name="appointment_bn" value="{{ old('appointment_bn') }}" class="w-full p-4 tactical-input text-sm font-bold" placeholder="সি এইচ এম">
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
                                    <input type="text" name="shoot_ret" value="{{ old('shoot_ret') }}" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="GRP Result">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Hit</label>
                                    <input type="text" name="shoot_ap" value="{{ old('shoot_ap') }}" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="Hit Result">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">ETS Score</label>
                                    <input type="text" name="shoot_ets" value="{{ old('shoot_ets') }}" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="92">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Night Fire</label>
                                    <input type="text" name="nil_fire" value="{{ old('nil_fire') }}" class="w-full p-4 tactical-input text-sm font-bold text-center border-amber-500/30" placeholder="Passed">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Total Score</label>
                                    <input type="text" name="shoot_total" value="{{ old('shoot_total') }}" class="w-full p-4 tactical-input text-sm font-black text-military-primary text-center bg-military-primary/5" placeholder="Total">
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
                                            <option value="Pass">Pass</option>
                                            <option value="Failed">Failed</option>
                                            <option value="Attend">Attend</option>
                                            <option value="Not Attend">Not Attend</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Biannual 02</label>
                                        <select name="ipft_biannual_2" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            <option value="">- Select -</option>
                                            <option value="Pass">Pass</option>
                                            <option value="Failed">Failed</option>
                                            <option value="Attend">Attend</option>
                                            <option value="Not Attend">Not Attend</option>
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
                                        <input type="text" name="speed_march" value="{{ old('speed_march') }}" placeholder="Pass / 3 of 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Grenade Fire</label>
                                        <input type="text" name="grenade_fire" value="{{ old('grenade_fire') }}" placeholder="Pass / 2 of 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
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
                                                <input type="text" :name="`courses[${index}][name]`" x-model="course.name" class="w-full p-3 tactical-input text-xs font-bold uppercase" placeholder="EX: BMR">
                                            </td>
                                            <td class="p-4">
                                                <input type="text" :name="`courses[${index}][year]`" x-model="course.year" class="w-full p-3 tactical-input text-xs font-bold text-center" placeholder="2023">
                                            </td>
                                            <td class="p-4">
                                                <input type="text" :name="`courses[${index}][result]`" x-model="course.result" class="w-full p-3 tactical-input text-xs font-bold uppercase" placeholder="PASSED">
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
                                <input type="text" name="cdr_plan_this_yr" value="{{ old('cdr_plan_this_yr') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: BMR IN 2ND CYCLE">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">P.Lve Plan (Cycle)</label>
                                <input type="text" name="leave_plan" value="{{ old('leave_plan') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="1ST CYCLE">
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Sports/Games Participation</label>
                                <input type="text" name="sports_participation" value="{{ old('sports_participation') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="ATHLETICS">
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
                        <div x-data="{ photoPreview: null }" class="relative group mx-auto w-Full aspect-[3/4] border-4 border-double border-slate-200 flex items-center justify-center overflow-hidden bg-slate-50">
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
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Date of Enrolment</label>
                                <input type="date" name="enrolment_date" value="{{ old('enrolment_date') }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Rank Implementation Date</label>
                                <input type="date" name="rank_date" value="{{ old('rank_date') }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Position Sequence (#)</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', 100) }}" class="w-full p-4 tactical-input text-sm font-bold bg-military-primary/5 text-center">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Active Status</label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 text-military-primary rounded">
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
                        <input type="text" name="civil_education" value="{{ old('civil_education') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="SSC / HSC">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Weight (KG)</label>
                        <input type="text" name="weight" value="{{ old('weight') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="70 KG">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Blood Group</label>
                        <input type="text" name="blood_group" value="{{ old('blood_group') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="B+">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex flex-col md:flex-row items-center justify-between py-10 border-t-2 border-slate-100 gap-8">
            <div class="flex items-center gap-6 w-full md:w-auto">
                <a href="{{ route('admin.soldiers.index') }}" class="flex-1 md:flex-none px-12 py-5 bg-white border border-slate-300 text-slate-500 text-[11px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all text-center">Dashboard</a>
                <button type="submit" class="flex-1 md:flex-none px-16 py-5 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-military-secondary transition-all active:scale-95">Complete Enrollment</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function enrollmentForm() {
        const allUnits = @json($units);
        
        return {
            allUnits: allUnits,
            selectedBattalionId: '',
            selectedCompanyId: '',
            selectedPlatoonId: '',
            selectedSectionId: '',
            courses: [],

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
