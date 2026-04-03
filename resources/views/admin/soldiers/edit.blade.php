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
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-8">
                <!-- Strategic Identity Section (Image Reference 1-11) -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-visible">
                    <div class="px-8 py-5 section-header flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-01: Personal Information [ব্যক্তিগত তথ্যাবলী]</h3>
                    </div>
                    
                    <div class="p-8 space-y-8">
                        <!-- Row 1: Personal No & Rank (1 & 2) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১</span>
                                    ব্যক্তিগত নং (Personal No)
                                </label>
                                <input type="text" name="personal_no" value="{{ old('personal_no', $soldier->personal_no) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: BA-1234">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">২</span>
                                    পদবী (Rank)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="rank_bn" value="{{ old('rank_bn', $soldier->rank_bn) }}" class="w-full p-4 tactical-input text-sm font-bold" placeholder="পদবী (বাংলা)">
                                    <input type="text" name="rank" value="{{ old('rank', $soldier->rank) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="RANK (EN)">
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Name (3) -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৩</span>
                                নাম (Full Name)
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="name_bn" value="{{ old('name_bn', $soldier->name_bn) }}" class="w-full p-4 tactical-input text-sm font-bold" placeholder="নাম (বাংলা)">
                                <input type="text" name="name" value="{{ old('name', $soldier->name) }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="FULL NAME (ENGLISH)">
                            </div>
                        </div>

                        <!-- Row 3: Appointment (4) -->
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৪</span>
                                নিযুক্তি (Appointment)
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" name="appointment_bn" value="{{ old('appointment_bn', $soldier->appointment_bn) }}" class="w-full p-4 tactical-input text-sm font-bold" placeholder="নিযুক্তি (বাংলা)">
                                <input type="text" name="appointment" value="{{ old('appointment', $soldier->appointment) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="APPOINTMENT (EN)">
                            </div>
                        </div>

                        <!-- Row 4: Unit/Sub Unit (5) -->
                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৫</span>
                                ইউনিট/সাব ইউনিট (Unit/Sub Unit Hierarchy)
                            </label>
                            
                            <!-- Tactical Hierarchy Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Battalion -->
                                <div class="space-y-1" x-data="{ open: false }">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Battalion</label>
                                    <div class="relative">
                                        <button type="button" @click="open = !open" @click.away="open = false" 
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left">
                                            <span x-text="allUnits.find(u => u.id == selectedBattalionId)?.name || 'Select BATTALION'"></span>
                                            <svg class="w-3 h-3 text-military-primary" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                            <template x-for="unit in allUnits.filter(u => u.type === 'battalion')" :key="unit.id">
                                                <button type="button" @click="selectedBattalionId = unit.id; resetBelow('battalion'); open = false" 
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                    <span x-text="unit.name"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <!-- Company -->
                                <div class="space-y-1" x-data="{ open: false }">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Company</label>
                                    <div class="relative">
                                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedBattalionId"
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left disabled:opacity-50">
                                            <span x-text="allUnits.find(u => u.id == selectedCompanyId)?.name || 'Select COY'"></span>
                                            <svg class="w-3 h-3 text-military-primary" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                            <template x-for="unit in companies" :key="unit.id">
                                                <button type="button" @click="selectedCompanyId = unit.id; resetBelow('company'); open = false" 
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                    <span x-text="unit.name"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <!-- Platoon -->
                                <div class="space-y-1" x-data="{ open: false }">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Platoon</label>
                                    <div class="relative">
                                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedCompanyId"
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left disabled:opacity-50">
                                            <span x-text="allUnits.find(u => u.id == selectedPlatoonId)?.name || 'Select PLT'"></span>
                                            <svg class="w-3 h-3 text-military-primary" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                            <template x-for="unit in platoons" :key="unit.id">
                                                <button type="button" @click="selectedPlatoonId = unit.id; resetBelow('platoon'); open = false" 
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                    <span x-text="unit.name"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <!-- Section -->
                                <div class="space-y-1" x-data="{ open: false }">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Section</label>
                                    <div class="relative">
                                        <button type="button" @click="open = !open" @click.away="open = false" :disabled="!selectedPlatoonId"
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left disabled:opacity-50">
                                            <span x-text="allUnits.find(u => u.id == selectedSectionId)?.name || 'Select SEC'"></span>
                                            <svg class="w-3 h-3 text-military-primary" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="open" class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                            <template x-for="unit in sections" :key="unit.id">
                                                <button type="button" @click="selectedSectionId = unit.id; open = false" 
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                    <span x-text="unit.name"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="unit_id" :value="finalUnitId">
                        </div>

                        <!-- Row 5: Dates (6 & 7) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-100">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৬</span>
                                    ভর্তির তারিক (Date of Enrolment)
                                </label>
                                <input type="date" name="enrolment_date" value="{{ old('enrolment_date', $soldier->enrolment_date ? $soldier->enrolment_date->format('Y-m-d') : '') }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৭</span>
                                    পদের তারিখ (Date of Rank)
                                </label>
                                <input type="date" name="rank_date" value="{{ old('rank_date', $soldier->rank_date ? $soldier->rank_date->format('Y-m-d') : '') }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                        </div>

                        <!-- Row 6: Education & Blood Group (8 & 9) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৮</span>
                                    বেসামরিক শিক্ষা (Civil Education)
                                </label>
                                <input type="text" name="civil_education" value="{{ old('civil_education', $soldier->civil_education) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="SSC / HSC / BA">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৯</span>
                                    রক্তের গ্রুপ (Blood Group)
                                </label>
                                <input type="text" name="blood_group" value="{{ old('blood_group', $soldier->blood_group) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: B+ POSITIVE">
                            </div>
                        </div>

                        <!-- Row 7: Weight & Address (10 & 11) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১০</span>
                                    ওজন (Weight - KG)
                                </label>
                                <input type="text" name="weight" value="{{ old('weight', $soldier->weight) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: 72 KG">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১১</span>
                                    স্থায়ী ঠিকানা (Permanent Address)
                                </label>
                                <textarea name="permanent_address" rows="1" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="VILL: ..., P.O: ..., DIST: ...">{{ old('permanent_address', $soldier->permanent_address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEC-02: Personal Information (12-19) -->
                <div class="bg-white border border-slate-200 shadow-xl">
                    <div class="px-8 py-5 bg-slate-800 flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-02: Personal Details [ব্যক্তিগত তথ্য ১২-১৯]</h3>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১২</span>
                                    পিতার নাম (Father's Name)
                                </label>
                                <input type="text" name="father_name" value="{{ old('father_name', $soldier->father_name) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="FATHER'S NAME">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৩</span>
                                    মাতার নাম (Mother's Name)
                                </label>
                                <input type="text" name="mother_name" value="{{ old('mother_name', $soldier->mother_name) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="MOTHER'S NAME">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৪</span>
                                    ধর্ম (Religion)
                                </label>
                                <select name="religion" class="w-full p-4 tactical-input text-sm font-bold">
                                    <option value="">- Select -</option>
                                    <option value="Islam" {{ old('religion', $soldier->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Hinduism" {{ old('religion', $soldier->religion) == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                    <option value="Christianity" {{ old('religion', $soldier->religion) == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                                    <option value="Buddhism" {{ old('religion', $soldier->religion) == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৫</span>
                                    বৈবাহিক অবস্থা
                                </label>
                                <select name="marital_status" class="w-full p-4 tactical-input text-sm font-bold">
                                    <option value="">- Select -</option>
                                    <option value="Married" {{ old('marital_status', $soldier->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Unmarried" {{ old('marital_status', $soldier->marital_status) == 'Unmarried' ? 'selected' : '' }}>Unmarried</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৬</span>
                                    জন্ম তারিখ (DOB)
                                </label>
                                <input type="date" name="dob" value="{{ old('dob', $soldier->dob ? $soldier->dob->format('Y-m-d') : '') }}" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-100">
                             <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৮</span>
                                    জাতীয় পরিচয়পত্র নং (NID)
                                </label>
                                <input type="text" name="nid" value="{{ old('nid', $soldier->nid) }}" class="w-full p-4 tactical-input text-sm font-bold font-mono" placeholder="1990XXXXXXXXXX">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৫</span>
                                    স্ত্রীর নাম (Spouse)
                                </label>
                                <input type="text" name="spouse_name" value="{{ old('spouse_name', $soldier->spouse_name) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="SPOUSE NAME">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Strategic Readiness Section -->
                <div class="bg-white border border-slate-200 shadow-xl">
                    <div class="px-8 py-5 bg-slate-800 flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-03: Combat Readiness [যুদ্ধ প্রস্তুতি ও ফলাফল]</h3>
                    </div>
                    <div class="p-8 space-y-10">
                        <!-- Firing Scores -->
                        <div>
                            <p class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-6 border-b border-military-primary/10 pb-2">Firing Efficiency (Shoot Results)</p>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Grouping</label>
                                    <input type="text" name="shoot_ret" value="{{ old('shoot_ret', $soldier->shoot_ret) }}" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="GRP">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Hit</label>
                                    <input type="text" name="shoot_ap" value="{{ old('shoot_ap', $soldier->shoot_ap) }}" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="Hit">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">ETS Score</label>
                                    <input type="text" name="shoot_ets" value="{{ old('shoot_ets', $soldier->shoot_ets) }}" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="92">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Night Fire</label>
                                    <input type="text" name="nil_fire" value="{{ old('nil_fire', $soldier->nil_fire) }}" class="w-full p-4 tactical-input text-sm font-bold text-center border-amber-500/30" placeholder="Pass">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Total Score</label>
                                    <input type="text" name="shoot_total" value="{{ old('shoot_total', $soldier->shoot_total) }}" class="w-full p-4 tactical-input text-sm font-black text-military-primary text-center bg-military-primary/5" placeholder="Total">
                                </div>
                            </div>
                        </div>

                        <!-- Physical & Tactical -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-2">Physical Proficiency (IPFT)</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Biannual 01</label>
                                        <select name="ipft_biannual_1" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            <option value="">- Select -</option>
                                            <option value="Pass" {{ old('ipft_biannual_1', $soldier->ipft_biannual_1) == 'Pass' ? 'selected' : '' }}>Pass</option>
                                            <option value="Failed" {{ old('ipft_biannual_1', $soldier->ipft_biannual_1) == 'Failed' ? 'selected' : '' }}>Failed</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Biannual 02</label>
                                        <select name="ipft_biannual_2" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            <option value="">- Select -</option>
                                            <option value="Pass" {{ old('ipft_biannual_2', $soldier->ipft_biannual_2) == 'Pass' ? 'selected' : '' }}>Pass</option>
                                            <option value="Failed" {{ old('ipft_biannual_2', $soldier->ipft_biannual_2) == 'Failed' ? 'selected' : '' }}>Failed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-2">Tactical Skills</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Speed March</label>
                                        <input type="text" name="speed_march" value="{{ old('speed_march', $soldier->speed_march) }}" placeholder="Pass / 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Grenade Fire</label>
                                        <input type="text" name="grenade_fire" value="{{ old('grenade_fire', $soldier->grenade_fire) }}" placeholder="Pass / 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEC-04: Training & Courses [প্রশিক্ষণ ও কোর্স/ক্যাডার] -->
                <div class="bg-white border border-slate-200 shadow-xl" x-data="{ 
                    courses: Array.isArray(JSON.parse('{{ json_encode($soldier->courses ?? []) }}')) && JSON.parse('{{ json_encode($soldier->courses ?? []) }}').length > 0
                        ? JSON.parse('{{ json_encode($soldier->courses ?? []) }}')
                        : [
                            { name: 'ওটি/নবীন সৈনিক', chance: '', year: '', authority: '', group: 'সৈনিক' },
                            { name: 'বিটিটি', chance: '', year: '', authority: '', group: 'সৈনিক' },
                            { name: 'কমান্ডো', chance: '', year: '', authority: '', group: 'সৈনিক' },
                            { name: 'বিএমআর', chance: '', year: '', authority: '', group: 'সৈনিক' },
                            { name: 'পিই', chance: '', year: '', authority: '', group: 'সৈনিক' },
                            { name: 'এটিটি', chance: '', year: '', authority: '', group: 'ল্যান্স কর্পোরাল' },
                            { name: 'এনসিও\'স কোর্স', chance: '', year: '', authority: '', group: 'ল্যান্স কর্পোরাল' },
                            { name: 'পিই', chance: '', year: '', authority: '', group: 'ল্যান্স কর্পোরাল' },
                            { name: 'সার্জেন্ট\'স কোর্স', chance: '', year: '', authority: '', group: 'কর্পোরাল' },
                            { name: 'পিই', chance: '', year: '', authority: '', group: 'কর্পোরাল' },
                            { name: 'ওয়ারেন্ট অফিসার্স কোর্স', chance: '', year: '', authority: '', group: 'সার্জেন্ট' },
                            { name: 'পিই', chance: '', year: '', authority: '', group: 'সার্জেন্ট' },
                            { name: 'পিই', chance: '', year: '', authority: '', group: 'ওয়ারেন্ট অফিসার' }
                        ],
                    addCourse() {
                        this.courses.push({ name: '', chance: '', year: '', authority: '', group: 'সাধারণ' });
                    },
                    removeCourse(index) {
                        this.courses.splice(index, 1);
                    }
                }">
                    <div class="px-8 py-5 bg-military-primary flex items-center justify-between text-white shadow-lg">
                        <h3 class="card-title-tactical text-white">SEC-04: Promotion Training & Courses [প্রশিক্ষণ ও কোর্স/ক্যাডার]</h3>
                        <button type="button" @click="addCourse" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">Add Other Course</button>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-16">ক্র: (Sl)</th>
                                    <th class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest">প্রশিক্ষণ ও কোর্স (Course)</th>
                                    <th class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-32 text-center">সুযোগ (Chance)</th>
                                    <th class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-32 text-center">সাল (Year)</th>
                                    <th class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest">ফলাফল ও প্রাধিকার (Details)</th>
                                    <th class="px-6 py-4 text-center w-16"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(course, index) in courses" :key="index">
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs font-bold text-slate-400" x-text="index + 1"></td>
                                        <td class="px-4 py-2">
                                            <div class="flex flex-col gap-1">
                                                <template x-if="course.group">
                                                    <span class="text-[9px] font-black text-military-primary/40 uppercase" x-text="course.group"></span>
                                                </template>
                                                <input type="text" :name="`courses[${index}][name]`" x-model="course.name" 
                                                       class="w-full p-2 bg-transparent border-0 focus:ring-0 text-sm font-bold uppercase placeholder:text-slate-300" placeholder="COURSE NAME">
                                            </div>
                                        </td>
                                        <td class="px-4 py-2">
                                            <select :name="`courses[${index}][chance]`" x-model="course.chance" class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center">
                                                <option value="">- Select -</option>
                                                <option value="1st">1st Chance</option>
                                                <option value="2nd">2nd Chance</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="text" :name="`courses[${index}][year]`" x-model="course.year" 
                                                   class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center" placeholder="2024">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="text" :name="`courses[${index}][authority]`" x-model="course.authority" 
                                                   class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold" placeholder="EX: PASS / AUTH-123">
                                        </td>
                                        <td class="px-4 py-2 text-center text-red-500">
                                            <button type="button" @click="removeCourse(index)" x-show="course.group === 'সাধারণ'" class="text-slate-300 hover:text-red-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Photo & Status) -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white border border-slate-200 shadow-xl p-8 sticky top-10">
                    <div class="text-center space-y-8">
                        <div>
                            <h4 class="card-title-tactical text-military-primary mb-2">Personnel Asset Photo</h4>
                        </div>
                        <div x-data="{ photoPreview: '{{ $soldier->photo_url }}' }" class="relative group mx-auto w-Full aspect-[3/4] border-4 border-double border-slate-200 flex items-center justify-center overflow-hidden bg-slate-50">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview">
                                <div class="text-center p-8">
                                    <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Identify Profile Asset</p>
                                </div>
                            </template>
                            <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer z-20"
                                   @change="const reader = new FileReader(); reader.onload = (e) => photoPreview = e.target.result; reader.readAsDataURL($event.target.files[0])">
                        </div>
                        
                        <div class="space-y-6 pt-6 border-t border-slate-100">
                             <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Service No (#)</label>
                                <input type="text" name="number" value="{{ old('number', $soldier->number) }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="123456">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Position Sequence (#)</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $soldier->sort_order) }}" class="w-full p-4 tactical-input text-sm font-bold bg-military-primary/5 text-center">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Active Readiness</label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ $soldier->is_active ? 'checked' : '' }} class="w-5 h-5 text-military-primary rounded">
                                    <span class="text-sm font-bold text-slate-600 uppercase tracking-widest">Deployment Ready</span>
                                </label>
                            </div>
                        </div>
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
