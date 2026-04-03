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
                    </div>
                </div>

                <div x-show="unitType === 'soldier'" x-cloak x-transition:enter="transition ease-out duration-300" class="space-y-8">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
                        <div class="px-8 py-5 bg-military-accent flex items-center justify-between text-white">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Training Metrics</h3>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">IPFT-1</label>
                                <select name="ipft_biannual_1" class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                    <option value="">N/A</option>
                                    @foreach(['Excellent', 'Good', 'Average', 'Failed'] as $r)
                                        <option value="{{ $r }}" {{ $soldier->ipft_biannual_1 == $r ? 'selected' : '' }}>{{ strtoupper($r) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Repeat for other fields... -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total</label>
                                <input type="text" name="shoot_total" value="{{ $soldier->shoot_total }}" class="w-full p-3 bg-slate-100 border border-slate-300 text-sm font-black text-center">
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
