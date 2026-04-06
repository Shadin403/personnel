@extends('layouts.admin')

@section('title', 'Refine Strategic Node')

@section('styles')
    <style>
        .tactical-input {
            background: rgba(248, 250, 252, 0.8);
            border: 2px solid #94a3b8;
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
            font-family: 'Outfit', 'Inter', 'Hind Siliguri', sans-serif;
            letter-spacing: 0.05em;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 14px;
        }

        .section-header-tactical {
            background: linear-gradient(to right, #1e3a2f, #2d5a47);
            border-left: 8px solid #84cc16;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        [x-cloak] {
            display: none !important;
        }

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
        <!-- Sticky Context Header -->
        <div
            class="sticky top-0 z-[100] bg-slate-50/95 backdrop-blur-md border-b border-slate-200 -mx-4 px-4 py-4 mb-12 shadow-sm transition-all">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.soldiers.index') }}"
                        class="group p-2 bg-white border border-slate-200 hover:border-military-primary transition-all shadow-sm">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-military-primary transition-transform group-hover:-translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div class="space-y-0.5">
                        <h1 class="text-xl font-black text-slate-900 tracking-tight uppercase">Update <span
                                class="text-military-primary">Soldier Record</span></h1>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                            Refining: {{ $soldier->rank }} {{ $soldier->name }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden lg:hidden text-right mr-4 border-r border-slate-200 pr-4">
                        <p class="text-[9px] font-black text-amber-500 uppercase tracking-widest leading-none">Protocol ID
                        </p>
                        <p class="text-[12px] font-black text-slate-700 tracking-tight leading-none mt-1">
                            {{ $soldier->number }}</p>
                    </div>
                    <a href="{{ route('admin.soldiers.index') }}"
                        class="px-6 py-3 bg-white border border-slate-200 text-slate-500 text-[10px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all shadow-sm">
                        Dashboard
                    </a>
                    <button type="button" @click="loading = true; $refs.form.submit()"
                        :disabled="loading"
                        class="px-8 py-3 bg-military-primary text-white text-[10px] font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg shadow-military-primary/20 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <template x-if="loading">
                            <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <span x-text="loading ? 'Finalizing Update...' : 'Update Record'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <form id="soldierUpdateForm" x-ref="form" action="{{ route('admin.soldiers.update', $soldier) }}" method="POST"
            @submit="loading = true"
            enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- User Type & Access Configuration -->
                <div class="lg:col-span-12">
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                        <div class="px-8 py-4 bg-military-primary flex items-center justify-between text-white border-l-8 border-amber-500 shadow-lg">
                            <div class="flex items-center gap-4">
                                <span class="px-2 py-0.5 bg-amber-500 text-military-primary text-[10px] font-black uppercase rounded-sm">AUTH</span>
                                <h3 class="card-title-tactical text-white uppercase tracking-widest">Update Access Configuration</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        User Type (ইউজার টাইপ)
                                    </label>
                                    <select name="user_type" x-model="user_type"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('user_type') border-red-500 @enderror"
                                        required>
                                        <option value="">Select User Type</option>
                                        <option value="Co">Co (Commanding Officer)</option>
                                        <option value="2ic">2ic (Second-in-Command)</option>
                                        <option value="Adjt">Adjt (Adjutant)</option>
                                        <option value="Coy Comd">Coy Comd (Company Commander)</option>
                                        <option value="Coy clk">Coy clk (Company Clerk)</option>
                                        <option value="Jco/OR">Jco/OR (Soldier/View-Only)</option>
                                    </select>
                                    @error('user_type')
                                        <p class="text-[10px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2" x-show="['Co', '2ic', 'Adjt', 'Coy Comd', 'Coy clk'].includes(user_type)">
                                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        Confirm/Reset Password (পাসওয়ার্ড)
                                    </label>
                                    <input type="password" name="password" x-model="password"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('password') border-red-500 @enderror"
                                        placeholder="••••••••">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Provide a password to unlock synchronization.</p>
                                    <template x-if="user_type && ['Co', '2ic', 'Adjt', 'Coy Comd', 'Coy clk'].includes(user_type) && password.length < 6">
                                        <p class="text-[9px] font-bold text-amber-600 uppercase mt-1 italic">Enter at least 6 characters to unlock the form.</p>
                                    </template>
                                    @error('password')
                                        <p class="text-[10px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-8" x-show="user_type === 'Jco/OR' || (['Co', '2ic', 'Adjt', 'Coy Comd', 'Coy clk'].includes(user_type) && password.length >= 6)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <!-- Strategic Identity Section (Image Reference 1-11) -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-visible">
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-military-accent text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-01</span>
                                <h3 class="card-title-tactical text-white">Personnel Identity [মৌলিক তথ্য]</h3>
                            </div>
                        </div>

                        <div class="p-8 space-y-8">


                            <!-- Row 1: Personal No & Rank (1 & 2) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১</span>
                                        ব্যক্তিগত নং (Personal No)
                                    </label>
                                    <input type="text" name="personal_no"
                                        value="{{ old('personal_no', $soldier->personal_no) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('personal_no') border-red-500 @enderror"
                                        placeholder="EX: BA-1234">
                                    @error('personal_no')
                                        <p
                                            class="text-[10px] font-bold text-red-500 uppercase tracking-widest mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">২</span>
                                        পদবী (Rank)
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="space-y-1">
                                            <input type="text" name="rank_bn"
                                                value="{{ old('rank_bn', $soldier->rank_bn) }}"
                                                class="w-full p-4 tactical-input text-sm font-bold @error('rank_bn') border-red-500 @enderror"
                                                placeholder="পদবী (বাংলা)">
                                            @error('rank_bn')
                                                <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="space-y-1">
                                            <input type="text" name="rank" value="{{ old('rank', $soldier->rank) }}"
                                                class="w-full p-4 tactical-input text-sm font-bold @error('rank') border-red-500 @enderror"
                                                placeholder="RANK (EN)">
                                            @error('rank')
                                                <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Name (3) -->
                            <div class="space-y-2">
                                <label
                                    class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span
                                        class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৩</span>
                                    নাম (Full Name)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="space-y-1">
                                        <input type="text" name="name_bn"
                                            value="{{ old('name_bn', $soldier->name_bn) }}"
                                            class="w-full p-4 tactical-input text-sm font-bold @error('name_bn') border-red-500 @enderror"
                                            placeholder="নাম (বাংলা)">
                                        @error('name_bn')
                                            <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1">
                                        <input type="text" name="name" value="{{ old('name', $soldier->name) }}"
                                            class="w-full p-4 tactical-input text-sm font-bold @error('name') border-red-500 @enderror"
                                            placeholder="NAME (EN)">
                                        @error('name')
                                            <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Row 3: Appointment (4) -->
                            <div class="space-y-2">
                                <label
                                    class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span
                                        class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৪</span>
                                    নিযুক্তি (Appointment)
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="appointment_bn"
                                        value="{{ old('appointment_bn', $soldier->appointment_bn) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold"
                                        placeholder="নিযুক্তি (বাংলা)">
                                    <input type="text" name="appointment"
                                        value="{{ old('appointment', $soldier->appointment) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold"
                                        placeholder="APPOINTMENT (EN)">
                                </div>
                            </div>

                            <!-- Row 4: Unit/Sub Unit (5) -->
                            <div class="space-y-4 pt-4 border-t border-slate-100">
                                <label
                                    class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span
                                        class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৫</span>
                                    ইউনিট/সাব ইউনিট (Unit/Sub Unit)
                                </label>

                                <!-- Tactical Hierarchy Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Battalion -->
                                    <div class="space-y-1" x-data="{ open: false }">
                                        <label
                                            class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Battalion</label>
                                        <div class="relative">
                                            <button type="button" @click="open = !open" @click.away="open = false"
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left">
                                                <span
                                                    x-text="allUnits.find(u => u.id == selectedBattalionId)?.name || 'Select BATTALION'"></span>
                                                <svg class="w-3 h-3 text-military-primary"
                                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open"
                                                class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                                <template x-for="unit in allUnits.filter(u => u.type === 'battalion')"
                                                    :key="unit.id">
                                                    <button type="button"
                                                        @click="selectedBattalionId = unit.id; resetBelow('battalion'); open = false"
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                        <span x-text="unit.name"></span>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Company -->
                                    <div class="space-y-1" x-data="{ open: false }">
                                        <label
                                            class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Company</label>
                                        <div class="relative">
                                            <button type="button" @click="open = !open" @click.away="open = false"
                                                :disabled="!selectedBattalionId"
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left disabled:opacity-50">
                                                <span
                                                    x-text="allUnits.find(u => u.id == selectedCompanyId)?.name || 'Select COY'"></span>
                                                <svg class="w-3 h-3 text-military-primary"
                                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open"
                                                class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                                <template x-for="unit in companies" :key="unit.id">
                                                    <button type="button"
                                                        @click="selectedCompanyId = unit.id; resetBelow('company'); open = false"
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                        <span x-text="unit.name"></span>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Platoon -->
                                    <div class="space-y-1" x-data="{ open: false }">
                                        <label
                                            class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Platoon</label>
                                        <div class="relative">
                                            <button type="button" @click="open = !open" @click.away="open = false"
                                                :disabled="!selectedCompanyId"
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left disabled:opacity-50">
                                                <span
                                                    x-text="allUnits.find(u => u.id == selectedPlatoonId)?.name || 'Select PLT'"></span>
                                                <svg class="w-3 h-3 text-military-primary"
                                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open"
                                                class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                                <template x-for="unit in platoons" :key="unit.id">
                                                    <button type="button"
                                                        @click="selectedPlatoonId = unit.id; resetBelow('platoon'); open = false"
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                        <span x-text="unit.name"></span>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Section -->
                                    <div class="space-y-1" x-data="{ open: false }">
                                        <label
                                            class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Section</label>
                                        <div class="relative">
                                            <button type="button" @click="open = !open" @click.away="open = false"
                                                :disabled="!selectedPlatoonId"
                                                class="w-full bg-slate-50 border border-slate-200 p-3 text-xs font-bold flex items-center justify-between hover:bg-slate-100 transition-all text-left disabled:opacity-50">
                                                <span
                                                    x-text="allUnits.find(u => u.id == selectedSectionId)?.name || 'Select SEC'"></span>
                                                <svg class="w-3 h-3 text-military-primary"
                                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open"
                                                class="absolute z-[100] w-full mt-1 py-1 bg-white border border-slate-200 shadow-2xl max-h-48 overflow-y-auto custom-scrollbar">
                                                <template x-for="unit in sections" :key="unit.id">
                                                    <button type="button"
                                                        @click="selectedSectionId = unit.id; open = false"
                                                        class="w-full px-4 py-2 text-left text-[10px] font-bold uppercase hover:bg-military-primary hover:text-white transition-colors">
                                                        <span x-text="unit.name"></span>
                                                    </button>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="unit_id" :value="finalUnitId">
                                <input type="hidden" name="unit"
                                    :value="allUnits.find(u => u.id == selectedBattalionId)?.name || ''">
                                <input type="hidden" name="company" :value="selectedCompanyName">
                                <input type="hidden" name="platoon" :value="selectedPlatoonName">
                                <input type="hidden" name="section" :value="selectedSectionName">
                            </div>

                            <!-- Row 5: Dates (6 & 7) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-100">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৬</span>
                                        ভর্তির তারিখ (Date of Joining)
                                    </label>
                                    <input type="date" name="enrolment_date"
                                        value="{{ old('enrolment_date', $soldier->enrolment_date ? $soldier->enrolment_date->format('Y-m-d') : '') }}"
                                        class="w-full p-4 tactical-input text-sm font-bold">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৭</span>
                                        বর্তমান পদের পদোন্নতির তারিখ (Date of Rank)
                                    </label>
                                    <input type="date" name="rank_date"
                                        value="{{ old('rank_date', $soldier->rank_date ? $soldier->rank_date->format('Y-m-d') : '') }}"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('rank_date') border-red-500 @enderror">
                                    @error('rank_date')
                                        <p class="text-[9px] font-bold text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 6: Education & Blood Group (8 & 9) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৮</span>
                                        এডুকেশন কোয়ালিফিকেশন (Education Qualification)
                                    </label>
                                    <input type="text" name="civil_education"
                                        value="{{ old('civil_education', $soldier->civil_education) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold">
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">৯</span>
                                        রক্তের গ্রুপ (Blood Group)
                                    </label>
                                    <input type="text" name="blood_group"
                                        value="{{ old('blood_group', $soldier->blood_group) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold" placeholder="EX: B+ POSITIVE">
                                </div>
                            </div>

                            <!-- Row 7: Weight & Address (10 & 11) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2 col-span-full">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১১</span>
                                        স্থায়ী ঠিকানা (Permanent Address)
                                    </label>
                                    <textarea name="permanent_address" rows="1" class="w-full p-4 tactical-input text-sm font-bold"
                                        placeholder="VILL: ..., P.O: ..., DIST: ...">{{ old('permanent_address', $soldier->permanent_address) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEC-02: Personal Details [ব্যক্তিগত তথ্যাবলী] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-visible">
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-military-accent text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-02</span>
                                <h3 class="card-title-tactical text-white">Personal Details [ব্যক্তিগত তথ্যাবলী]</h3>
                            </div>
                        </div>
                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১২</span>
                                        পিতার নাম (Father's Name)
                                    </label>
                                    <input type="text" name="father_name"
                                        value="{{ old('father_name', $soldier->father_name) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('father_name') border-red-500 @enderror">
                                    @error('father_name')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৩</span>
                                        মাতার নাম (Mother's Name)
                                    </label>
                                    <input type="text" name="mother_name"
                                        value="{{ old('mother_name', $soldier->mother_name) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('mother_name') border-red-500 @enderror">
                                    @error('mother_name')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৪</span>
                                        ধর্ম (Religion)
                                    </label>
                                    <select name="religion"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('religion') border-red-500 @enderror">
                                        <option value="">- Select -</option>
                                        <option value="Islam"
                                            {{ old('religion', $soldier->religion) == 'Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Hinduism"
                                            {{ old('religion', $soldier->religion) == 'Hinduism' ? 'selected' : '' }}>
                                            Hinduism</option>
                                        <option value="Christianity"
                                            {{ old('religion', $soldier->religion) == 'Christianity' ? 'selected' : '' }}>
                                            Christianity</option>
                                        <option value="Buddhism"
                                            {{ old('religion', $soldier->religion) == 'Buddhism' ? 'selected' : '' }}>
                                            Buddhism</option>
                                    </select>
                                    @error('religion')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৬</span>
                                        লিঙ্গ (Gender)
                                    </label>
                                    <select name="gender" x-model="gender"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('gender') border-red-500 @enderror"
                                        >
                                        <option value="">- Select -</option>
                                        <option value="Male"
                                            {{ old('gender', $soldier->gender) == 'Male' ? 'selected' : '' }}>Male [পুরুষ]
                                        </option>
                                        <option value="Female"
                                            {{ old('gender', $soldier->gender) == 'Female' ? 'selected' : '' }}>Female
                                            [মহিলা]</option>
                                        <option value="Other"
                                            {{ old('gender', $soldier->gender) == 'Other' ? 'selected' : '' }}>Other
                                            [অন্যান্য]</option>
                                    </select>
                                    @error('gender')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৭</span>
                                        বৈবাহিক অবস্থা
                                    </label>
                                    <select name="marital_status"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('marital_status') border-red-500 @enderror">
                                        <option value="">- Select -</option>
                                        <option value="Married"
                                            {{ old('marital_status', $soldier->marital_status) == 'Married' ? 'selected' : '' }}>
                                            Married</option>
                                        <option value="Unmarried"
                                            {{ old('marital_status', $soldier->marital_status) == 'Unmarried' ? 'selected' : '' }}>
                                            Unmarried</option>
                                    </select>
                                    @error('marital_status')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৮</span>
                                        জন্ম তারিখ (DOB)
                                    </label>
                                    <input type="date" name="dob" x-model="dob"
                                        class="w-full p-4 tactical-input text-sm font-bold @error('dob') border-red-500 @enderror"
                                        >
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-100">
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">১৯</span>
                                        জাতীয় পরিচয়পত্র নং (NID)
                                    </label>
                                    <input type="text" name="nid" value="{{ old('nid', $soldier->nid) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold font-mono @error('nid') border-red-500 @enderror">
                                    @error('nid')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[11px] font-black text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 bg-military-primary text-white flex items-center justify-center text-[10px]">২০</span>
                                        স্ত্রীর নাম (Spouse)
                                    </label>
                                    <input type="text" name="spouse_name"
                                        value="{{ old('spouse_name', $soldier->spouse_name) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEC-08: Physical Measurements (Calculated) -->
                    <div class="bg-white border border-slate-200 shadow-xl mb-8 overflow-visible">
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-military-accent text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-08</span>
                                <h3 class="card-title-tactical text-white">Physical Measurements [শারীরিক পরিমাপ ও স্থূলতা]
                                </h3>
                            </div>
                            <div class="flex items-center gap-4">
                                <template x-if="weightStatus === 'Normal'">
                                    <span
                                        class="px-3 py-1 bg-green-500 text-[10px] font-black uppercase tracking-widest">Normal</span>
                                </template>
                                <template x-if="weightStatus === 'Overweight'">
                                    <span
                                        class="px-3 py-1 bg-yellow-500 text-[10px] font-black uppercase tracking-widest">Overweight</span>
                                </template>
                                <template x-if="weightStatus === 'Obese' || weightStatus === 'Obese (WHR)'">
                                    <span
                                        class="px-3 py-1 bg-red-600 text-[10px] font-black uppercase tracking-widest animate-pulse">Obese</span>
                                </template>
                            </div>
                        </div>
                        <div class="p-8 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Weight
                                        (KG)</label>
                                    <input type="number" name="weight" x-model="weight_kg"
                                        class="w-full p-4 tactical-input text-sm font-bold" placeholder="EX: 72" >
                                </div>
                                <div class="col-span-2 space-y-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Height
                                        (Feet & Inches)</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="relative">
                                            <input type="number" name="height_ft" x-model="height_ft"
                                                class="w-full p-4 tactical-input text-sm font-bold pr-10" placeholder="FT"
                                                >
                                            <span
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 pointer-events-none">FT</span>
                                        </div>
                                        <div class="relative">
                                            <input type="number" name="height_in" x-model="height_in"
                                                class="w-full p-4 tactical-input text-sm font-bold pr-10"
                                                placeholder="IN">
                                            <span
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 pointer-events-none">IN</span>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 italic" x-show="height_inch"
                                        x-text="'Total: ' + height_inch + ' Inches'"></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 pt-6 border-t border-slate-100">
                                <template x-if="gender === 'Female'">
                                    <label
                                        class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200 cursor-pointer hover:bg-slate-100 transition-all max-w-md">
                                        <input type="checkbox" name="is_pregnant" x-model="is_pregnant"
                                            class="w-5 h-5 text-military-primary rounded" :checked="is_pregnant">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[10px] font-black text-slate-700 uppercase tracking-widest">Mother
                                                (Pregnant/Lactating)</span>
                                            <span class="text-[9px] text-slate-500">2 Years Consideration</span>
                                        </div>
                                    </label>
                                </template>
                            </div>

                            <!-- Live Analysis Result -->
                            <div
                                class="mt-8 p-6 bg-slate-900 text-white rounded shadow-2xl relative overflow-hidden group">
                                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-all">
                                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z" />
                                    </svg>
                                </div>
                                <div class="relative z-10 flex flex-wrap lg:flex-nowrap gap-8">
                                    <div class="flex-1 min-w-[150px] space-y-1">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Target
                                            Weight Standard</p>
                                        <p class="text-xl font-black text-amber-400"
                                            x-text="(standardWeight || '---') + ' KG'"></p>
                                    </div>
                                    <div
                                        class="flex-1 min-w-[200px] border-l border-slate-700 pl-8 text-right lg:text-left">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Calculated
                                            Status</p>
                                        <p class="text-xl font-black uppercase tracking-tighter"
                                            :class="weightStatus === 'Normal' ? 'text-green-500' : (
                                                weightStatus === 'Overweight' ? 'text-yellow-400' : 'text-red-500')"
                                            x-text="weightStatus"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEC-03.1: IPFT [শারীরিক সক্ষমতা] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mb-8">
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-03.1</span>
                                <h3 class="card-title-tactical text-white">Individual Physical Fitness Training (IPFT)
                                    [শারীরিক সক্ষমতা]</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="space-y-4">
                                    <label
                                        class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-2">Biannual
                                        01 (জানুয়ারি - জুন)</label>
                                    <select name="ipft_biannual_1"
                                        class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                        <option value="">- Select -</option>
                                        <option value="Pass"
                                            {{ in_array(strtoupper(old('ipft_biannual_1', $soldier->ipft_biannual_1) ?? ''), ['PASS', 'P']) ? 'selected' : '' }}>
                                            Pass</option>
                                        <option value="Fail"
                                            {{ in_array(strtoupper(old('ipft_biannual_1', $soldier->ipft_biannual_1) ?? ''), ['FAIL', 'FAILED', 'F', 'FAIL']) ? 'selected' : '' }}>
                                            Fail</option>
                                        <option value="Not Appeared"
                                            {{ old('ipft_biannual_1', $soldier->ipft_biannual_1) == 'Not Appeared' ? 'selected' : '' }}>
                                            Not appeared</option>
                                        <option value="Yet to Appear"
                                            {{ old('ipft_biannual_1', $soldier->ipft_biannual_1) == 'Yet to Appear' ? 'selected' : '' }}>
                                            Yet to appear</option>
                                    </select>
                                </div>
                                <div class="space-y-4">
                                    <label
                                        class="text-[10px] font-black text-military-primary uppercase tracking-widest mb-2">Biannual
                                        02 (জুলাই - ডিসেম্বর)</label>
                                    <select name="ipft_biannual_2"
                                        class="w-full p-3 tactical-input text-xs font-bold uppercase">
                                        <option value="">- Select -</option>
                                        <option value="Pass"
                                            {{ in_array(strtoupper(old('ipft_biannual_2', $soldier->ipft_biannual_2) ?? ''), ['PASS', 'P']) ? 'selected' : '' }}>
                                            Pass</option>
                                        <option value="Fail"
                                            {{ in_array(strtoupper(old('ipft_biannual_2', $soldier->ipft_biannual_2) ?? ''), ['FAIL', 'FAILED', 'F', 'FAIL']) ? 'selected' : '' }}>
                                            Fail</option>
                                        <option value="Not Appeared"
                                            {{ old('ipft_biannual_2', $soldier->ipft_biannual_2) == 'Not Appeared' ? 'selected' : '' }}>
                                            Not appeared</option>
                                        <option value="Yet to Appear"
                                            {{ old('ipft_biannual_2', $soldier->ipft_biannual_2) == 'Yet to Appear' ? 'selected' : '' }}>
                                            Yet to appear</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEC-03.2: RET Firing [আরইটি ফায়ারিং প্রোফাইল] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mb-8">
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-03.2</span>
                                <h3 class="card-title-tactical text-white uppercase tracking-widest">RET FIRING [আরইটি
                                    ফায়ারিং প্রোফাইল]</h3>
                            </div>
                            <button type="button" @click="addFiringRecord"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">+
                                Add Record</button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest w-16 text-center">
                                            Sl</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Firing Date</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Grouping</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Hit</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            ETS</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Status (P/F)</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">
                                            Mark</th>
                                        <th class="px-2 py-4 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(record, index) in firing_records" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-4 py-4 text-xs font-bold text-slate-400 text-center"
                                                x-text="index + 1"></td>
                                            <td class="px-2 py-2"><input type="date"
                                                    :name="`firing_records[${index}][date]`" x-model="record.date"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold">
                                            </td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`firing_records[${index}][grouping]`" x-model="record.grouping"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="GRP"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`firing_records[${index}][hit]`" x-model="record.hit"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="Hit"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`firing_records[${index}][ets]`" x-model="record.ets"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="92"></td>
                                            <td class="px-2 py-2">
                                                <select :name="`firing_records[${index}][status]`" x-model="record.status"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center">
                                                    <option value="Pass">Pass</option>
                                                    <option value="Fail">Fail</option>
                                                </select>
                                            </td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`firing_records[${index}][total]`" x-model="record.total"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-[11px] font-black text-military-primary text-center"
                                                    placeholder="88"></td>
                                            <td class="px-2 py-2 text-center">
                                                <button type="button" @click="removeFiringRecord(index)"
                                                    class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke_width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-03.3: Night Firing [নাইট ফায়ারিং] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mb-8">
                        <div
                            class="px-8 py-4 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm">SEC-03.3</span>
                                <h3 class="card-title-tactical text-white uppercase tracking-widest">Night Firing [নাইট
                                    ফায়ারিং]</h3>
                            </div>
                            <button type="button" @click="addNightFiringRecord"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">+
                                Add Record</button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest w-16 text-center">
                                            Sl</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Date</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Hit</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Status (P/F)</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">
                                            Mark</th>
                                        <th class="px-2 py-4 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(record, index) in night_firing_records" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-4 py-4 text-xs font-bold text-slate-400 text-center"
                                                x-text="index + 1"></td>
                                            <td class="px-2 py-2"><input type="date"
                                                    :name="`night_firing_records[${index}][date]`" x-model="record.date"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold">
                                            </td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`night_firing_records[${index}][hit]`" x-model="record.hit"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="Hit"></td>
                                            <td class="px-2 py-2">
                                                <select :name="`night_firing_records[${index}][status]`"
                                                    x-model="record.status"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center">
                                                    <option value="Pass">Pass</option>
                                                    <option value="Fail">Fail</option>
                                                </select>
                                            </td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`night_firing_records[${index}][total]`" x-model="record.total"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-[11px] font-black text-military-primary text-center"
                                                    placeholder="88"></td>
                                            <td class="px-2 py-2 text-center">
                                                <button type="button" @click="removeNightFiringRecord(index)"
                                                    class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke_width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-03.4 & SEC-03.5: Speed March & Grenade Fire -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mb-8 p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-4">
                                <div class="flex items-center gap-4 mb-4">
                                    <span
                                        class="px-3 py-1 bg-amber-500 text-military-primary text-[10px] font-black uppercase tracking-tighter rounded-sm">SEC-03.4</span>
                                    <p class="text-[10px] font-black text-military-primary uppercase tracking-widest">Speed
                                        March [স্পিড মার্চ]</p>
                                </div>
                                <input type="text" name="speed_march"
                                    value="{{ old('speed_march', $soldier->speed_march) }}" placeholder=" "
                                    class="w-full p-3 tactical-input text-xs font-bold uppercase">
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4 mb-4">
                                    <span
                                        class="px-3 py-1 bg-amber-500 text-military-primary text-[10px] font-black uppercase tracking-tighter rounded-sm">SEC-03.5</span>
                                    <p class="text-[10px] font-black text-military-primary uppercase tracking-widest">
                                        Grenade Fire [গ্রেনেড ফায়ার]</p>
                                </div>
                                <input type="text" name="grenade_fire"
                                    value="{{ old('grenade_fire', $soldier->grenade_fire) }}" placeholder=" "
                                    class="w-full p-3 tactical-input text-xs font-bold uppercase">
                            </div>
                        </div>
                    </div>

                    <!-- SEC-03.6: Night Training [রাত্রীকালীন প্রশিক্ষণ] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mb-8">
                        <div
                            class="px-8 py-4 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm">SEC-03.6</span>
                                <h3 class="card-title-tactical text-white uppercase tracking-widest">Night Training [রাত্রীকালীন প্রশিক্ষণ]</h3>
                            </div>
                            <button type="button" @click="addNightTraining"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">+
                                Add Record</button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest w-16 text-center">
                                            Sl</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Date</th>
                                        <th
                                            class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            Appointment during Trg</th>
                                        <th class="px-2 py-4 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(record, index) in night_trainings" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 text-xs font-bold text-slate-400 text-center"
                                                x-text="index + 1"></td>
                                            <td class="px-4 py-2"><input type="date"
                                                    :name="`night_trainings[${index}][date]`" x-model="record.date"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold">
                                            </td>
                                            <td class="px-4 py-2"><input type="text"
                                                    :name="`night_trainings[${index}][appointment]`"
                                                    x-model="record.appointment"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold uppercase"
                                                    placeholder=" "></td>
                                            <td class="px-2 py-2 text-center">
                                                <button type="button" @click="removeNightTraining(index)"
                                                    class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke_width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-03.7 & SEC-03.8: Group Training & Cycle Ending -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Group Training -->
                        <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                            <div
                                class="px-8 py-4 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                                <div class="flex items-center gap-4">
                                    <span
                                        class="px-3 py-1 bg-amber-500 text-military-primary text-[10px] font-black uppercase tracking-tighter rounded-sm">SEC-03.7</span>
                                    <h3 class="text-[10px] font-black text-white uppercase tracking-widest">Group Training [দলগত প্রশিক্ষণ]</h3>
                                </div>
                                <button type="button" @click="addGroupTraining"
                                    class="text-white hover:text-amber-500 font-bold">+</button>
                            </div>
                            <div class="p-0">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr
                                            class="bg-slate-50 border-b border-slate-200 text-[9px] font-black uppercase tracking-widest text-slate-400">
                                            <th class="px-4 py-2 text-center w-10">Sl</th>
                                            <th class="px-4 py-2">Cycle (1-4)</th>
                                            <th class="px-4 py-2 w-16">Year</th>
                                            <th class="px-4 py-2">Appointment [নিযুক্তি]</th>
                                            <th class="w-8"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(record, index) in group_trainings" :key="index">
                                            <tr class="border-b border-slate-100">
                                                <td class="px-4 py-2 text-[10px] font-bold text-slate-400 text-center"
                                                    x-text="index+1"></td>
                                                <td class="px-2 py-1">
                                                    <select :name="`group_trainings[${index}][circle]`"
                                                        x-model="record.circle"
                                                        class="w-full p-2 bg-transparent text-xs font-bold border-0 focus:ring-0">
                                                        <option value="1st">1st Cycle</option>
                                                        <option value="2nd">2nd Cycle</option>
                                                        <option value="3rd">3rd Cycle</option>
                                                        <option value="4th">4th Cycle</option>
                                                    </select>
                                                </td>
                                                <td class="px-2 py-1"><input type="text"
                                                        :name="`group_trainings[${index}][year]`" x-model="record.year"
                                                        class="w-full p-2 bg-transparent text-xs font-bold border-0 focus:ring-0 text-center"
                                                        placeholder="2024"></td>
                                                <td class="px-2 py-1"><input type="text"
                                                        :name="`group_trainings[${index}][appointment]`"
                                                        x-model="record.appointment"
                                                        class="w-full p-2 bg-transparent text-xs font-bold border-0 focus:ring-0 uppercase"
                                                        placeholder="APPOINTMENT"></td>
                                                <td class="px-2 py-1 text-center"><button type="button"
                                                        @click="removeGroupTraining(index)"
                                                        class="text-red-400">&times;</button></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Cycle Ending Exercise -->
                        <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                            <div
                                class="px-8 py-4 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                                <div class="flex items-center gap-4">
                                    <span
                                        class="px-3 py-1 bg-amber-500 text-military-primary text-[10px] font-black uppercase tracking-tighter rounded-sm">SEC-03.8</span>
                                    <h3 class="text-[10px] font-black text-white uppercase tracking-widest">Cycle Ending Exercise [চক্র সমাপনী অনুশীলন]</h3>
                                </div>
                                <button type="button" @click="addCycleEndingExercise"
                                    class="text-white hover:text-amber-500 font-bold">+</button>
                            </div>
                            <div class="p-0">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr
                                            class="bg-slate-50 border-b border-slate-200 text-[9px] font-black uppercase tracking-widest text-slate-400">
                                            <th class="px-4 py-2 text-center w-10">Sl</th>
                                            <th class="px-4 py-2">Cycle (1-4)</th>
                                            <th class="px-4 py-2 w-16">Year</th>
                                            <th class="px-4 py-2">Appointment [নিযুক্তি]</th>
                                            <th class="w-8"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(record, index) in cycle_ending_exercises"
                                            :key="index">
                                            <tr class="border-b border-slate-100">
                                                <td class="px-4 py-2 text-[10px] font-bold text-slate-400 text-center"
                                                    x-text="index+1"></td>
                                                <td class="px-2 py-1">
                                                    <select :name="`cycle_ending_exercises[${index}][circle]`"
                                                        x-model="record.circle"
                                                        class="w-full p-2 bg-transparent text-xs font-bold border-0 focus:ring-0">
                                                        <option value="1st">1st Cycle</option>
                                                        <option value="2nd">2nd Cycle</option>
                                                        <option value="3rd">3rd Cycle</option>
                                                        <option value="4th">4th Cycle</option>
                                                    </select>
                                                </td>
                                                <td class="px-2 py-1"><input type="text"
                                                        :name="`cycle_ending_exercises[${index}][year]`"
                                                        x-model="record.year"
                                                        class="w-full p-2 bg-transparent text-xs font-bold border-0 focus:ring-0 text-center"
                                                        placeholder="2024"></td>
                                                <td class="px-2 py-1"><input type="text"
                                                        :name="`cycle_ending_exercises[${index}][appointment]`"
                                                        x-model="record.appointment"
                                                        class="w-full p-2 bg-transparent text-xs font-bold border-0 focus:ring-0 uppercase"
                                                        placeholder="APPOINTMENT"></td>
                                                <td class="px-2 py-1 text-center"><button type="button"
                                                        @click="removeCycleEndingExercise(index)"
                                                        class="text-red-400">&times;</button></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- SEC-03.9: Summer Training [গ্রীষ্মকালীন প্রশিক্ষণ] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mb-8">
                        <div
                            class="px-8 py-4 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm">SEC-03.9</span>
                                <h3 class="card-title-tactical text-white uppercase tracking-widest">Summer Training Record
                                    [গ্রীষ্মকালীন প্রশিক্ষণ]</h3>
                            </div>
                            <button type="button" @click="addSummerTrg"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">+
                                Add Year</button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th
                                            class="px-3 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest w-12 text-center">
                                            Sl (ক্রঃ)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest w-24">
                                            Year (বছর)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                            Unit (ইউনিট)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                            Appointment (নিযুক্তি)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                            Standard/Remarks (অর্জিত মান/মন্তব্য)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest w-32">
                                            Signature (স্বাক্ষর)</th>
                                        <th class="px-2 py-4 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(record, index) in field_trainings_summer" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-3 py-4 text-xs font-bold text-slate-400 text-center"
                                                x-text="index + 1"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_summer[${index}][year]`" x-model="record.year"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="2024"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_summer[${index}][unit]`" x-model="record.unit"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold uppercase"
                                                    placeholder="UNIT"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_summer[${index}][appointment]`"
                                                    x-model="record.appointment"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold uppercase"
                                                    placeholder="APPOINTMENT"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_summer[${index}][remarks]`"
                                                    x-model="record.remarks"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="REMARKS"></td>
                                            <td class="px-2 py-2">
                                                <div class="h-8 border-b-2 border-slate-100 border-dashed"></div>
                                            </td>
                                            <td class="px-2 py-2 text-center">
                                                <button type="button" @click="removeSummerTrg(index)"
                                                    class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke_width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-03.10: Winter Training [শীতকালীন প্রশিক্ষণ] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mb-8">
                        <div
                            class="px-8 py-4 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm">SEC-03.10</span>
                                <h3 class="card-title-tactical text-white uppercase tracking-widest">Winter Training Record
                                    [শীতকালীন প্রশিক্ষণ]</h3>
                            </div>
                            <button type="button" @click="addWinterTrg"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">+
                                Add Year</button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th
                                            class="px-3 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest w-12 text-center">
                                            Sl (ক্রঃ)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest w-24">
                                            Year (বছর)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                            Unit (ইউনিট)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                            Appointment (নিযুক্তি)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">
                                            Standard/Remarks (অর্জিত মান/মন্তব্য)</th>
                                        <th
                                            class="px-4 py-4 text-[9px] font-black text-slate-500 uppercase tracking-widest w-32">
                                            Signature (স্বাক্ষর)</th>
                                        <th class="px-2 py-4 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(record, index) in field_trainings_winter" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-3 py-4 text-xs font-bold text-slate-400 text-center"
                                                x-text="index + 1"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_winter[${index}][year]`" x-model="record.year"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="2024"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_winter[${index}][unit]`" x-model="record.unit"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold uppercase"
                                                    placeholder="UNIT"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_winter[${index}][appointment]`"
                                                    x-model="record.appointment"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold uppercase"
                                                    placeholder="APPOINTMENT"></td>
                                            <td class="px-2 py-2"><input type="text"
                                                    :name="`field_trainings_winter[${index}][remarks]`"
                                                    x-model="record.remarks"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="REMARKS"></td>
                                            <td class="px-2 py-2">
                                                <div class="h-8 border-b-2 border-slate-100 border-dashed"></div>
                                            </td>
                                            <td class="px-2 py-2 text-center">
                                                <button type="button" @click="removeWinterTrg(index)"
                                                    class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke_width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-04: Promotion Training & Courses [প্রশিক্ষণ ও কোর্স] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden" x-data="{
                        courses: [],
                        init() {
                            const defaults = [
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
                            ];
                            const existing = {{ json_encode(old('courses', $soldier->courses ?? [])) }};
                            if (existing && existing.length > 0) {
                                this.courses = existing.map((c, i) => {
                                    if (i < defaults.length && !c.group) {
                                        c.group = defaults[i].group;
                                    }
                                    return c;
                                });
                            } else {
                                this.courses = defaults;
                            }
                        },
                        addCourse() {
                            this.courses.push({ name: '', chance: '', year: '', authority: '', group: 'সাধারণ' });
                        },
                        removeCourse(index) {
                            this.courses.splice(index, 1);
                        }
                    }">
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-04</span>
                                <h3 class="card-title-tactical text-white">Promotion Training Course / Cadre</h3>
                            </div>
                            <button type="button" @click="addCourse"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">
                                + Add Other Course
                            </button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-16">
                                            ক্র: (Sl)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                            প্রশিক্ষণ ও কোর্স (Course)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-32 text-center">
                                            সুযোগ (Chance)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-32 text-center">
                                            সাল (Year)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                            ফলাফল ও প্রাধিকার (Details)</th>
                                        <th class="px-6 py-4 text-center w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(course, index) in courses" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 text-xs font-bold text-slate-400" x-text="index + 1">
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="flex flex-col gap-1">
                                                    <template x-if="course.group">
                                                        <span
                                                            class="text-[9px] font-black text-military-primary/40 uppercase"
                                                            x-text="course.group"></span>
                                                    </template>
                                                    <input type="text" :name="`courses[${index}][name]`"
                                                        x-model="course.name"
                                                        class="w-full p-2 bg-transparent border-0 focus:ring-0 text-sm font-bold uppercase placeholder:text-slate-300"
                                                        placeholder="COURSE NAME">
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <select :name="`courses[${index}][chance]`" x-model="course.chance"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center">
                                                    <option value="">- Select -</option>
                                                    <option value="1st">1st Chance</option>
                                                    <option value="2nd">2nd Chance</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="`courses[${index}][year]`"
                                                    x-model="course.year"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="2024">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="`courses[${index}][authority]`"
                                                    x-model="course.authority"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="EX: PASS / AUTH-123">
                                            </td>
                                            <td class="px-4 py-2 text-center text-red-500">
                                                <button type="button" @click="removeCourse(index)"
                                                    x-show="course.group === 'সাধারণ'"
                                                    class="text-slate-300 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-05: Special Training & Courses [সেনাবাহিনী পর্যায়ে কোর্স/ক্যাডার/বিশেষ প্রশিক্ষণ] -->
                    <div class="bg-white border border-slate-200 shadow-xl"
                        x-data='{
                        special_courses: @json($soldier->special_courses ?? []).length ? @json($soldier->special_courses ?? []) : [{ year: "", name: "", unit: "", details: "" }],
                        addSpecialCourse() {
                            this.special_courses.push({ year: "", name: "", unit: "", details: "" });
                        },
                        removeSpecialCourse(index) {
                            this.special_courses.splice(index, 1);
                        }
                    }'>
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg border-l-8 border-amber-500">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-05</span>
                                <h3 class="card-title-tactical text-white">Army level course/cadre & special training [বিশেষ
                                    প্রশিক্ষণ]</h3>
                            </div>
                            <button type="button" @click="addSpecialCourse"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">Add
                                Training Record</button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-16">
                                            ক্র: (Sl)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-24 text-center">
                                            সাল (Year)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                            কোর্স/ক্যাডার (Course/Cadre)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                            প্রতিষ্ঠান/ইউনিট (Inst/Unit)</th>
                                        <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest">
                                            ফলাফল ও প্রাধিকার (Details)</th>
                                        <th class="px-6 py-4 text-center w-16"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(scourse, index) in special_courses" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 text-xs font-bold text-slate-400" x-text="index + 1">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="`special_courses[${index}][year]`"
                                                    x-model="scourse.year"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="2024">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="`special_courses[${index}][name]`"
                                                    x-model="scourse.name"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-sm font-bold uppercase"
                                                    placeholder="SPECIAL COURSE">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="`special_courses[${index}][unit]`"
                                                    x-model="scourse.unit"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="INSTITUTION / UNIT">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" :name="`special_courses[${index}][details]`"
                                                    x-model="scourse.details"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="RESULT / AUTH">
                                            </td>
                                            <td class="px-4 py-2 text-center text-red-500">
                                                <button type="button" @click="removeSpecialCourse(index)"
                                                    class="text-slate-300 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="special_courses.length === 0">
                                        <tr>
                                            <td colspan="6"
                                                class="px-6 py-10 text-center text-slate-300 italic text-xs">
                                                No special training records added. Click 'Add Training Record' to start.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-06: Annual Career Plan [বাৎসরিক পেশা পরিকল্পনা] -->
                    <div class="bg-white border border-slate-200 shadow-xl"
                        x-data='{
                        plans: @json($soldier->annual_career_plans ?? []).length ? @json($soldier->annual_career_plans ?? []) : [{ year: "", leave: "", unit_trg: "", personal_trg: "", admin: "", mootw: "", signature: "" }],
                        addPlan() {
                            this.plans.push({ year: "", leave: "", unit_trg: "", personal_trg: "", admin: "", mootw: "", signature: "" });
                        },
                        removePlan(index) {
                            this.plans.splice(index, 1);
                        }
                    }'>
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-amber-500 text-military-primary text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-06</span>
                                <h3 class="card-title-tactical text-white">Annual Career Plan [বাৎসরিক পেশা পরিকল্পনা]</h3>
                            </div>
                            <button type="button" @click="addPlan"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 text-[10px] font-black uppercase tracking-widest transition-all">Add
                                Yearly Plan</button>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200">
                                        {{-- <th
                                            class="px-6 py-4 text-[11px] font-black text-slate-500 uppercase tracking-widest w-16">
                                            ক্র: (Sl)</th> --}}

                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest w-24 text-center">
                                            বছর (Year)</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            ছুটি (P/Leave)</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            ইউনিট প্রশিক্ষণ</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            ব্যক্তিগত প্রশিক্ষণ (Personal Trg)</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            প্রশাসন (Admin)</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            MOOTW</th>
                                        <th
                                            class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                            স্বাক্ষর (Sign)</th>
                                        <th class="px-2 py-4 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(plan, index) in plans" :key="index">
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            {{-- <td class="px-6 py-4 text-xs font-bold text-slate-400" x-text="index + 1">
                                            </td> --}}
                                            <td class="px-2 py-2">
                                                <input type="text" :name="`annual_career_plans[${index}][year]`"
                                                    x-model="plan.year"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold text-center"
                                                    placeholder="2024">
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="text" :name="`annual_career_plans[${index}][leave]`"
                                                    x-model="plan.leave"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="Annual">
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="text" :name="`annual_career_plans[${index}][unit_trg]`"
                                                    x-model="plan.unit_trg"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="Cycle">
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="text"
                                                    :name="`annual_career_plans[${index}][personal_trg]`"
                                                    x-model="plan.personal_trg"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="Cycle">
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="text" :name="`annual_career_plans[${index}][admin]`"
                                                    x-model="plan.admin"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="Cycle">
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="text" :name="`annual_career_plans[${index}][mootw]`"
                                                    x-model="plan.mootw"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-xs font-bold"
                                                    placeholder="Cycle">
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="text" :name="`annual_career_plans[${index}][signature]`"
                                                    x-model="plan.signature"
                                                    class="w-full p-2 bg-transparent border-0 focus:ring-0 text-[10px] font-bold"
                                                    placeholder="REMARKS / SIGN">
                                            </td>
                                            <td class="px-2 py-2 text-center text-red-500">
                                                <button type="button" @click="removePlan(index)"
                                                    class="text-slate-300 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="plans.length === 0">
                                        <tr>
                                            <td colspan="8"
                                                class="px-6 py-10 text-center text-slate-300 italic text-xs">
                                                No yearly plans added. Click 'Add Yearly Plan' to start.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <div class="px-8 py-4 bg-amber-50 border-t border-amber-100 flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0 ring-4 ring-white shadow-sm">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-[10px] font-black text-amber-900 uppercase tracking-widest mb-0.5">
                                        অফিসিয়াল নির্দেশনা (OFFICIAL DIRECTIVE)</h4>
                                    <p class="text-[14px] font-black text-amber-700 leading-tight">নোটঃ প্রতি বছরে পেশা
                                        পরিকল্পনার প্রতিটি কলামে চক্র উল্লেখ করতে হবে।</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEC-07: Sports Participation [খেলাধুলা ও অন্যান্য] -->
                    <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mt-8">
                        <div
                            class="px-8 py-6 section-header-tactical flex items-center justify-between text-white shadow-lg bg-gradient-to-r from-military-primary to-military-primary/90">
                            <div class="flex items-center gap-4">
                                <span
                                    class="px-3 py-1 bg-green-500 text-white text-[11px] font-black uppercase tracking-tighter rounded-sm shadow-sm ring-2 ring-white/20">SEC-07</span>
                                <h3 class="card-title-tactical text-white uppercase tracking-widest">Physical & Extra Curricular Activities</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <textarea name="sports_participation" rows="4" class="w-full p-4 tactical-input text-sm font-bold uppercase"
                                placeholder="Describe participation in sports, extra-curricular events, or other strategic interests...">{{ old('sports_participation', $soldier->sports_participation) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Photo & Status) -->
                <div class="lg:col-span-4 space-y-8" x-show="user_type === 'Jco/OR' || (['Co', '2ic', 'Adjt', 'Coy Comd', 'Coy clk'].includes(user_type) && password.length >= 6)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="bg-white border border-slate-200 shadow-xl p-8 sticky top-10">
                        <div class="text-center space-y-8">
                            <div>
                                <h4 class="card-title-tactical text-military-primary mb-2">Upload Soldier Photo</h4>
                            </div>
                            <div x-data="{ photoPreview: '{{ $soldier->photo_url }}' }"
                                class="relative group mx-auto w-Full aspect-[3/4] border-4 border-double border-slate-200 flex items-center justify-center overflow-hidden bg-slate-50">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    <div class="text-center p-8">
                                        <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Add or
                                            Change Photo</p>
                                    </div>
                                </template>
                                <input type="file" name="photo"
                                    class="absolute inset-0 opacity-0 cursor-pointer z-20"
                                    @change="const reader = new FileReader(); reader.onload = (e) => photoPreview = e.target.result; reader.readAsDataURL($event.target.files[0])">
                            </div>

                            <div class="space-y-6 pt-6 border-t border-slate-100">
                                <div class="hidden space-y-2 text-left">
                                    <label
                                        class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Protocol
                                        Number (#)</label>
                                    <input type="text" name="number"
                                        value="{{ old('number', $soldier->number) }}" required
                                        class="w-full p-4 tactical-input text-sm font-bold @error('number') border-red-500 @enderror"
                                        placeholder="123456">
                                    @error('number')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2 text-left">
                                    <label
                                        class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Position
                                        Sequence (#)</label>
                                    <input type="number" name="sort_order"
                                        value="{{ old('sort_order', $soldier->sort_order) }}"
                                        class="w-full p-4 tactical-input text-sm font-bold bg-military-primary/5 text-center @error('sort_order') border-red-500 @enderror">
                                    @error('sort_order')
                                        <p class="text-[9px] font-bold text-red-500 mt-1 uppercase text-center">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2 text-left">
                                    <label
                                        class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Active
                                        Readiness</label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1"
                                            {{ $soldier->is_active ? 'checked' : '' }}
                                            class="w-5 h-5 text-military-primary rounded">
                                        <span
                                            class="text-sm font-bold text-slate-600 uppercase tracking-widest">Deployment
                                            Ready</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            {{-- <div class="flex flex-col md:flex-row items-center justify-between py-10 border-t-2 border-slate-100 gap-8">
                <div class="flex items-center gap-6 w-full md:w-auto">
                    <a href="{{ route('admin.soldiers.index') }}"
                        class="flex-1 md:flex-none px-12 py-5 bg-white border border-slate-300 text-slate-500 text-[11px] font-black uppercase tracking-widest hover:border-red-500 hover:text-red-500 transition-all text-center">Cancel
                        Update</a>
                    <button type="submit"
                        class="flex-1 md:flex-none px-16 py-5 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-military-secondary transition-all active:scale-95">Save
                        Changes</button>
                </div>
            </div> --}}
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function enrollmentForm() {
            const allUnits = @json($units);
            const currentUnitId = '{{ $soldier->unit_id }}';
            let bId = '',
                cId = '',
                pId = '',
                sId = '';

            if (currentUnitId) {
                const unit = allUnits.find(u => u.id == currentUnitId);
                if (unit) {
                    if (unit.type === 'section') {
                        sId = unit.id;
                        bId = unit.p_id_3;
                        cId = unit.p_id_2;
                        pId = unit.parent_id;
                    } else if (unit.type === 'platoon') {
                        pId = unit.id;
                        bId = unit.p_id_2;
                        cId = unit.parent_id;
                    } // This logic depends on finding parents which we can do via recursive helper
                }
            }

            // Simpler parent finding for Alpine pre-fill
            const findPath = (id) => {
                const path = [];
                let currentId = id;
                while (currentId) {
                    const u = allUnits.find(x => parseInt(x.id) === parseInt(currentId));
                    if (!u) break;
                    path.unshift(u);
                    currentId = u.parent_id;
                }
                return path;
            };

            const path = findPath(currentUnitId);
            path.forEach(u => {
                if (u.type === 'battalion') bId = u.id;
                if (u.type === 'company') cId = u.id;
                if (u.type === 'platoon') pId = u.id;
                if (u.type === 'section') sId = u.id;
            });

            return {
                loading: false,
                user_type: '{{ old('user_type', $soldier->user_type) }}',
                password: '',
                allUnits: allUnits,
                selectedBattalionId: bId,
                selectedCompanyId: cId,
                selectedPlatoonId: pId,
                selectedSectionId: sId,
                courses: @json($soldier->courses ?? []),
                field_trainings_summer: @json($soldier->field_trainings_summer ?? []).length ? @json($soldier->field_trainings_summer ?? []) : [{
                    year: '',
                    unit: '',
                    appointment: '',
                    remarks: ''
                }],
                field_trainings_winter: @json($soldier->field_trainings_winter ?? []).length ? @json($soldier->field_trainings_winter ?? []) : [{
                    year: '',
                    unit: '',
                    appointment: '',
                    remarks: ''
                }],
                night_firing_records: @json($soldier->night_firing_records ?? []).length ? @json($soldier->night_firing_records ?? []) : [{
                    date: '',
                    hit: '',
                    total: '',
                    status: '',
                    mark: ''
                }],
                night_trainings: @json($soldier->night_trainings ?? []).length ? @json($soldier->night_trainings ?? []) : [{
                    date: '',
                    appointment: ''
                }],
                group_trainings: @json($soldier->group_trainings ?? []).length ? @json($soldier->group_trainings ?? []) : [{
                    year: '',
                    circle: '1st',
                    appointment: '',
                    unit: '',
                    remarks: ''
                }],
                cycle_ending_exercises: @json($soldier->cycle_ending_exercises ?? []).length ? @json($soldier->cycle_ending_exercises ?? []) : [{
                    year: '',
                    circle: '1st',
                    appointment: '',
                    unit: '',
                    remarks: ''
                }],
                firing_records: @json($soldier->firing_records ?? []).length ? @json($soldier->firing_records ?? []) : [{
                    date: '',
                    grouping: '',
                    hit: '',
                    ets: '',
                    status: '',
                    total: ''
                }],

                // Physical Measurements
                gender: '{{ old('gender', $soldier->gender) }}',
                dob: '{{ old('dob', $soldier->dob ? $soldier->dob->format('Y-m-d') : '') }}',
                height_ft: '{{ old('height_ft', $soldier->height_inch ? floor($soldier->height_inch / 12) : '') }}',
                height_in: '{{ old('height_in', $soldier->height_inch ? $soldier->height_inch % 12 : '') }}',
                weight_kg: '{{ old('weight', $soldier->weight ?: '') }}',
                is_pregnant: {{ old('is_pregnant', $soldier->is_pregnant) ? 'true' : 'false' }},

                get height_inch() {
                    if (!this.height_ft) return 0;
                    return (parseInt(this.height_ft) * 12) + (parseInt(this.height_in) || 0);
                },

                get age() {
                    if (!this.dob) return 0;
                    const birthDate = new Date(this.dob);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
                    return age;
                },

                get weightAllowance() {
                    return 0;
                },

                get standardWeight() {
                    if (!this.height_inch || this.height_inch < 62) return null;
                    const h = parseInt(this.height_inch);
                    const age = this.age;
                    const chart = {
                        62: [59.4, 63.5, 67.6],
                        63: [61.2, 65.3, 69.8],
                        64: [63.5, 67.6, 72.1],
                        65: [65.3, 69.8, 74.4],
                        66: [67.1, 71.7, 76.2],
                        67: [68.5, 73.0, 78.0],
                        68: [69.4, 73.5, 77.6],
                        69: [71.7, 76.2, 80.7],
                        70: [73.5, 78.0, 83.0],
                        71: [75.3, 80.3, 84.8],
                        72: [77.6, 82.1, 87.1]
                    };
                    const targetH = Math.max(62, Math.min(72, h));
                    const row = chart[targetH] || chart[62];
                    if (age <= 30) return row[0];
                    if (age <= 40) return row[1];
                    return row[2];
                },

                get weightStatus() {
                    if (!this.weight_kg || !this.standardWeight) return 'N/A';

                    const actualWeight = parseFloat(this.weight_kg);
                    if (isNaN(actualWeight)) return 'N/A';

                    const adjustedWeight = actualWeight - 3.2; // 7 lbs approx 3.2kg
                    const limit = parseFloat(this.standardWeight);

                    if (adjustedWeight > limit + 6.8) return 'Obese'; // +15 lbs approx 6.8kg
                    if (adjustedWeight > limit) return 'Overweight';
                    if (adjustedWeight < 45) return 'Underweight';
                    return 'Normal';
                },

                addFiringRecord() {
                    this.firing_records.push({
                        date: '',
                        grouping: '',
                        hit: '',
                        ets: '',
                        status: '',
                        total: ''
                    });
                },
                removeFiringRecord(index) {
                    this.firing_records.splice(index, 1);
                },

                addNightFiringRecord() {
                    this.night_firing_records.push({
                        date: '',
                        hit: '',
                        total: '',
                        status: ''
                    });
                },
                removeNightFiringRecord(index) {
                    this.night_firing_records.splice(index, 1);
                },

                addNightTraining() {
                    this.night_trainings.push({
                        date: '',
                        appointment: '',
                        remarks: ''
                    });
                },
                removeNightTraining(index) {
                    this.night_trainings.splice(index, 1);
                },

                addGroupTraining() {
                    this.group_trainings.push({
                        year: '',
                        circle: '1st',
                        appointment: '',
                        unit: '',
                        remarks: ''
                    });
                },
                removeGroupTraining(index) {
                    this.group_trainings.splice(index, 1);
                },

                addCycleEndingExercise() {
                    this.cycle_ending_exercises.push({
                        year: '',
                        circle: '1st',
                        appointment: '',
                        unit: '',
                        remarks: ''
                    });
                },
                removeCycleEndingExercise(index) {
                    this.cycle_ending_exercises.splice(index, 1);
                },

                addSummerTrg() {
                    this.field_trainings_summer.push({
                        year: '',
                        unit: '',
                        appointment: '',
                        remarks: ''
                    });
                },
                removeSummerTrg(index) {
                    this.field_trainings_summer.splice(index, 1);
                },
                addWinterTrg() {
                    this.field_trainings_winter.push({
                        year: '',
                        unit: '',
                        appointment: '',
                        remarks: ''
                    });
                },
                removeWinterTrg(index) {
                    this.field_trainings_winter.splice(index, 1);
                },

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
                    return this.selectedSectionId || this.selectedPlatoonId || this.selectedCompanyId || this
                        .selectedBattalionId;
                },

                get finalUnitName() {
                    if (!this.finalUnitId) return '';
                    const unit = this.allUnits.find(u => u.id == this.finalUnitId);
                    return unit ? `${unit.type.toUpperCase()}: ${unit.name}` : '';
                },

                get selectedCompanyName() {
                    const unit = this.allUnits.find(u => u.id == this.selectedCompanyId);
                    return unit ? unit.name : '';
                },

                get selectedPlatoonName() {
                    const unit = this.allUnits.find(u => u.id == this.selectedPlatoonId);
                    return unit ? unit.name : '';
                },

                get selectedSectionName() {
                    const unit = this.allUnits.find(u => u.id == this.selectedSectionId);
                    return unit ? unit.name : '';
                }
            }
        }
    </script>
@endsection
