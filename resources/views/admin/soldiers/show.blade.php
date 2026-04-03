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
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Personnel Profile [প্রোফাইল]</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="px-3 py-0.5 bg-military-bg text-military-primary text-[10px] font-bold border border-military-primary/20">{{ $soldier->user_type }}</span>
                    <span class="text-slate-500 text-[12px] font-semibold">Service Number: {{ $soldier->number }}</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.soldiers.download-record-book', $soldier) }}" class="px-6 py-3.5 bg-slate-900 border border-slate-700 text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-military-secondary transition-all flex items-center gap-3 shadow-lg group">
                <svg class="w-5 h-5 text-military-accent group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Download Record Book [PDF]
            </a>
            <a href="{{ route('admin.soldiers.download-trg', $soldier) }}" class="btn-military flex items-center gap-3 shadow-lg active:scale-95 group">
                <svg class="w-5 h-5 text-white/50 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                Operational TRG
            </a>
            <a href="{{ route('admin.soldiers.edit', $soldier) }}" class="px-6 py-3.5 bg-white border border-slate-300 text-military-secondary text-[12px] font-bold hover:bg-military-bg hover:border-military-primary transition-all flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-military-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Modify Records
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        <!-- Profile Column ... (Existing code matches) -->
        <!-- ... keeping most of the header/sidebar code ... -->
        <!-- Just skipping to the sections where I add new content -->
        
        <!-- I will do a more targeted insert below -->
        <!-- Profile Column -->
        <div class="lg:col-span-1 space-y-8">
            <div class="classic-card p-8 border border-slate-300 flex flex-col items-center bg-white">
                <div class="relative mb-8 group">
                    <div class="w-56 h-56 rounded-none border border-slate-200 p-1.5 bg-slate-50 overflow-hidden shadow-inner ring-4 ring-military-bg">
                        <img src="{{ $soldier->photo_url }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-none border-4 border-white shadow-xl {{ $soldier->is_active ? 'bg-military-success' : 'bg-military-danger' }} animate-pulse"></div>
                </div>
                
                <h3 class="text-2xl font-bold text-slate-900 text-center tracking-tight">{{ $soldier->name }}</h3>
                <p class="text-military-primary font-bold tracking-wide text-[13px] mt-2 mb-8 bg-military-bg px-5 py-1.5 border border-military-primary/10">{{ $soldier->rank ?? 'Rank Unassigned' }}</p>
                
                <div class="w-full grid grid-cols-2 gap-4 py-8 border-y border-slate-100">
                    <div class="text-center">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest leading-none">Coy. [কোম্পানী]</p>
                        <p class="text-[13px] font-bold text-slate-900 mt-2">{{ $soldier->company ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest leading-none">Blood Group [রক্তের গ্রুপ]</p>
                        <p class="text-[13px] font-bold text-military-danger mt-2">{{ $soldier->blood_group ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="w-full pt-8 space-y-4">
                     <div class="flex justify-between items-center px-5 py-4 bg-military-bg border border-slate-200">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Readiness Status</span>
                        <span class="text-[13px] font-bold text-military-primary">{{ $soldier->overall_status }}</span>
                     </div>
                     <div class="flex justify-between items-center px-5 py-4 bg-military-bg border border-slate-200">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Home District [নিজ জেলা]</span>
                        <span class="text-[13px] font-bold text-slate-900">{{ $soldier->home_district ?? 'N/A' }}</span>
                     </div>
                </div>
            </div>

            <!-- Deployment Sidebar -->
            <div class="classic-card p-6 border border-slate-300 bg-military-bg text-left">
                <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2 opacity-50">
                    <span class="w-1.5 h-1.5 rounded-full bg-military-secondary animate-pulse shadow-[0_0_8px_#1F2937]"></span>
                    Operational Grid
                </h4>
                <div class="space-y-6 text-left">
                    <div class="text-left border-b border-slate-200 pb-4">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-3 text-left">Appt [অ্যাপয়েন্টমেন্ট]</p>
                        <p class="text-[13px] font-bold text-military-secondary text-left">{{ $soldier->appointment ?? 'No active post' }}</p>
                    </div>
                    <div class="text-left">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-3 text-left">Batch [ব্যাচ]</p>
                        <p class="text-[13px] font-bold text-military-secondary text-left">{{ $soldier->batch ?? 'N/A' }}</p>
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
                        <h3 class="text-[11px] font-bold text-white uppercase tracking-widest">IPFT (Physical Fitness Test)</h3>
                        <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="p-8 space-y-8 w-full text-left">
                        @php
                            $ipft1_width = match($soldier->ipft_biannual_1) {
                                'Pass' => '100%',
                                'Fail' => '15%',
                                'Not appeared' => '5%',
                                'Yet to appear' => '5%',
                                default => '0%'
                            };
                            $ipft2_width = match($soldier->ipft_biannual_2) {
                                'Pass' => '100%',
                                'Fail' => '15%',
                                'Not appeared' => '5%',
                                'Yet to appear' => '5%',
                                default => '0%'
                            };
                        @endphp
                        <div class="space-y-4 text-left">
                            <div class="flex justify-between items-end">
                                <span class="text-[11px] font-bold text-military-secondary uppercase tracking-widest">Cycle 01 Metrics</span>
                                <span class="text-[13px] font-bold {{ $soldier->ipft_biannual_1 == 'Pass' ? 'text-military-success' : ($soldier->ipft_biannual_1 == 'Fail' ? 'text-military-danger' : 'text-military-primary') }} underline decoration-2 underline-offset-4">{{ $soldier->ipft_biannual_1 ?? 'Untested' }}</span>
                            </div>
                            <div class="h-3 w-full bg-military-bg border border-slate-200 overflow-hidden">
                                <div class="h-full bg-military-accent transition-all duration-1000 shadow-inner" style="width: {{ $ipft1_width }}"></div>
                            </div>
                        </div>
                        <div class="space-y-4 text-left">
                            <div class="flex justify-between items-end">
                                <span class="text-[11px] font-bold text-military-secondary uppercase tracking-widest">Cycle 02 Metrics</span>
                                <span class="text-[13px] font-bold {{ $soldier->ipft_biannual_2 == 'Pass' ? 'text-military-success' : ($soldier->ipft_biannual_2 == 'Fail' ? 'text-military-danger' : 'text-military-primary') }} underline decoration-2 underline-offset-4">{{ $soldier->ipft_biannual_2 ?? 'Untested' }}</span>
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
                        <h3 class="text-[11px] font-bold text-white uppercase tracking-widest">Operational Drills</h3>
                        <svg class="w-5 h-5 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div class="p-8 grid grid-cols-2 gap-8 text-left bg-white/50">
                        <div class="text-left">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">Speed march</p>
                            <div class="flex items-center gap-3">
                                <span class="text-xl font-bold text-military-secondary tracking-tighter">{{ $soldier->speed_march ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">Grenade firing</p>
                            <div class="flex items-center gap-3 font-mono">
                                <span class="text-xl font-bold text-military-secondary">{{ $soldier->grenade_fire ?? '0%' }}</span>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">Ni firing</p>
                            <div class="flex items-center gap-3 font-mono">
                                <span class="text-xl font-bold text-military-primary">{{ $soldier->nil_fire ?? '0%' }}</span>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-left">Command Auth</p>
                            <span class="px-3 py-1 bg-military-bg text-military-primary text-[10px] font-bold border border-military-primary/20 tracking-wide">{{ $soldier->commander_status ?? 'Standby' }}</span>
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
                            <h3 class="text-[13px] font-bold text-white uppercase tracking-widest">Ni firing (STH) Result Section</h3>
                            <p class="text-white text-[11px] font-bold mt-1 opacity-70">Weaponry System Efficiency Profile & Analytics</p>
                        </div>
                    </div>
                    <div class="text-right border-l-2 border-white/20 pl-8">
                        <span class="text-[11px] font-bold text-white uppercase tracking-widest block mb-1 opacity-60">Marksman Tier</span>
                        <span class="text-3xl font-bold text-white uppercase tracking-tighter">{{ $soldier->shooting_grade }}</span>
                    </div>
                </div>
                <div class="p-10 grid grid-cols-2 md:grid-cols-4 gap-12 text-left bg-military-bg/30">
                    <div class="space-y-3 text-left">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest text-left">Ni firing (STH) [টার্গেটে hit score]</p>
                        <p class="text-4xl font-bold text-slate-900 font-mono tracking-tighter text-left">{{ $soldier->shoot_ret ?? '00' }} <span class="text-[11px] text-slate-300 font-bold ml-1 uppercase">Pts</span></p>
                    </div>
                    <div class="space-y-3 text-left border-l border-slate-200 pl-12">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest text-left">AP (Firing sub-score)</p>
                        <p class="text-4xl font-bold text-slate-900 font-mono tracking-tighter text-left">{{ $soldier->shoot_ap ?? '00' }} <span class="text-[11px] text-slate-300 font-bold ml-1 uppercase">Rnd</span></p>
                    </div>
                    <div class="space-y-3 text-left border-l border-slate-200 pl-12">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest text-left">ETS (Firing sub-score)</p>
                        <p class="text-4xl font-bold text-slate-900 font-mono tracking-tighter text-left">{{ $soldier->shoot_ets ?? '00' }} <span class="text-[11px] text-slate-300 font-bold ml-1 uppercase">Acc</span></p>
                    </div>
                    <div class="space-y-3 text-left border-l border-slate-200 pl-12 bg-white/80 p-6 rounded-none -m-6 border border-slate-300 shadow-inner">
                        <p class="text-[11px] font-bold text-military-danger uppercase tracking-widest text-left">Total [মোট score]</p>
                        <p class="text-5xl font-bold text-military-danger font-mono tracking-tighter text-left">{{ $soldier->shoot_total ?? '000' }}</p>
                    </div>
                </div>
            </div>

            <!-- Extended Personnel Profile -->
            <div class="classic-card border border-slate-300 overflow-hidden text-left bg-white shadow-xl">
                <div class="px-10 py-6 bg-military-primary flex items-center justify-between border-b-4 border-military-bg/20">
                    <h3 class="text-[11px] font-black text-white uppercase tracking-[0.4em]">Extended Personal Profile [ব্যক্তিগত তথ্যাবলী]</h3>
                    <span class="px-3 py-1 bg-white/20 text-white text-[9px] font-bold uppercase tracking-widest">Restricted [সীমিত]</span>
                </div>
                <div class="p-10 grid grid-cols-1 md:grid-cols-3 gap-10 text-left bg-military-bg/10">
                    <div class="space-y-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block text-left">Enrolment Date [ভর্তির তাং]</span>
                        <p class="text-[14px] font-bold text-slate-900 text-left">{{ $soldier->enrolment_date ? \Carbon\Carbon::parse($soldier->enrolment_date)->format('d M Y') : 'N/A' }}</p>
                    </div>
                    <div class="space-y-2 border-l border-slate-200 pl-10">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block text-left">Rank Date [পদের তাং]</span>
                        <p class="text-[14px] font-bold text-slate-900 text-left">{{ $soldier->rank_date ? \Carbon\Carbon::parse($soldier->rank_date)->format('d M Y') : 'N/A' }}</p>
                    </div>
                    <div class="space-y-2 border-l border-slate-200 pl-10">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block text-left">Civil Education [বেসামরিক শিক্ষা]</span>
                        <p class="text-[14px] font-bold text-slate-900 text-left uppercase">{{ $soldier->civil_education ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block text-left">Weight [ওজন]</span>
                        <p class="text-[14px] font-bold text-slate-900 text-left uppercase">{{ $soldier->weight ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-2 border-l border-slate-200 pl-10 md:col-span-2">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block text-left">Permanent Address [স্থায়ী ঠিকানা]</span>
                        <p class="text-[14px] font-bold text-slate-900 text-left uppercase leading-relaxed">{{ $soldier->permanent_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Course History -->
            <div class="classic-card border border-slate-300 overflow-hidden text-left bg-white shadow-lg">
                <div class="px-10 py-6 bg-slate-700 flex items-center justify-between border-b-2 border-slate-800/20">
                    <h3 class="text-[11px] font-black text-white uppercase tracking-[0.4em]">Course & Cadre Analytics [প্রশিক্ষণ ও কোর্স হিস্ট্রি]</h3>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                            <tr class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                <th class="px-10 py-5">Course/Cadre</th>
                                <th class="px-6 py-5">Chance</th>
                                <th class="px-6 py-5 text-center">Year</th>
                                <th class="px-10 py-5 text-right">Result/Authority</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($soldier->courses as $course)
                                <tr class="hover:bg-military-bg/30 transition-colors">
                                    <td class="px-10 py-5 text-[13px] font-black text-slate-900 uppercase tracking-tight">{{ $course->name }}</td>
                                    <td class="px-6 py-5 text-[12px] font-bold text-slate-500 uppercase">{{ $course->chance }}</td>
                                    <td class="px-6 py-5 text-[12px] font-black text-military-primary text-center">{{ $course->year }}</td>
                                    <td class="px-10 py-5 text-[12px] font-bold text-slate-700 text-right uppercase">{{ $course->result }} / {{ $course->authority }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-10 py-10 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">No verified course records found in strategic vault.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Professional & Unit Training Grids -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-left">
                <!-- Annual Professional Plan -->
                <div class="classic-card border border-slate-300 overflow-hidden text-left bg-white shadow-md">
                    <div class="px-8 py-4 bg-military-bg flex items-center justify-between border-b border-slate-100">
                        <h3 class="text-[10px] font-black text-slate-600 uppercase tracking-[0.4em]">Yearly Professional Plan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white">
                                <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                    <th class="px-8 py-4">Year</th>
                                    <th class="px-4 py-4 text-center">Leave</th>
                                    <th class="px-4 py-4 text-center">Unit Trg</th>
                                    <th class="px-8 py-4 text-right">Mootw</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($soldier->trainingPlans as $plan)
                                    <tr>
                                        <td class="px-8 py-4 text-[12px] font-black text-slate-900">{{ $plan->year }}</td>
                                        <td class="px-4 py-4 text-[11px] font-bold text-slate-500 text-center">{{ $plan->annual_leave }}</td>
                                        <td class="px-4 py-4 text-[11px] font-bold text-military-primary text-center">{{ $plan->unit_training }}</td>
                                        <td class="px-8 py-4 text-[11px] font-bold text-slate-700 text-right uppercase">{{ $plan->mootw }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Unit Training Detailed -->
                <div class="classic-card border border-slate-300 overflow-hidden text-left bg-white shadow-md">
                    <div class="px-8 py-4 bg-military-bg flex items-center justify-between border-b border-slate-100">
                        <h3 class="text-[10px] font-black text-slate-600 uppercase tracking-[0.4em]">Unit Cycle Detail</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white">
                                <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                    <th class="px-8 py-4">Cycle</th>
                                    <th class="px-4 py-4">Appt</th>
                                    <th class="px-8 py-4 text-right">Standard</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($soldier->unitTrainings as $ut)
                                    <tr>
                                        <td class="px-8 py-4 text-[12px] font-black text-military-secondary uppercase">{{ $ut->cycle }} ({{ $ut->year }})</td>
                                        <td class="px-4 py-4 text-[11px] font-bold text-slate-500 uppercase">{{ $ut->appointment }}</td>
                                        <td class="px-8 py-4 text-[11px] font-bold text-slate-800 text-right uppercase">{{ $ut->standard_remarks }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <h3 class="text-[13px] font-bold text-slate-900 uppercase tracking-widest text-left">Strategic Development Plan</h3>
                            <p class="text-[11px] font-bold text-slate-400 mt-1">Operational Trajectory Analysis FY-26</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                        <div class="text-left space-y-3">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block text-left underline decoration-slate-200 decoration-2 underline-offset-4">Course/Cdr Completed</span>
                            <div class="text-[13px] font-bold text-slate-700 bg-military-bg p-5 border-l-4 border-military-primary leading-relaxed text-left shadow-sm">{{ $soldier->course_status ?? 'No records listed.' }}</div>
                        </div>
                        <div class="text-left space-y-3">
                            <span class="text-[11px] font-bold text-military-primary uppercase tracking-widest block text-left underline decoration-military-primary/20 decoration-2 underline-offset-4">Course/Cdr Plan This Yr</span>
                            <div class="text-[13px] font-bold text-military-secondary bg-white p-5 border border-slate-300 leading-relaxed text-left shadow-sm">"{{ $soldier->cdr_plan_this_yr ?? 'Trajectory analysis pending commander input.' }}"</div>
                        </div>
                    </div>
                </div>

                <!-- Personal Logistics -->
                <div class="classic-card border border-slate-300 p-8 text-left bg-military-bg shadow-md">
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-10 flex items-center gap-3 text-left border-b border-slate-200 pb-4">
                        <svg class="w-5 h-5 text-military-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Personal Logistics
                    </h3>
                    <div class="space-y-10 text-left">
                        <div class="text-left space-y-2">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block text-left">P.lve Plan</span>
                            <p class="text-[13px] font-bold text-military-secondary text-left">{{ $soldier->leave_plan ?? 'Rotation not scheduled.' }}</p>
                        </div>
                        <div class="text-left space-y-2">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block text-left">Participation in Games & Sports [খেলাধুলায় অংশগ্রহণ]</span>
                            <p class="text-[12px] font-bold text-slate-500 leading-relaxed text-left uppercase">{{ $soldier->sports_participation ?? 'No participation records.' }}</p>
                        </div>
                        <div class="pt-6 border-t border-slate-200 text-left">
                             <div class="flex items-center gap-3 text-left">
                                <div class="w-2 h-2 rounded-full bg-military-success animate-pulse shadow-[0_0_8px_#15803D]"></div>
                                <span class="text-[11px] font-bold text-military-primary uppercase tracking-widest text-left">Profile Verified</span>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
