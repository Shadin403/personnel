@extends('layouts.admin')

@section('title', 'Personnel Enrollment')

@section('content')
<div class="max-w-5xl mx-auto space-y-10 animate-fade-in pb-20">
    <!-- Header -->
    <div class="flex items-center justify-between pb-6 border-b border-slate-300">
        <div class="flex items-center gap-5">
            <a href="{{ route('admin.soldiers.index') }}" class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-military-primary hover:border-military-primary transition-all group shadow-sm">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="space-y-1">
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Personnel Enrollment [নতুন সদস্য অন্তর্ভুক্তি]</h2>
            <p class="text-[12px] font-semibold text-slate-500 tracking-wide">Initialize strategic personnel node record</p>
        </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.soldiers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        
        <!-- Section 1: Basic Identity -->
        <div class="classic-card overflow-hidden border border-slate-300">
            <div class="px-8 py-4 classic-card-header flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <h3 class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">Personnel Core Identity (SEC-01)</h3>
                </div>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 bg-white">
                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Name [নাম] *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 bg-military-bg border @error('name') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all shadow-inner"
                           placeholder="EX: NAME OF PERSONNEL">
                    @error('name') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">No. (Service Number) *</label>
                    <input type="text" name="number" value="{{ old('number') }}" required
                           class="w-full px-4 py-3 bg-military-bg border @error('number') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all shadow-inner"
                           placeholder="SERVICE NUMBER">
                    @error('number') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Force Classification *</label>
                    <select name="user_type" required
                            class="w-full px-4 py-3 bg-military-bg border @error('user_type') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer">
                        <option value="CO" {{ old('user_type') == 'CO' ? 'selected' : '' }}>COMMISSIONED OFFICER (CO)</option>
                        <option value="Staff" {{ old('user_type') == 'Staff' ? 'selected' : '' }}>SUPPORT STAFF PERSONNEL</option>
                        <option value="JCO" {{ old('user_type') == 'JCO' ? 'selected' : '' }}>JUNIOR OFFICER (JCO)</option>
                    </select>
                    @error('user_type') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Designated Rank</label>
                    <input type="text" name="rank" value="{{ old('rank') }}"
                           class="w-full px-4 py-3 bg-military-bg border border-slate-200 rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all shadow-inner"
                           placeholder="RANK [পদবী]">
                    @error('rank') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Appt (Appointment)</label>
                    <input type="text" name="appointment" value="{{ old('appointment') }}"
                           class="w-full px-4 py-3 bg-military-bg border border-slate-200 rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all shadow-inner"
                           placeholder="DEPLOYED DUTY POST">
                    @error('appointment') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Batch [ব্যাচ]</label>
                    <input type="text" name="batch" value="{{ old('batch') }}"
                           class="w-full px-4 py-3 bg-military-bg border border-slate-200 rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all shadow-inner"
                           placeholder="YEAR / INTAKE ID">
                    @error('batch') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Section 2: Deployment & Bio -->
        <div class="classic-card overflow-hidden border border-slate-300">
            <div class="px-8 py-4 classic-card-header flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <h3 class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">Bio-Metric & Deployment Data (SEC-02)</h3>
                </div>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8 bg-white">
                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Coy. (Company)</label>
                    <select name="company" class="w-full px-4 py-3 bg-military-bg border @error('company') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer">
                        <option value="">NOT ASSIGNED</option>
                        @foreach(['Alpha', 'Bravo', 'Charlie', 'Delta', 'Echo', 'HQ'] as $coy)
                            <option value="{{ $coy }}" {{ old('company') == $coy ? 'selected' : '' }}>{{ strtoupper($coy) }} UNIT</option>
                        @endforeach
                    </select>
                    @error('company') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Blood Group [রক্তের গ্রুপ]</label>
                    <select name="blood_group" class="w-full px-4 py-3 bg-military-bg border @error('blood_group') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer">
                        <option value="">UNSPECIFIED</option>
                        @foreach(['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'] as $bg)
                            <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }} GROUP</option>
                        @endforeach
                    </select>
                    @error('blood_group') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Home District [নিজ জেলা]</label>
                    <input type="text" name="home_district" value="{{ old('home_district') }}"
                           class="w-full px-4 py-3 bg-military-bg border border-slate-200 rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all shadow-inner"
                           placeholder="ORIGIN TOWNSHIP">
                    @error('home_district') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-3">
                    <label class="text-[12px] font-bold text-military-secondary mb-2 block tracking-wide opacity-80">Personnel Visual Identification (HD PHOTO)</label>
                    <div x-data="{ photoName: null, photoPreview: null }" class="flex items-center gap-8">
                        <input type="file" name="photo" class="hidden" x-ref="photo"
                               @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                               ">
                        <div class="w-24 h-24 rounded-none bg-military-bg border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden shrink-0 group relative cursor-pointer hover:border-military-primary hover:bg-white transition-all shadow-inner" @click="$refs.photo.click()">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-slate-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    <span class="text-[8px] font-bold text-slate-400 uppercase tracking-tighter">UPLOAD</span>
                                </div>
                            </template>
                        </div>
                        <div class="space-y-1">
                            <button type="button" @click="$refs.photo.click()" class="text-[10px] font-bold text-military-primary uppercase tracking-[0.2em] border-b border-military-primary pb-0.5 hover:text-military-secondary hover:border-military-secondary transition-all">Select Image Assets</button>
                            <p class="text-[9px] text-slate-400 font-semibold uppercase tracking-widest mt-2">Payload Max: 2.0MB &bull; MIME: JPG, PNG, WEBP</p>
                        </div>
                    </div>
                    @error('photo') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Section 3: Training Metrics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- IPFT Card -->
            <div class="classic-card overflow-hidden border border-slate-300">
                <div class="px-8 py-4 bg-military-accent flex items-center justify-between border-b-2 border-military-secondary/20">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <h3 class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">IPFT (Individual Physical Fitness Test)</h3>
                    </div>
                </div>
                <div class="p-8 space-y-6 bg-white">
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">Biannual Matrix 01</label>
                        <select name="ipft_biannual_1" class="w-full px-4 py-3 bg-military-bg border @error('ipft_biannual_1') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-accent focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">NOT EXAMINED</option>
                            @foreach(['Excellent', 'Good', 'Average', 'Failed'] as $r)
                                <option value="{{ $r }}" {{ old('ipft_biannual_1') == $r ? 'selected' : '' }}>{{ strtoupper($r) }}</option>
                            @endforeach
                        </select>
                        @error('ipft_biannual_1') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">Biannual Matrix 02</label>
                        <select name="ipft_biannual_2" class="w-full px-4 py-3 bg-military-bg border @error('ipft_biannual_2') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-accent focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">NOT EXAMINED</option>
                            @foreach(['Excellent', 'Good', 'Average', 'Failed'] as $r)
                                <option value="{{ $r }}" {{ old('ipft_biannual_2') == $r ? 'selected' : '' }}>{{ strtoupper($r) }}</option>
                            @endforeach
                        </select>
                        @error('ipft_biannual_2') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Shooting Card -->
            <div class="classic-card overflow-hidden border border-slate-300">
                <div class="px-8 py-4 bg-military-secondary flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <h3 class="text-[10px] font-bold text-white uppercase tracking-widest">Training & Combat Metrics</h3>
                    </div>
                </div>
                <div class="p-8 grid grid-cols-2 gap-4 bg-white">
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">Shoot to hit [টার্গেটে hit score]</label>
                        <input type="text" name="shoot_ret" value="{{ old('shoot_ret') }}" class="w-full px-4 py-3 bg-military-bg border @error('shoot_ret') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-secondary transition-all font-mono shadow-inner">
                        @error('shoot_ret') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">AP (Firing sub-score) [ফায়ারিং সাব-স্কোর]</label>
                        <input type="text" name="shoot_ap" value="{{ old('shoot_ap') }}" class="w-full px-4 py-3 bg-military-bg border @error('shoot_ap') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-secondary transition-all font-mono shadow-inner">
                        @error('shoot_ap') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">ETS (Firing/test sub-score)</label>
                        <input type="text" name="shoot_ets" value="{{ old('shoot_ets') }}" class="w-full px-4 py-3 bg-military-bg border @error('shoot_ets') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-secondary transition-all font-mono shadow-inner">
                        @error('shoot_ets') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">Total [মোট score]</label>
                        <input type="text" name="shoot_total" value="{{ old('shoot_total') }}" class="w-full px-4 py-3 bg-slate-100 text-military-secondary border @error('shoot_total') border-military-danger @else border-slate-300 @enderror rounded-none text-base font-bold focus:outline-none focus:ring-1 focus:ring-military-secondary transition-all font-mono shadow-lg text-center">
                        @error('shoot_total') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Performance & Leave -->
        <div class="classic-card overflow-hidden border border-slate-300">
            <div class="px-8 py-4 classic-card-header flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">Strategic Objectives & Deployment (SEC-04)</h3>
                </div>
            </div>
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 bg-white">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">spd March</label>
                        <select name="speed_march" class="w-full px-4 py-3 bg-military-bg border @error('speed_march') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer shadow-inner">
                            <option value="">SELECT STATUS</option>
                            <option value="Pass" {{ old('speed_march') == 'Pass' ? 'selected' : '' }}>PASS</option>
                            <option value="Fail" {{ old('speed_march') == 'Fail' ? 'selected' : '' }}>FAIL</option>
                            <option value="N/A" {{ old('speed_march') == 'N/A' ? 'selected' : '' }}>NOT APPLICABLE</option>
                        </select>
                        @error('speed_march') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">Gren Fire</label>
                        <select name="grenade_fire" class="w-full px-4 py-3 bg-military-bg border @error('grenade_fire') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer shadow-inner">
                            <option value="">SELECT STATUS</option>
                            <option value="Pass" {{ old('grenade_fire') == 'Pass' ? 'selected' : '' }}>PASS</option>
                            <option value="Fail" {{ old('grenade_fire') == 'Fail' ? 'selected' : '' }}>FAIL</option>
                            <option value="N/A" {{ old('grenade_fire') == 'N/A' ? 'selected' : '' }}>NOT APPLICABLE</option>
                        </select>
                        @error('grenade_fire') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5 col-span-2">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">Commander Auth Status</label>
                        <select name="commander_status" class="w-full px-4 py-3 bg-military-bg border @error('commander_status') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer shadow-inner">
                            <option value="Standby" {{ old('commander_status') == 'Standby' ? 'selected' : '' }}>STANDBY (INITIAL)</option>
                            <option value="Active" {{ old('commander_status', 'Active') == 'Active' ? 'selected' : '' }}>ACTIVE (AUTHORIZED)</option>
                            <option value="Revoked" {{ old('commander_status') == 'Revoked' ? 'selected' : '' }}>REVOKED (LOCKED)</option>
                        </select>
                        @error('commander_status') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-700 ml-1">Course/Cdr Completed</label>
                        <input type="text" name="course_status" value="{{ old('course_status') }}" class="w-full px-4 py-3 bg-military-bg border @error('course_status') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary shadow-inner" placeholder="KEY CERTIFICATIONS">
                        @error('course_status') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-military-primary ml-1">Course/Cdr Plan This Yr</label>
                        <input type="text" name="cdr_plan_this_yr" value="{{ old('cdr_plan_this_yr') }}" class="w-full px-4 py-3 bg-military-secondary text-white border @error('cdr_plan_this_yr') border-military-danger @else border-military-secondary @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-military-accent shadow-xl placeholder-white/40" placeholder="PLANNED OBJECTIVES">
                        @error('cdr_plan_this_yr') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">P.lve Plan</label>
                    <input type="text" name="leave_plan" value="{{ old('leave_plan') }}" class="w-full px-4 py-3 bg-military-bg border @error('leave_plan') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary shadow-inner" placeholder="PLANNED ROTATIONS">
                    @error('leave_plan') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Nil Fire</label>
                    <input type="text" name="nil_fire" value="{{ old('nil_fire') }}" class="w-full px-4 py-3 bg-military-bg border @error('nil_fire') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary shadow-inner" placeholder="PRECISION METRIC">
                    @error('nil_fire') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-700 ml-1">Participation in Games & Sports [খেলাধুলায় অংশগ্রহণ]</label>
                    <textarea name="sports_participation" rows="3" class="w-full px-4 py-3 bg-military-bg border @error('sports_participation') border-military-danger @else border-slate-200 @enderror rounded-none text-[11px] font-semibold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all resize-none shadow-inner" placeholder="DETAILS OF COMPETITIVE ENGAGEMENTS...">{{ old('sports_participation') }}</textarea>
                    @error('sports_participation') <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="px-8 py-4 bg-military-bg border-t border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                        <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:bg-military-success peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all shadow-inner"></div>
                        <span class="ml-3 text-[11px] font-bold text-slate-700">Active System Connection Status</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Section 5: Authentication & Save -->
        <div class="flex items-center justify-between py-10 border-t border-slate-300">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-military-primary shadow-[0_0_8px_#2F4F3E] animate-pulse"></div>
                <p class="text-[11px] font-bold text-slate-500">Authenticated by Command-Net Systems</p>
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.soldiers.index') }}" class="px-8 py-3 bg-white border border-slate-300 text-slate-600 text-[11px] font-bold hover:text-military-danger hover:border-military-danger transition-all shadow-sm">
                    Abort Protocol
                </a>
                <button type="submit" class="btn-military px-12 py-3 text-[11px] shadow-xl active:scale-95">
                    Commit to Core Database
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .animate-shake {
        animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
    }
</style>
@endsection
