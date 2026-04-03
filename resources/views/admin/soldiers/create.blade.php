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
    .dark .tactical-input {
        background: rgba(15, 23, 42, 0.6);
        border-color: rgba(132, 204, 22, 0.1);
        color: white;
    }
    .dark .tactical-input:focus {
        border-color: #84cc16;
        background: rgba(15, 23, 42, 0.9);
        box-shadow: 0 0 0 4px rgba(132, 204, 22, 0.1);
    }
    .section-header {
        background: linear-gradient(90deg, #2F4F3E, #1e3a2f);
    }
    [x-cloak] { display: none !important; }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto pb-20 px-4" x-data="enrollmentForm()">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.soldiers.index') }}" class="group p-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-military-primary transition-all shadow-sm">
                <svg class="w-6 h-6 text-slate-400 group-hover:text-military-primary transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="space-y-1">
                <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase">Enrollment <span class="text-military-primary dark:text-military-accent">Portal</span></h1>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.4em]">Strategic Personnel & Unit Initialization [সদস্য ও ইউনিট অন্তর্ভুক্তি]</p>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-military-primary/5 p-4 border-l-4 border-military-primary">
            <div class="text-right">
                <p class="text-[10px] font-black text-military-primary uppercase tracking-widest">System Status</p>
                <p class="text-[12px] font-bold text-slate-700 dark:text-slate-300">Ready for Strategic Input</p>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.soldiers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Level & Unit Type Selector -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29L5.21 21L12 18L18.79 21L19.5 20.29L12 2Z"/></svg>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
                <div class="space-y-4">
                    <label class="flex items-center gap-2 text-[11px] font-black text-military-primary uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Unit Selection [ইউনিটের ধরন]
                    </label>
                    <select name="unit_type" x-model="unitType" required
                            class="w-full p-4 tactical-input text-sm font-bold uppercase tracking-wider appearance-none cursor-pointer">
                        <option value="officer">OFFICER / ROOT HQ (ব্যাটালিয়ন সদর)</option>
                        <option value="company">COMPANY (কোম্পানি - Level 2)</option>
                        <option value="platoon">PLATOON (প্লাটুন - Level 3)</option>
                        <option value="section">SECTION (সেকশন - Level 4)</option>
                        <option value="soldier">INDIVIDUAL SOLDIER (সৈনিক - Level 5)</option>
                    </select>
                </div>

                <div class="space-y-4">
                    <label class="flex items-center gap-2 text-[11px] font-black text-military-primary uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                        Parent Entity [কার অধীনে]
                    </label>
                    <select name="parent_id" class="w-full p-4 tactical-input text-sm font-bold uppercase tracking-wider appearance-none cursor-pointer">
                        <option value="">NO SUPERIOR / TOP LEVEL</option>
                        <template x-for="unit in filteredParents" :key="unit.id">
                            <option :value="unit.id" x-text="`${unit.rank} ${unit.name} (${unit.number})`"></option>
                        </template>
                    </select>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest" x-text="parentHint"></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Core Identity -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg group">
                    <div class="px-8 py-5 section-header flex items-center justify-between">
                        <h3 class="text-[10px] font-black text-white uppercase tracking-[0.4em] flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Personnel Identity Data (SEC-01)
                        </h3>
                        <span class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Required Fields</span>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Full Name [পুরো নাম]</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="Enter Full Name">
                            @error('name') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Service Number [নং]</label>
                            <input type="text" name="number" value="{{ old('number') }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: 123456">
                            @error('number') <p class="text-red-500 text-[10px] font-bold uppercase mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Rank [পদবী]</label>
                            <input type="text" name="rank" value="{{ old('rank') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: MAJOR">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Appointment [নিযুক্তি]</label>
                            <input type="text" name="appointment" value="{{ old('appointment') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: PL CDR / OC">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Classification [শ্রেণীবিভাগ]</label>
                            <select name="user_type" required class="w-full p-4 tactical-input text-sm font-bold uppercase">
                                <option value="CO">Commanding Office (CO)</option>
                                <option value="JCO">Junior Commissioned Officer (JCO)</option>
                                <option value="Staff" selected>SUPPORT STAFF / SAINIK</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Home District [নিজ জেলা]</label>
                            <input type="text" name="home_district" value="{{ old('home_district') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="Enter District">
                        </div>
                    </div>
                </div>

                <!-- Personal Profile (New Fields) -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="px-8 py-5 bg-military-primary flex items-center justify-between text-white border-b-2 border-military-bg/20">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Extended Personal Profile [ব্যক্তিগত তথ্যাবলী]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Enrolment Date [ভর্তির তাং]</label>
                            <input type="date" name="enrolment_date" value="{{ old('enrolment_date') }}" class="w-full p-4 tactical-input text-sm font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Rank Date [পদের তাং]</label>
                            <input type="date" name="rank_date" value="{{ old('rank_date') }}" class="w-full p-4 tactical-input text-sm font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Civil Education [বেসামরিক শিক্ষা]</label>
                            <input type="text" name="civil_education" value="{{ old('civil_education') }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Weight [ওজন - kg]</label>
                            <input type="text" name="weight" value="{{ old('weight') }}" placeholder="e.g. 72 kg" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit [ইউনিট]</label>
                            <input type="text" name="unit" value="{{ old('unit') }}" placeholder="e.g. 15 EB" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Sub Unit [সাব ইউনিট]</label>
                            <input type="text" name="sub_unit" value="{{ old('sub_unit') }}" placeholder="e.g. Alpha Coy" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Permanent Address [স্থায়ী ঠিকানা]</label>
                            <textarea name="permanent_address" class="w-full p-4 tactical-input text-sm font-bold uppercase" rows="3">{{ old('permanent_address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Course History (Dynamic) -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="px-8 py-5 bg-slate-700 flex items-center justify-between text-white border-b border-slate-800">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Course History [প্রশিক্ষণ ও কোর্স]</h3>
                        <button type="button" @click="courses.push({name: '', chance: '', year: '', result: ''})" class="px-3 py-1 bg-white/10 hover:bg-white/20 border border-white/20 text-[10px] font-bold uppercase tracking-widest transition-all">Add Course</button>
                    </div>
                    <div class="p-8">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">
                                        <th class="pb-4 text-left pl-2">Course Name</th>
                                        <th class="pb-4 text-left">Chance</th>
                                        <th class="pb-4 text-left">Year</th>
                                        <th class="pb-4 text-left">Result</th>
                                        <th class="pb-4"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                    <template x-for="(course, index) in courses" :key="index">
                                        <tr>
                                            <td class="py-4 pl-2"><input type="text" :name="`courses[${index}][name]`" x-model="course.name" class="w-full p-2 bg-transparent border-b border-slate-200 dark:border-slate-700 text-xs font-bold uppercase focus:border-military-primary outline-none"></td>
                                            <td class="py-4"><input type="text" :name="`courses[${index}][chance]`" x-model="course.chance" class="w-full p-2 bg-transparent border-b border-slate-200 dark:border-slate-700 text-xs font-bold uppercase focus:border-military-primary outline-none"></td>
                                            <td class="py-4"><input type="text" :name="`courses[${index}][year]`" x-model="course.year" class="w-full p-2 bg-transparent border-b border-slate-200 dark:border-slate-700 text-xs font-bold uppercase focus:border-military-primary outline-none"></td>
                                            <td class="py-4"><input type="text" :name="`courses[${index}][result]`" x-model="course.result" class="w-full p-2 bg-transparent border-b border-slate-200 dark:border-slate-700 text-xs font-bold uppercase focus:border-military-primary outline-none"></td>
                                            <td class="py-4 text-right">
                                                <button type="button" @click="courses.splice(index, 1)" class="text-red-400 hover:text-red-600 transition-colors">
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

                <!-- Operational Metrics (Biannual & TRG) -->
                <div x-show="unitType === 'soldier'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="space-y-8">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                        <div class="px-8 py-5 bg-military-accent flex items-center justify-between">
                            <h3 class="text-[10px] font-black text-white uppercase tracking-[0.4em] flex items-center gap-3">
                                <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Operational Metrics / TRG Card
                            </h3>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">IPFT Biannual-1</label>
                                <select name="ipft_biannual_1" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    <option value="">SELECT STATUS</option>
                                    @foreach(['Pass', 'Fail', 'Not appeared', 'Yet to appear'] as $r)
                                        <option value="{{ $r }}">{{ strtoupper($r) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">IPFT Biannual-2</label>
                                <select name="ipft_biannual_2" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    <option value="">SELECT STATUS</option>
                                    @foreach(['Pass', 'Fail', 'Not appeared', 'Yet to appear'] as $r)
                                        <option value="{{ $r }}">{{ strtoupper($r) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Shoot To Hit [Ni firing]</label>
                                <input type="text" name="shoot_ret" class="w-full p-3 tactical-input text-xs font-bold font-mono" placeholder="00">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Shoot Total</label>
                                <input type="text" name="shoot_total" class="w-full p-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm font-black text-center text-military-primary" placeholder="000">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Speed March</label>
                                <input type="text" name="speed_march" class="w-full p-3 tactical-input text-xs font-bold" placeholder="EX: 2/4">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Grenade Firing</label>
                                <input type="text" name="grenade_fire" class="w-full p-3 tactical-input text-xs font-bold" placeholder="EX: 1/2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Card: Photo & Misc -->
            <div class="space-y-8">
                <!-- Photo Upload -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg p-8">
                    <div class="text-center space-y-6">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest block">Photo Analysis [ছবি]</label>
                        <div x-data="{ photoPreview: null }" class="relative group mx-auto w-40 h-52 border-2 border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-800/50">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview">
                                <div class="text-center p-4">
                                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                                    <p class="text-[8px] font-black text-slate-400 uppercase">Click to Deploy Photo</p>
                                </div>
                            </template>
                            <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer"
                                   @change="const reader = new FileReader(); reader.onload = (e) => photoPreview = e.target.result; reader.readAsDataURL($event.target.files[0])">
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">JPG/PNG MAX 2.0MB</p>
                    </div>
                </div>

                <!-- Bio Data -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Blood Group</label>
                        <select name="blood_group" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            <option value="">SELECT</option>
                            @foreach(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'] as $bg)
                                <option value="{{ $bg }}">{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit Seniority</label>
                        <input type="number" name="sort_order" value="0" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: 1">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Batch / Intake</label>
                        <input type="text" name="batch" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: 2024-1">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex flex-col md:flex-row items-center justify-between py-10 border-t border-slate-200 dark:border-slate-800 gap-8">
            <div class="flex items-center gap-4">
                <div class="w-3 h-3 rounded-full bg-military-primary animate-pulse"></div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Secure Connection Active &bull; AES-256</p>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.soldiers.index') }}" class="px-10 py-4 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 text-[11px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all">
                    Abort Protocol
                </a>
                <button type="submit" class="px-14 py-4 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-military-secondary transition-all active:scale-95">
                    Commit to Database
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function enrollmentForm() {
        return {
            unitType: 'soldier',
            allUnits: @json($units),
            courses: [],
            trainingPlans: [],
            unitTrainings: [],
            
            get filteredParents() {
                if (this.unitType === 'officer') return [];
                let targetType = '';
                if (this.unitType === 'company') targetType = 'officer';
                if (this.unitType === 'platoon') targetType = 'company';
                if (this.unitType === 'section') targetType = 'platoon';
                if (this.unitType === 'soldier') targetType = 'section';
                return this.allUnits.filter(u => u.unit_type === targetType);
            },

            get parentHint() {
                if (this.unitType === 'officer') return 'OFFICERS are top-level root entities.';
                if (this.unitType === 'company') return 'COMPANIES must report to BATTALION HQ (Officer).';
                if (this.unitType === 'platoon') return 'PLATOONS must report to a COMPANY.';
                if (this.unitType === 'section') return 'SECTIONS must report to a PLATOON.';
                if (this.unitType === 'soldier') return 'SOLDIERS must report to a SECTION.';
                return '';
            }
        }
    }
</script>
@endsection
