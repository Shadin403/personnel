@extends('layouts.admin')

@section('title', 'Strategic Personnel Enrollment')

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
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.2em;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 10px;
    }
    [x-cloak] { display: none !important; }
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
                <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase">Strategic <span class="text-military-primary">Enrollment</span></h1>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.4em]">Full Personnel Restoration [সদস্য অন্তর্ভুক্তি]</p>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-military-primary/5 p-4 border-l-4 border-military-primary">
            <div class="text-right">
                <p class="text-[10px] font-black text-military-primary uppercase tracking-widest">Target Node</p>
                <p class="text-[14px] font-black text-slate-700 tracking-tight" x-text="finalUnitName || 'Select Combat Assignment'"></p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.soldiers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- 1. Combat Node Assignment -->
        <div class="bg-white border border-slate-200 p-8 shadow-xl relative overflow-hidden">
            <h3 class="text-military-secondary card-title-tactical mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-military-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Tactical Hierarchy Alignment [যুদ্ধ বিন্যাস নিযুক্তি]
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Battalion -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Battalion [ব্যাটালিয়ন]</label>
                    <select x-model="selectedBattalionId" @change="resetBelow('battalion')" class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer">
                        <option value="">- Select -</option>
                        @foreach($groupedUnits['battalion'] as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Company -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Company [কোম্পানি]</label>
                    <select x-model="selectedCompanyId" @change="resetBelow('company')" :disabled="!selectedBattalionId" class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer disabled:opacity-30">
                        <option value="">- Select -</option>
                        <template x-for="unit in companies" :key="unit.id">
                            <option :value="unit.id" x-text="unit.name"></option>
                        </template>
                    </select>
                </div>
                <!-- Platoon -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Platoon [প্লাটুন]</label>
                    <select x-model="selectedPlatoonId" @change="resetBelow('platoon')" :disabled="!selectedCompanyId" class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer disabled:opacity-30">
                        <option value="">- Select -</option>
                        <template x-for="unit in platoons" :key="unit.id">
                            <option :value="unit.id" x-text="unit.name"></option>
                        </template>
                    </select>
                </div>
                <!-- Section -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Section [সেকশন]</label>
                    <select x-model="selectedSectionId" :disabled="!selectedPlatoonId" class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer disabled:opacity-30">
                        <option value="">- Select -</option>
                        <template x-for="unit in sections" :key="unit.id">
                            <option :value="unit.id" x-text="unit.name"></option>
                        </template>
                    </select>
                </div>
            </div>
            <input type="hidden" name="unit_id" :value="finalUnitId">
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-8">
                <!-- 2. Core Identity -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-8 py-5 section-header flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-01: Strategic Identity [মূল তথ্য]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- English Info -->
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Full Name [নাম]</label>
                                <input type="text" name="name" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="JOHN DOE">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Service Number [নং]</label>
                                <input type="text" name="number" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="123456">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Rank [পদবী]</label>
                                <input type="text" name="rank" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="MAJOR">
                            </div>
                        </div>
                        <!-- Bengali/Personal Info -->
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">নাম [বাংলায়]</label>
                                <input type="text" name="name_bn" class="w-full p-4 tactical-input text-sm font-bold" placeholder="মোঃ জন ডো">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Personal No [পি নং]</label>
                                <input type="text" name="personal_no" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="BA-1234">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest font-bengali">পদবী [বাংলায়]</label>
                                <input type="text" name="rank_bn" class="w-full p-4 tactical-input text-sm font-bold" placeholder="মেজর">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Operational Metrics (TRG CARD) -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-8 py-5 bg-military-primary flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-02: Combat Readiness [যুদ্ধ প্রস্তুতি ও ফলাফল]</h3>
                    </div>
                    <div class="p-8 spac                            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Grouping</label>
                                    <input type="text" name="shoot_ret" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="Grouping Result">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Hit</label>
                                    <input type="text" name="shoot_ap" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="Hit Result">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">ETS Score</label>
                                    <input type="text" name="shoot_ets" class="w-full p-4 tactical-input text-sm font-bold text-center" placeholder="92">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Night Fire</label>
                                    <input type="text" name="nil_fire" class="w-full p-4 tactical-input text-sm font-bold text-center border-amber-500/30" placeholder="Passed">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Total Score</label>
                                    <input type="text" name="shoot_total" class="w-full p-4 tactical-input text-sm font-black text-military-primary text-center bg-military-primary/5" placeholder="Total">
                                </div>
                            </div>
el>
                                    <input type="text" name="shoot_total" class="w-full p-4 tactical-input text-sm font-black text-military-primary text-center bg-military-primary/5" placeholder="275">
                                </div>
                            </div>
                        </div>
                        <!-- Physical & Tactical -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <!--                                     <div class="space-y-2">
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
                                        <input type="text" name="speed_march" placeholder="Pass / 3 of 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase">Grenade Fire</label>
                                        <input type="text" name="grenade_fire" placeholder="Pass / 2 of 4" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    </div>
                                </div>
                            </div>
option value="Pass">Pass</option>
                                            <option value="Fail">Fail</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Course History -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
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
                                                <input type="text" :name="`courses[${index}][name]`" x-model="course.name" placeholder="EX: BMR COURSE" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                            </td>
                                            <td class="p-4">
                                                <input type="text" :name="`courses[${index}][year]`" x-model="course.year" placeholder="2024" class="w-full p-3 tactical-input text-xs font-bold text-center">
                                            </td>
                                            <td class="p-4">
                                                <input type="text" :name="`courses[${index}][result]`" x-model="course.result" placeholder="AX / BX" class="w-full p-3 tactical-input text-xs font-bold uppercase">
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
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-8 py-5 bg-amber-600 flex items-center justify-between text-white">
                        <h3 class="card-title-tactical">SEC-04: Strategic Forecast [নিযুক্তি ও পরিকল্পনা]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Course/Cdr Plan This Year</label>
                                <input type="text" name="cdr_plan_this_yr" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: BMR IN 2ND CYCLE">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">P.Lve Plan (Cycle)</label>
                                <input type="text" name="leave_plan" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="1ST CYCLE">
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Sports/Games Participation</label>
                                <input type="text" name="sports_participation" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="ATHLETICS / FOOTBALL">
                            </div>
                        </div>
                          <div>
                            <h4 class="card-title-tactical text-military-primary mb-2">Upload a Picture</h4>
                            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">High Resolution Recommended</p>
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
" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Upload Profile Signature</p>
                                </div>
                            </template>
                            <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer z-20"
                                   @change="const reader = new FileReader(); reader.onload = (e) => photoPreview = e.target.result; reader.readAsDataURL($event.target.files[0])">
                        </div>
                        
                        <!-- Deployment Meta -->
                        <div class="space-y-6 pt-6 border-t border-slate-100">
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Rank Implementation Date</label>
                                <input type="date" name="rank_date" class="w-full p-4 tactical-input text-sm font-bold">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Position Sequence (#)</label>
                                <input type="number" name="sort_order" value="{{ $nextOrder }}" class="w-full p-4 tactical-input text-sm font-bold bg-military-primary/5 border-military-primary/30">
                            </div>
                            <div class="space-y-2 text-left">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Force Batch [ব্যাচ]</label>
                                <input type="text" name="batch" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="BATCH-2024">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Extended Bio -->
                <div class="bg-white border border-slate-200 shadow-xl p-8 space-y-6">
                    <h4 class="card-title-tactical mb-4">Extended Bio-Data</h4>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Classification</label>
                        <select name="user_type" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            <option value="CO">Commanding Officer</option>
                            <option value="JCO" selected>Junior Commissioned Officer</option>
                            <option value="Staff">Support Staff / Sainik</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Civil Education</label>
                        <input type="text" name="civil_education" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="HSC / BA / BSC">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Weight (KG)</label>
                        <input type="text" name="weight" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="75 KG">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Blood Group</label>
                        <input type="text" name="blood_group" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="B+ POSITIVE">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex flex-col md:flex-row items-center justify-between py-10 border-t-2 border-slate-100 gap-8">
            <div class="hidden md:flex items-center gap-4">
                <div class="w-4 h-4 bg-military-primary rotate-45"></div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.4em]">Ready for Strategic Integration</p>
            </div>
            <div class="flex items-center gap-6 w-full md:w-auto">
                <a href="{{ route('admin.soldiers.index') }}" class="flex-1 md:flex-none px-12 py-5 bg-white border border-slate-300 text-slate-500 text-[11px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all text-center">Abort Deployment</a>
                <button type="submit" class="flex-1 md:flex-none px-16 py-5 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-military-secondary hover:-translate-y-1 transition-all active:scale-95">Commit Record</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function enrollmentForm() {
        return {
            allUnits: @json($units),
            selectedBattalionId: '',
            selectedCompanyId: '',
            selectedPlatoonId: '',
            selectedSectionId: '',
            courses: [],

            resetBelow(level) {
                if (level === 'battalion') {
                    this.selectedCompanyId = '';
                    this.selectedPlatoonId = '';
                    this.selectedSectionId = '';
                } else if (level === 'company') {
                    this.selectedPlatoonId = '';
                    this.selectedSectionId = '';
                } else if (level === 'platoon') {
                    this.selectedSectionId = '';
                }
            },

            get companies() {
                return this.allUnits.filter(u => u.type === 'company' && u.parent_id == this.selectedBattalionId);
            },
            get platoons() {
                return this.allUnits.filter(u => u.type === 'platoon' && u.parent_id == this.selectedCompanyId);
            },
            get sections() {
                return this.allUnits.filter(u => u.type === 'section' && u.parent_id == this.selectedPlatoonId);
            },

            get finalUnitId() {
                return this.selectedSectionId || this.selectedPlatoonId || this.selectedCompanyId || this.selectedBattalionId;
            },

            get finalUnitName() {
                if (!this.finalUnitId) return '';
                const unit = this.allUnits.find(u => u.id == this.finalUnitId);
                return unit ? `${unit.type.toUpperCase()}: ${unit.name}` : '';
            }
        }
    }
</script>
@endsection
