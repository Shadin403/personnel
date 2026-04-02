@extends('layouts.admin')

@section('title', 'Soldier Profile - ' . $soldier->number)

@section('content')
<div class="max-w-6xl mx-auto space-y-12 animate-fade-in pb-20">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-8 border-b border-slate-300">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.soldiers.index') }}" class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-military-primary hover:border-military-primary transition-all group shadow-sm">
                <svg class="w-6 h-6 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight uppercase">Personnel Profile [প্রোফাইল]</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="px-3 py-0.5 bg-military-bg text-military-primary text-[9px] font-bold uppercase tracking-widest border border-military-primary/20">{{ $soldier->user_type }}</span>
                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">No. (Service Number): {{ $soldier->number }}</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.soldiers.download-trg', $soldier) }}" class="btn-military flex items-center gap-3 shadow-lg active:scale-95 group">
                <svg class="w-5 h-5 text-white/50 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                Generate Operational Report
            </a>
            <a href="{{ route('admin.soldiers.edit', $soldier) }}" class="px-6 py-3.5 bg-white border border-slate-300 text-military-secondary text-[10px] font-bold hover:bg-military-bg hover:border-military-primary transition-all flex items-center gap-3 shadow-sm uppercase tracking-widest">
                <svg class="w-5 h-5 text-military-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Modify Node Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        <!-- Profile Column -->
        <div class="lg:col-span-1 space-y-8">
            <div class="classic-card p-8 border border-slate-300 flex flex-col items-center bg-white">
                <div class="relative mb-8 group">
                    <div class="w-56 h-56 rounded-none border border-slate-200 p-1.5 bg-slate-50 overflow-hidden shadow-inner ring-4 ring-military-bg">
                        <img src="{{ $soldier->photo_url }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-none border-4 border-white shadow-xl {{ $soldier->is_active ? 'bg-military-success' : 'bg-military-danger' }} animate-pulse"></div>
                </div>
                
                <h3 class="text-2xl font-bold text-slate-900 text-center tracking-tighter uppercase">{{ $soldier->name }}</h3>
                <p class="text-military-primary font-bold uppercase tracking-[0.2em] text-[11px] mt-2 mb-8 bg-military-bg px-4 py-1">{{ $soldier->rank ?? 'RANK UNASSIGNED' }}</p>
                
                <div class="w-full grid grid-cols-2 gap-4 py-8 border-y border-slate-100">
                    <div class="text-center">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Coy. [কোম্পানী]</p>
                        <p class="text-[11px] font-bold text-slate-900 mt-2 tracking-widest uppercase">{{ $soldier->company ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Blood Group [রক্তের গ্রুপ]</p>
                        <p class="text-[11px] font-bold text-military-danger mt-2 tracking-widest">{{ $soldier->blood_group ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="w-full pt-8 space-y-4">
                     <div class="flex justify-between items-center px-5 py-4 bg-military-bg border border-slate-200">
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">READINESS</span>
                        <span class="text-[11px] font-bold text-military-primary uppercase">{{ $soldier->overall_status }}</span>
                     </div>
                     <div class="flex justify-between items-center px-5 py-4 bg-military-bg border border-slate-200">
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Home District [নিজ জেলা]</span>
                        <span class="text-[11px] font-bold text-slate-900 uppercase">{{ $soldier->home_district ?? 'N/A' }}</span>
                     </div>
                </div>
            </div>

            <!-- Deployment Sidebar -->
            <div class="classic-card p-6 border border-slate-300 bg-military-bg text-left">
                <h4 class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-military-secondary animate-pulse shadow-[0_0_8px_#1F2937]"></span>
                    OPERATIONAL GRID
                </h4>
                <div class="space-y-6 text-left">
                    <div class="text-left border-b border-slate-200 pb-4">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-3 text-left">Appt [অ্যাপয়েন্টমেন্ট]</p>
                        <p class="text-[11px] font-bold text-military-secondary text-left uppercase tracking-tighter">{{ $soldier->appointment ?? 'NO ACTIVE POST' }}</p>
                    </div>
                    <div class="text-left">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-3 text-left">Batch [ব্যাল]</p>
                        <p class="text-[11px] font-bold text-military-secondary text-left uppercase tracking-tighter">{{ $soldier->batch ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Data Content -->
        <div class="lg:col-span-3 space-y-10">
            <!-- Training & Combat Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                <!-- IPFT Stats -->
                <div class="classic-card border border-slate-300 overflow-hidden flex flex-col items-start text-left bg-white shadow-md">
                    <div class="px-8 py-5 bg-military-accent w-full flex items-center justify-between border-b-2 border-military-bg/20">
                        <h3 class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">IPFT (Individual Physical Fitness Test)</h3>
                        <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="p-8 space-y-8 w-full text-left">
                        @php
                            $ipft1_width = match($soldier->ipft_biannual_1) {
                                'Excellent' => '100%',
                                'Good' => '75%',
                                'Average' => '50%',
                                default => '10%'
                            };
                            $ipft2_width = match($soldier->ipft_biannual_2) {
                                'Excellent' => '100%',
                                'Good' => '75%',
                                'Average' => '50%',
                                default => '10%'
                            };
                        @endphp
                        <div class="space-y-4 text-left">
                            <div class="flex justify-between items-end">
                                <span class="text-[9px] font-bold text-military-secondary uppercase tracking-widest">Biannual Cycle 01 Metrics</span>
                                <span class="text-[11px] font-bold uppercase {{ $soldier->ipft_biannual_1 == 'Excellent' ? 'text-military-success' : ($soldier->ipft_biannual_1 == 'Failed' ? 'text-military-danger' : 'text-military-primary') }} underline decoration-2 underline-offset-4">{{ $soldier->ipft_biannual_1 ?? 'UNTESTED' }}</span>
                            </div>
                            <div class="h-3 w-full bg-military-bg border border-slate-200 overflow-hidden">
                                <div class="h-full bg-military-accent transition-all duration-1000 shadow-inner" style="width: {{ $ipft1_width }}"></div>
                            </div>
                        </div>
                        <div class="space-y-4 text-left">
                            <div class="flex justify-between items-end">
                                <span class="text-[9px] font-bold text-military-secondary uppercase tracking-widest">Biannual Cycle 02 Metrics</span>
                                <span class="text-[11px] font-bold uppercase {{ $soldier->ipft_biannual_2 == 'Excellent' ? 'text-military-success' : ($soldier->ipft_biannual_2 == 'Failed' ? 'text-military-danger' : 'text-military-primary') }} underline decoration-2 underline-offset-4">{{ $soldier->ipft_biannual_2 ?? 'UNTESTED' }}</span>
                            </div>
                            <div class="h-3 w-full bg-military-bg border border-slate-200 overflow-hidden">
                                <div class="h-full bg-military-secondary transition-all duration-1000 shadow-inner" style="width: {{ $ipft2_width }}"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Combat Training -->
                <div class="classic-card border border-slate-300 overflow-hidden text-left bg-white shadow-md">
                    <div class="px-8 py-5 bg-military-secondary w-full flex items-center justify-between">
                        <h3 class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">Operational Drills</h3>
                        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div class="p-8 grid grid-cols-2 gap-8 text-left bg-white/50">
                        <div class="text-left">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">spd March</p>
                            <div class="flex items-center gap-3">
                                <span class="text-xl font-bold text-military-secondary tracking-tighter uppercase">{{ $soldier->speed_march ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">Gren Fire</p>
                            <div class="flex items-center gap-3 font-mono">
                                <span class="text-xl font-bold text-military-secondary">{{ $soldier->grenade_fire ?? '0%' }}</span>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">Nil Fire</p>
                            <div class="flex items-center gap-3 font-mono">
                                <span class="text-xl font-bold text-military-primary">{{ $soldier->nil_fire ?? '0%' }}</span>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">COMMAND AUTH</p>
                            <span class="px-3 py-1 bg-military-bg text-military-primary text-[9px] font-bold border border-military-primary/20 uppercase tracking-widest">{{ $soldier->commander_status ?? 'STANDBY' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shooting Mastery Section -->
            <div class="classic-card border border-slate-300 overflow-hidden text-left bg-white shadow-xl">
                <div class="px-10 py-8 bg-military-danger flex flex-col md:flex-row md:items-center justify-between gap-6 border-b-4 border-military-secondary/20">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 rounded-none bg-white/10 border-2 border-white/20 flex items-center justify-center text-white shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white uppercase tracking-[0.4em]">Firing Result Section (Ret)</h3>
                            <p class="text-white text-[10px] font-bold uppercase tracking-widest mt-1 opacity-70 font-serif">Weaponry System Efficiency Profile - Level A Access</p>
                        </div>
                    </div>
                    <div class="text-right border-l-2 border-white/20 pl-8">
                        <span class="text-[9px] font-bold text-white uppercase tracking-[0.3em] block mb-1 opacity-60">MARKSMAN TIER</span>
                        <span class="text-3xl font-bold text-white uppercase tracking-tighter">{{ $soldier->shooting_grade }}</span>
                    </div>
                </div>
                <div class="p-10 grid grid-cols-2 md:grid-cols-4 gap-12 text-left bg-military-bg/30">
                    <div class="space-y-3 text-left">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] text-left">Shoot to hit [টার্গেটে hit score]</p>
                        <p class="text-4xl font-bold text-slate-900 font-mono tracking-tighter text-left shadow-military-primary/10 drop-shadow-sm">{{ $soldier->shoot_ret ?? '00' }} <span class="text-[10px] text-slate-300 font-bold ml-1 uppercase">PTS</span></p>
                    </div>
                    <div class="space-y-3 text-left border-l border-slate-200 pl-12">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] text-left">AP (Firing sub-score)</p>
                        <p class="text-4xl font-bold text-slate-900 font-mono tracking-tighter text-left">{{ $soldier->shoot_ap ?? '00' }} <span class="text-[10px] text-slate-300 font-bold ml-1 uppercase">RND</span></p>
                    </div>
                    <div class="space-y-3 text-left border-l border-slate-200 pl-12">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] text-left">ETS (Firing/test sub-score)</p>
                        <p class="text-4xl font-bold text-slate-900 font-mono tracking-tighter text-left">{{ $soldier->shoot_ets ?? '00' }} <span class="text-[10px] text-slate-300 font-bold ml-1 uppercase">ACC</span></p>
                    </div>
                    <div class="space-y-3 text-left border-l border-slate-200 pl-12 bg-white/80 p-6 rounded-none -m-6 border border-slate-300 shadow-inner">
                        <p class="text-[9px] font-bold text-military-danger uppercase tracking-[0.3em] text-left">Total [মোট score]</p>
                        <p class="text-5xl font-bold text-military-danger font-mono tracking-tighter text-left drop-shadow-sm">{{ $soldier->shoot_total ?? '000' }}</p>
                    </div>
                </div>
            </div>

            <!-- Planning & Personal Meta -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-left">
                <!-- Training Plan -->
                <div class="lg:col-span-2 classic-card border border-slate-300 p-8 text-left bg-white shadow-md">
                    <div class="flex items-center gap-4 mb-10 text-left border-b border-slate-100 pb-6">
                        <div class="w-12 h-12 rounded-none bg-military-bg border border-military-primary/20 flex items-center justify-center text-military-primary shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-[0.3em] text-left">Strategic Development Plan</h3>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Operational Trajectory Analysis FY-26</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                        <div class="text-left space-y-3">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block text-left underline decoration-slate-200 decoration-2 underline-offset-4">Course/Cdr Completed</span>
                            <div class="text-[11px] font-bold text-slate-700 bg-military-bg p-5 border-l-4 border-military-primary leading-relaxed text-left uppercase shadow-sm">{{ $soldier->course_status ?? 'NO CORE COMBAT SPECIALIZATIONS LISTED.' }}</div>
                        </div>
                        <div class="text-left space-y-3">
                            <span class="text-[9px] font-bold text-military-primary uppercase tracking-widest block text-left underline decoration-military-primary/20 decoration-2 underline-offset-4">Course/Cdr Plan This Yr</span>
                            <div class="text-[11px] font-bold text-military-secondary bg-white p-5 border border-slate-300 leading-relaxed text-left uppercase shadow-sm">"{{ $soldier->cdr_plan_this_yr ?? 'TRAJECTORY ANALYSIS PENDING COMMANDER INPUT.' }}"</div>
                        </div>
                    </div>
                </div>

                <!-- Personal Logistics -->
                <div class="classic-card border border-slate-300 p-8 text-left bg-military-bg shadow-md">
                    <h3 class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.3em] mb-10 flex items-center gap-3 text-left border-b border-slate-200 pb-4">
                        <svg class="w-5 h-5 text-military-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        PERSONAL LOGISTICS
                    </h3>
                    <div class="space-y-10 text-left">
                        <div class="text-left space-y-2">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block text-left">P.lve Plan</span>
                            <p class="text-[11px] font-bold text-military-secondary text-left uppercase tracking-tighter">{{ $soldier->leave_plan ?? 'ROTATION NOT SCHEDULED.' }}</p>
                        </div>
                        <div class="text-left space-y-2">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block text-left">Participation in Games & Sports [খেলাধুলায় অংশগ্রহণ]</span>
                            <p class="text-[10px] font-bold text-slate-500 leading-relaxed text-left uppercase">{{ $soldier->sports_participation ?? 'NO PARTICIPATION RECORDS.' }}</p>
                        </div>
                        <div class="pt-6 border-t border-slate-200 text-left">
                             <div class="flex items-center gap-3 text-left">
                                <div class="w-2.5 h-2.5 rounded-none bg-military-success animate-pulse shadow-[0_0_8px_#15803D]"></div>
                                <span class="text-[9px] font-bold text-military-primary uppercase tracking-[0.2em] text-left">NODE SECURE: VERIFIED PROFILE</span>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
