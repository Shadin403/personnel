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
        
        <!-- Combat Node Hierarchical Selection -->
        <div class="bg-white border border-slate-200 p-8 shadow-xl relative overflow-hidden">
            <h3 class="text-[11px] font-black text-military-primary uppercase tracking-[0.3em] mb-6 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Current Tactical Assignment [বর্তমান নিযুক্তি]
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
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
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Core Identity -->
                <div class="bg-white border border-slate-200 shadow-lg">
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

                <!-- Course History -->
                <div class="bg-white border border-slate-200 shadow-lg">
                    <div class="px-8 py-5 bg-slate-700 flex items-center justify-between text-white">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.4em]">Course History [প্রশিক্ষণ ও কোর্স]</h3>
                        <button type="button" @click="courses.push({name: '', chance: '', year: '', result: ''})" class="px-3 py-1 bg-white/10 hover:bg-white/20 border border-white/20 text-[10px] font-bold uppercase tracking-widest transition-all">Add Course</button>
                    </div>
                    <div class="p-8">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(course, index) in courses" :key="index">
                                        <tr>
                                            <td class="py-4"><input type="text" :name="`courses[${index}][name]`" x-model="course.name" placeholder="Course Name" class="w-full p-2 bg-transparent border-b border-slate-200 text-xs font-bold uppercase focus:border-military-primary outline-none"></td>
                                            <td class="py-4"><input type="text" :name="`courses[${index}][year]`" x-model="course.year" placeholder="Year" class="w-full p-2 bg-transparent border-b border-slate-200 text-xs font-bold uppercase focus:border-military-primary outline-none"></td>
                                            <td class="py-4 text-right">
                                                <button type="button" @click="courses.splice(index, 1)" class="text-red-400 hover:text-red-600 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Photo Upload -->
                <div class="bg-white border border-slate-200 shadow-lg p-8">
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

                <!-- Sequencing -->
                <div class="bg-white border border-slate-200 shadow-lg p-8 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Position Number [তালিকায় অবস্থান]</label>
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
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Protocol Modification</p>
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
        // Find current hierarchy
        const allUnits = @json($units);
        const currentUnitId = '{{ $soldier->unit_id }}';
        let bId = '', cId = '', pId = '', sId = '';

        if (currentUnitId) {
            const unit = allUnits.find(u => u.id == currentUnitId);
            if (unit) {
                if (unit.type === 'section') {
                    sId = unit.id;
                    const p = allUnits.find(u => u.id == unit.parent_id);
                    if (p) {
                        pId = p.id;
                        const c = allUnits.find(u => u.id == p.parent_id);
                        if (c) {
                            cId = c.id;
                            const b = allUnits.find(u => u.id == c.parent_id);
                            if (b) bId = b.id;
                        }
                    }
                } else if (unit.type === 'platoon') {
                    pId = unit.id;
                    const c = allUnits.find(u => u.id == unit.parent_id);
                    if (c) {
                        cId = c.id;
                        const b = allUnits.find(u => u.id == c.parent_id);
                        if (b) bId = b.id;
                    }
                } else if (unit.type === 'company') {
                    cId = unit.id;
                    const b = allUnits.find(u => u.id == unit.parent_id);
                    if (b) bId = b.id;
                } else if (unit.type === 'battalion') {
                    bId = unit.id;
                }
            }
        }

        return {
            allUnits: allUnits,
            selectedBattalionId: bId,
            selectedCompanyId: cId,
            selectedPlatoonId: pId,
            selectedSectionId: sId,
            courses: @json($soldier->courses),

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
