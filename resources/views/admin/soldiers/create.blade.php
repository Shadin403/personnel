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
            <a href="{{ route('admin.soldiers.index') }}" class="group p-3 bg-white border border-slate-200 hover:border-military-primary transition-all shadow-sm">
                <svg class="w-6 h-6 text-slate-400 group-hover:text-military-primary transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="space-y-1">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase">Enrollment <span class="text-military-primary">Portal</span></h1>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.4em]">Strategic Personnel Enrollment [সদস্য অন্তর্ভুক্তি]</p>
            </div>
        </div>
        <div class="flex items-center gap-4 bg-military-primary/5 p-4 border-l-4 border-military-primary">
            <div class="text-right">
                <p class="text-[10px] font-black text-military-primary uppercase tracking-widest">Enrolling for</p>
                <p class="text-[14px] font-black text-slate-700 tracking-tight" x-text="finalUnitName || 'Select Combat Node'"></p>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('admin.soldiers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Combat Node Hierarchical Selection -->
        <div class="bg-white border border-slate-200 p-8 shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <svg class="w-32 h-32 text-military-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29L5.21 21L12 18L18.79 21L19.5 20.29L12 2Z"/></svg>
            </div>
            
            <h3 class="text-[11px] font-black text-military-primary uppercase tracking-[0.3em] mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Strategic Node Assignment [যুদ্ধ বিন্যাস নিযুক্তি]
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
                <!-- 1. Battalion -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Battalion [ব্যাটালিয়ন]</label>
                    <select x-model="selectedBattalionId" @change="resetBelow('battalion')"
                            class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer">
                        <option value="">- Select -</option>
                        @foreach($groupedUnits['battalion'] as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Company -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Company [কোম্পানি]</label>
                    <select x-model="selectedCompanyId" @change="resetBelow('company')" :disabled="!selectedBattalionId"
                            class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer disabled:opacity-30">
                        <option value="">- Select -</option>
                        <template x-for="unit in companies" :key="unit.id">
                            <option :value="unit.id" x-text="unit.name"></option>
                        </template>
                    </select>
                </div>

                <!-- 3. Platoon -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Platoon [প্লাটুন]</label>
                    <select x-model="selectedPlatoonId" @change="resetBelow('platoon')" :disabled="!selectedCompanyId"
                            class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer disabled:opacity-30">
                        <option value="">- Select -</option>
                        <template x-for="unit in platoons" :key="unit.id">
                            <option :value="unit.id" x-text="unit.name"></option>
                        </template>
                    </select>
                </div>

                <!-- 4. Section -->
                <div class="space-y-4">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Section [সেকশন]</label>
                    <select x-model="selectedSectionId" :disabled="!selectedPlatoonId"
                            class="w-full p-4 tactical-input text-[13px] font-bold uppercase tracking-wider appearance-none cursor-pointer disabled:opacity-30">
                        <option value="">- Select -</option>
                        <template x-for="unit in sections" :key="unit.id">
                            <option :value="unit.id" x-text="unit.name"></option>
                        </template>
                    </select>
                </div>
            </div>

            <!-- Hidden Unit ID Field -->
            <input type="hidden" name="unit_id" x-model="finalUnitId">
            <p class="mt-4 text-[9px] font-bold text-amber-600 uppercase tracking-widest italic" x-show="!finalUnitId">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Soldier must be assigned to an established Command Node above.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Core Identity -->
                <div class="bg-white border border-slate-200 shadow-lg group">
                    <div class="px-8 py-5 section-header flex items-center justify-between">
                        <h3 class="text-[10px] font-black text-white uppercase tracking-[0.4em] flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Personnel Identity Data (SEC-01)
                        </h3>
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

                <!-- Personal Profile -->
                <div class="bg-white border border-slate-200 shadow-lg">
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 border-t-4 border-military-primary">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Enrolment Date [ভর্তির তাং]</label>
                            <input type="date" name="enrolment_date" value="{{ old('enrolment_date') }}" class="w-full p-4 tactical-input text-sm font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Rank Date [পদের তাং]</label>
                            <input type="date" name="rank_date" value="{{ old('rank_date') }}" class="w-full p-4 tactical-input text-sm font-bold">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Card -->
            <div class="space-y-8">
                <!-- Photo Upload -->
                <div class="bg-white border border-slate-200 shadow-lg p-8">
                    <div class="text-center space-y-6">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest block">Photo Analysis [ছবি]</label>
                        <div x-data="{ photoPreview: null }" class="relative group mx-auto w-40 h-52 border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden bg-slate-50">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview">
                                <div class="text-center p-4">
                                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"></path></svg>
                                    <p class="text-[8px] font-black text-slate-400 uppercase">Deploy Photo</p>
                                </div>
                            </template>
                            <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer"
                                   @change="const reader = new FileReader(); reader.onload = (e) => photoPreview = e.target.result; reader.readAsDataURL($event.target.files[0])">
                        </div>
                    </div>
                </div>

                <!-- Sequencing -->
                <div class="bg-white border border-slate-200 shadow-lg p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Position Number [তালিকায় অবস্থান]</label>
                        <input type="number" name="sort_order" value="{{ $nextOrder }}" class="w-full p-4 tactical-input text-sm font-bold uppercase">
                        <p class="text-[9px] text-military-primary font-bold uppercase tracking-widest mt-1 opacity-70">Recommended: #{{ $nextOrder }}</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Batch / Intake</label>
                        <input type="text" name="batch" class="w-full p-4 tactical-input text-sm font-bold uppercase" placeholder="EX: 2024-1">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex flex-col md:flex-row items-center justify-between py-10 border-t border-slate-200 gap-8">
            <div class="flex items-center gap-4">
                <div class="w-3 h-3 rounded-full bg-military-primary animate-pulse"></div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Protocol Ready</p>
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.soldiers.index') }}" class="px-10 py-4 bg-white border border-slate-300 text-slate-600 text-[11px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all">
                    Abort
                </a>
                <button type="submit" class="px-14 py-4 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.2em] shadow-2xl hover:bg-military-secondary transition-all active:scale-95">
                    Commit To Force
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
            allUnits: @json($units),
            selectedBattalionId: '',
            selectedCompanyId: '',
            selectedPlatoonId: '',
            selectedSectionId: '',

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
