@extends('layouts.admin')

@section('title', 'Refine Personnel Node')

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
        background: linear-gradient(90deg, #1e3a2f, #0f172a);
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
                <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase">Update <span class="text-military-primary dark:text-military-accent">Record</span></h1>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.4em]">Modify Strategic Personnel Node [তথ্য সংশোধন করুন]</p>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-amber-500/5 p-4 border-l-4 border-amber-500">
            <div class="text-right">
                <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Action: Edit</p>
                <p class="text-[12px] font-bold text-slate-700 dark:text-slate-300">{{ $soldier->number }}</p>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.soldiers.update', $soldier) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Level & Unit Type Selector -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-8 shadow-xl relative overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="flex items-center gap-2 text-[11px] font-black text-military-primary uppercase tracking-widest">
                        Unit Selection [ইউনিটের ধরন]
                    </label>
                    <select name="unit_type" x-model="unitType" required
                            class="w-full p-4 tactical-input text-sm font-bold uppercase tracking-wider appearance-none cursor-pointer">
                        <option value="officer" {{ $soldier->unit_type == 'officer' ? 'selected' : '' }}>OFFICER / ROOT HQ</option>
                        <option value="company" {{ $soldier->unit_type == 'company' ? 'selected' : '' }}>COMPANY (Level 2)</option>
                        <option value="platoon" {{ $soldier->unit_type == 'platoon' ? 'selected' : '' }}>PLATOON (Level 3)</option>
                        <option value="section" {{ $soldier->unit_type == 'section' ? 'selected' : '' }}>SECTION (Level 4)</option>
                        <option value="soldier" {{ $soldier->unit_type == 'soldier' ? 'selected' : '' }}>INDIVIDUAL SOLDIER (Level 5)</option>
                    </select>
                </div>

                <div class="space-y-4">
                    <label class="flex items-center gap-2 text-[11px] font-black text-military-primary uppercase tracking-widest">
                        Parent Entity [কার অধীনে]
                    </label>
                    <select name="parent_id" class="w-full p-4 tactical-input text-sm font-bold uppercase tracking-wider appearance-none cursor-pointer">
                        <option value="">NO SUPERIOR / TOP LEVEL</option>
                        <template x-for="unit in filteredParents" :key="unit.id">
                            <option :value="unit.id" :selected="unit.id == '{{ $soldier->parent_id }}'" x-text="`${unit.rank} ${unit.name} (${unit.number})`"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Core Identity -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="px-8 py-5 section-header flex items-center justify-between text-white">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Core Identity Data</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $soldier->name) }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Service Number</label>
                            <input type="text" name="number" value="{{ old('number', $soldier->number) }}" required class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Rank</label>
                            <input type="text" name="rank" value="{{ old('rank', $soldier->rank) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Appointment</label>
                            <input type="text" name="appointment" value="{{ old('appointment', $soldier->appointment) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Classification [শ্রেণীবিভাগ]</label>
                            <select name="user_type" required class="w-full p-4 tactical-input text-sm font-bold uppercase">
                                <option value="CO" {{ $soldier->user_type == 'CO' ? 'selected' : '' }}>Commanding Officer (CO)</option>
                                <option value="JCO" {{ $soldier->user_type == 'JCO' ? 'selected' : '' }}>Junior Commissioned Officer (JCO)</option>
                                <option value="Staff" {{ $soldier->user_type == 'Staff' ? 'selected' : '' }}>SUPPORT STAFF / SAINIK</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Home District [নিজ জেলা]</label>
                            <input type="text" name="home_district" value="{{ old('home_district', $soldier->home_district) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                    </div>
                </div>

                <!-- Personal Profile (New Fields) -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="px-8 py-5 bg-military-primary flex items-center justify-between text-white">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Extended Personal Profile [ব্যক্তিগত তথ্যাবলী]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Enrolment Date [ভর্তির তাং]</label>
                            <input type="date" name="enrolment_date" value="{{ old('enrolment_date', $soldier->enrolment_date) }}" class="w-full p-4 tactical-input text-sm font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Rank Date [পদের তাং]</label>
                            <input type="date" name="rank_date" value="{{ old('rank_date', $soldier->rank_date) }}" class="w-full p-4 tactical-input text-sm font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Civil Education [বেসামরিক শিক্ষা]</label>
                            <input type="text" name="civil_education" value="{{ old('civil_education', $soldier->civil_education) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Weight [ওজন - kg]</label>
                            <input type="text" name="weight" value="{{ old('weight', $soldier->weight) }}" placeholder="e.g. 72 kg" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit [ইউনিট]</label>
                            <input type="text" name="unit" value="{{ old('unit', $soldier->unit) }}" placeholder="e.g. 15 EB" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Sub Unit [সাব ইউনিট]</label>
                            <input type="text" name="sub_unit" value="{{ old('sub_unit', $soldier->sub_unit) }}" placeholder="e.g. Alpha Coy" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Permanent Address [স্থায়ী ঠিকানা]</label>
                            <textarea name="permanent_address" class="w-full p-4 tactical-input text-sm font-bold uppercase" rows="3">{{ old('permanent_address', $soldier->permanent_address) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Course History (Dynamic) -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                    <div class="px-8 py-5 bg-slate-700 flex items-center justify-between text-white">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Course/Cadre History [প্রশিক্ষণ ও কোর্স]</h3>
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
                <div x-show="unitType === 'soldier'" x-cloak x-transition:enter="transition ease-out duration-300" class="space-y-8">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                        <div class="px-8 py-5 bg-military-accent flex items-center justify-between text-white">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Operational Metrics / TRG Card</h3>
                        </div>
                        <div class="p-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">IPFT Biannual-1</label>
                                <select name="ipft_biannual_1" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    <option value="">SELECT STATUS</option>
                                    @foreach(['Pass', 'Fail', 'Not appeared', 'Yet to appear'] as $r)
                                        <option value="{{ $r }}" {{ $soldier->ipft_biannual_1 == $r ? 'selected' : '' }}>{{ strtoupper($r) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">IPFT Biannual-2</label>
                                <select name="ipft_biannual_2" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    <option value="">SELECT STATUS</option>
                                    @foreach(['Pass', 'Fail', 'Not appeared', 'Yet to appear'] as $r)
                                        <option value="{{ $r }}" {{ $soldier->ipft_biannual_2 == $r ? 'selected' : '' }}>{{ strtoupper($r) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Shoot To Hit [Ni firing]</label>
                                <input type="text" name="shoot_ret" value="{{ old('shoot_ret', $soldier->shoot_ret) }}" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Shoot Total</label>
                                <input type="text" name="shoot_total" value="{{ old('shoot_total', $soldier->shoot_total) }}" class="w-full p-3 bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm font-black text-center text-military-primary">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Speed March</label>
                                <input type="text" name="speed_march" value="{{ old('speed_march', $soldier->speed_march) }}" class="w-full p-3 tactical-input text-xs font-bold" placeholder="EX: 2/4">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Grenade Firing</label>
                                <input type="text" name="grenade_fire" value="{{ old('grenade_fire', $soldier->grenade_fire) }}" class="w-full p-3 tactical-input text-xs font-bold" placeholder="EX: 1/2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg p-8">
                    <div class="text-center space-y-6">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest block">Photo Analysis</label>
                        <div x-data="{ photoPreview: '{{ $soldier->photo ? asset('storage/' . $soldier->photo) : null }}' }" class="relative group mx-auto w-40 h-52 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden bg-slate-50">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer"
                                   @change="const reader = new FileReader(); reader.onload = (e) => photoPreview = e.target.result; reader.readAsDataURL($event.target.files[0])">
                        </div>
                    </div>
                </div>

                <!-- Bio Data -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Blood Group</label>
                        <select name="blood_group" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                            <option value="">SELECT</option>
                            @foreach(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'] as $bg)
                                <option value="{{ $bg }}" {{ $soldier->blood_group == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Unit Seniority</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $soldier->sort_order) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Batch / Intake</label>
                        <input type="text" name="batch" value="{{ old('batch', $soldier->batch) }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between py-10 border-t border-slate-200 gap-8">
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Modify Secure Protocol</p>
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.soldiers.index') }}" class="px-10 py-4 bg-white border border-slate-300 text-slate-600 text-[11px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all">Cancel</a>
                <button type="submit" class="px-14 py-4 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-military-secondary transition-all active:scale-95">Save Changes</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function enrollmentForm() {
        return {
            unitType: '{{ $soldier->unit_type }}',
            allUnits: @json($units),
            courses: @json($soldier->courses),
            trainingPlans: @json($soldier->trainingPlans),
            unitTrainings: @json($soldier->unitTrainings),
            
            get filteredParents() {
                if (this.unitType === 'officer') return [];
                let targetType = '';
                if (this.unitType === 'company') targetType = 'officer';
                if (this.unitType === 'platoon') targetType = 'company';
                if (this.unitType === 'section') targetType = 'platoon';
                if (this.unitType === 'soldier') targetType = 'section';
                return this.allUnits.filter(u => u.unit_type === targetType);
            }
        }
    }
</script>
@endsection
