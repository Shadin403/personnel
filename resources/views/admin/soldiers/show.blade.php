@extends('layouts.admin')

@section('title', 'Strategic Node Profile - ' . $soldier->number)

@section('styles')
    <style>
        .tactical-border {
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .tactical-border::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #2F4F3E;
        }

        .section-tag {
            background: #2F4F3E;
            color: white;
            font-size: 10px;
            font-weight: 900;
            padding: 2px 8px;
            letter-spacing: 0.1em;
        }

        .data-label {
            font-size: 10px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
            display: block;
        }

        .data-value {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .bengali-value {
            font-family: 'Hind Siliguri', sans-serif;
            font-size: 13px;
            color: #334155;
        }

        .tactical-header {
            background: linear-gradient(90deg, #0f172a, #1e3a2f);
            border-left: 6px solid #84cc16;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in pb-24 px-4">
        <!-- Header & Quick Actions -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-slate-200">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.soldiers.index') }}"
                    class="p-3 bg-white border border-slate-200 text-slate-400 hover:text-military-primary hover:border-military-primary transition-all shadow-sm group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Strategic <span
                            class="text-military-primary">Personnel Node</span></h2>
                    <div class="flex items-center gap-3 mt-1">
                        <span
                            class="px-2 py-0.5 bg-military-bg text-military-primary text-[9px] font-black border border-military-primary/20 tracking-tighter uppercase">{{ $soldier->user_type }}</span>
                        <span class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Protocol ID:
                            {{ $soldier->number }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.soldiers.download-record-book', $soldier) }}"
                    class="px-6 py-3 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest hover:bg-military-secondary transition-all flex items-center gap-3 shadow-lg group">
                    <svg class="w-4 h-4 text-military-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Record Book [PDF]
                </a>
                <a href="{{ route('admin.soldiers.edit', $soldier) }}"
                    class="px-6 py-3 bg-military-accent text-slate-900 text-[10px] font-black uppercase tracking-widest hover:bg-white border border-transparent hover:border-slate-200 transition-all flex items-center gap-3 shadow-lg group">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Modify Node
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8">
            <!-- Left Column: Identity & Bio (4 cols) -->
            <div class="col-span-12 lg:col-span-4 space-y-8">
                <!-- Section 01: Core Identity -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 tactical-header flex items-center justify-between text-white">
                        <div class="flex items-center gap-3">
                            <span class="section-tag">SEC-01</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Identity Matrix</h3>
                        </div>
                        <div class="w-2 h-2 rounded-full {{ $soldier->is_active ? 'bg-military-success' : 'bg-military-danger' }} animate-pulse shadow-[0_0_8px_currentColor]"></div>
                    </div>

                    <div class="p-8 flex flex-col items-center text-center">
                        <div class="relative mb-8">
                            <div
                                class="w-48 h-56 border-2 border-slate-200 p-1.5 bg-slate-50 relative z-10 overflow-hidden shadow-inner ring-8 ring-military-bg">
                                <img src="{{ $soldier->photo_url }}"
                                    class="w-full h-full object-cover transition-all duration-700">
                            </div>
                            <div class="absolute -top-4 -right-4 w-12 h-12 bg-military-accent border-4 border-white flex items-center justify-center shadow-lg z-20">
                                <span class="text-[14px] font-black text-military-primary">{{ $soldier->blood_group }}</span>
                            </div>
                        </div>

                        <div class="space-y-1 mb-6">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $soldier->name }}</h3>
                            <p class="font-bengali text-lg font-bold text-slate-500">{{ $soldier->name_bn }}</p>
                        </div>

                        <div class="w-full grid grid-cols-2 gap-4 pt-6 border-t border-slate-100">
                            <div class="text-left bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label">Personal No</span>
                                <span class="text-[14px] font-black text-military-primary">{{ $soldier->personal_no }}</span>
                            </div>
                            <div class="text-left bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label">Rank</span>
                                <span class="text-[14px] font-black text-slate-800">{{ $soldier->rank }}</span>
                                <p class="font-bengali text-[11px] font-bold text-slate-400 mt-0.5 italic">{{ $soldier->rank_bn }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 02: Tactical Chain of Command -->
                <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                    <div class="px-6 py-3 bg-military-bg border-b border-slate-200 flex items-center gap-3">
                        <span class="section-tag">SEC-02</span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-600">Chain of Command</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @php
                            $hierarchy = [
                                ['label' => 'Unit/Regt', 'value' => $soldier->battalion_name],
                                ['label' => 'Coy Group', 'value' => $soldier->company ?? 'N/A'],
                                ['label' => 'Platoon', 'value' => $soldier->platoon ?? 'N/A'],
                                ['label' => 'Section', 'value' => $soldier->section ?? 'N/A'],
                            ];
                        @endphp
                        @foreach($hierarchy as $index => $item)
                            <div class="flex items-start gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-6 h-6 rounded-none bg-slate-100 border border-slate-300 flex items-center justify-center text-[10px] font-black text-slate-400">
                                        {{ $index + 1 }}
                                    </div>
                                    @if(!$loop->last)
                                        <div class="w-0.5 h-6 bg-slate-200"></div>
                                    @endif
                                </div>
                                <div class="flex-1 pb-2">
                                    <span class="data-label !mb-0">{{ $item['label'] }}</span>
                                    <span class="text-[13px] font-black text-slate-700 tracking-tight">{{ $item['value'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Section 08: Tactical Finance (Bank) -->
                <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                    <div class="px-6 py-3 bg-military-bg border-b border-slate-200 flex items-center gap-3">
                        <span class="section-tag">SEC-08</span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-600">Financial Nodes</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-6">
                        <div class="bg-slate-50 p-4 border border-l-4 border-l-military-primary border-slate-200">
                            <span class="data-label">Bank Name</span>
                            <span class="data-value uppercase text-military-primary">{{ $soldier->bank_name ?? 'N/A' }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label">Branch</span>
                                <span class="data-value uppercase">{{ $soldier->branch_name ?? 'N/A' }}</span>
                            </div>
                            <div class="bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label">A/C Number</span>
                                <span class="data-value font-mono text-military-secondary">{{ $soldier->ac_no ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Professional & Personal (8 cols) -->
            <div class="col-span-12 lg:col-span-8 space-y-8">
                
                <!-- Top Row: SEC-03 & SEC-11 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Section 03: Military Career -->
                    <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-slate-900 flex items-center gap-3">
                            <span class="section-tag !bg-military-accent !text-slate-900">SEC-03</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Military Particulars</h3>
                        </div>
                        <div class="p-8 grid grid-cols-2 gap-8">
                            <div class="space-y-1">
                                <span class="data-label">Enrolment Date</span>
                                <span class="data-value">{{ $soldier->enrolment_date ? $soldier->enrolment_date->format('d M Y') : 'N/A' }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="data-label">Date of Rank</span>
                                <span class="data-value">{{ $soldier->rank_date ? $soldier->rank_date->format('d M Y') : 'N/A' }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="data-label">Appointment</span>
                                <span class="data-value text-military-primary">{{ $soldier->appointment ?? 'N/A' }}</span>
                                <p class="font-bengali text-[11px] font-bold text-slate-400 mt-1">{{ $soldier->appointment_bn }}</p>
                            </div>
                            <div class="space-y-1">
                                <span class="data-label">Batch [ব্যাচ]</span>
                                <span class="data-value">{{ $soldier->batch ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 11: Miscellaneous -->
                    <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-military-bg flex items-center gap-3">
                            <span class="section-tag">SEC-11</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-500">Logistics & Bio-Metrics</h3>
                        </div>
                        <div class="p-8 grid grid-cols-2 gap-8">
                            <div class="space-y-1">
                                <span class="data-label">Height [উচ্চতা]</span>
                                <span class="data-value uppercase">{{ $soldier->height ?? 'N/A' }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="data-label">Weight [ওজন]</span>
                                <span class="data-value uppercase">{{ $soldier->weight ?? 'N/A' }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="data-label">Religion</span>
                                <span class="data-value">{{ $soldier->religion ?? 'N/A' }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="data-label">Marital Status</span>
                                <span class="data-value">{{ $soldier->marital_status ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 04: Personal Identity -->
                <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-100 flex items-center gap-3">
                        <span class="section-tag">SEC-04</span>
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-800">Family & Civil Identity [পারিবারিক ও এনআইডি]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-10">
                        <div class="space-y-2">
                            <span class="data-label">Father's Name</span>
                            <span class="data-value">{{ $soldier->father_name ?? 'N/A' }}</span>
                        </div>
                        <div class="space-y-2 border-l border-slate-100 pl-8">
                            <span class="data-label">Mother's Name</span>
                            <span class="data-value">{{ $soldier->mother_name ?? 'N/A' }}</span>
                        </div>
                        <div class="space-y-2 border-l border-slate-100 pl-8">
                            <span class="data-label">Spouse Name</span>
                            <span class="data-value">{{ $soldier->spouse_name ?? 'N/A' }}</span>
                        </div>
                        <div class="space-y-2">
                            <span class="data-label">Date of Birth</span>
                            <span class="data-value">{{ $soldier->dob ? $soldier->dob->format('d M Y') : 'N/A' }}</span>
                        </div>
                        <div class="space-y-2 border-l border-slate-100 pl-8 col-span-2">
                            <span class="data-label">NID / Protocol No</span>
                            <span class="data-value font-mono tracking-widest">{{ $soldier->nid ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Section 05: Residential Trace -->
                <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                    <div class="px-8 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50">
                        <span class="section-tag">SEC-05</span>
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-800">Geographic Trace [স্থায়ী ঠিকানা]</h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-4 gap-10">
                         <div class="space-y-1">
                            <span class="data-label">Home District</span>
                            <span class="data-value text-military-primary">{{ $soldier->home_district ?? 'N/A' }}</span>
                        </div>
                        <div class="md:col-span-3 space-y-1 pl-8 border-l border-slate-100">
                            <span class="data-label">Permanent Address</span>
                            <p class="data-value uppercase leading-relaxed">{{ $soldier->permanent_address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Section 06: Annual Career Trajectory (The 5-Level Plan) -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-8 py-5 bg-military-primary flex items-center justify-between text-white">
                        <div class="flex items-center gap-3">
                            <span class="section-tag !bg-white !text-military-primary">SEC-06</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Strategic Career Trajectory Analysis</h3>
                        </div>
                        <span class="text-[9px] font-black opacity-50 uppercase tracking-[0.3em]">5-Phase Professional Plan</span>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest w-16">Phase</th>
                                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest w-24">Year</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Trade / Specialty</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Re-engagement</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Strategic Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php
                                    $plans = $soldier->annual_career_plans ?? [];
                                    // Ensure at least 5 lines are shown
                                    $total_lines = max(5, count($plans));
                                @endphp
                                @for($i = 0; $i < $total_lines; $i++)
                                    @php $plan = $plans[$i] ?? null; @endphp
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-8 py-4 text-xs font-black text-slate-300">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-4 py-4 text-[13px] font-black text-military-primary">{{ $plan['year'] ?? '' }}</td>
                                        <td class="px-6 py-4 text-[12px] font-bold text-slate-700 uppercase">{{ $plan['trade'] ?? '' }}</td>
                                        <td class="px-6 py-4 text-[12px] font-bold text-slate-700 uppercase">{{ $plan['re_engagement'] ?? '' }}</td>
                                        <td class="px-8 py-4 text-[12px] font-bold text-slate-500 italic">{{ $plan['remarks'] ?? ($i < count($plans) ? '' : '---') }}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 07: Combat Readiness & Performance -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- IPFT Summary -->
                    <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-8 py-5 bg-military-accent border-b border-white/20 flex items-center gap-3">
                            <span class="section-tag !bg-white !text-military-primary">SEC-07A</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Physical Fitness (IPFT)</h3>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="flex justify-between items-center bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label !mb-0">Cycle 01 Results</span>
                                <span class="px-4 py-1 {{ $soldier->ipft_biannual_1 == 'Pass' ? 'bg-military-success' : 'bg-military-danger' }} text-white text-[11px] font-black uppercase">{{ $soldier->ipft_biannual_1 ?? 'Untested' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label !mb-0">Cycle 02 Results</span>
                                <span class="px-4 py-1 {{ $soldier->ipft_biannual_2 == 'Pass' ? 'bg-military-success' : 'bg-military-danger' }} text-white text-[11px] font-black uppercase">{{ $soldier->ipft_biannual_2 ?? 'Untested' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Firing Mastery -->
                    <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-8 py-5 bg-military-danger border-b border-white/20 flex items-center gap-3">
                            <span class="section-tag !bg-white !text-military-danger">SEC-07B</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Firing Analytics (STH)</h3>
                        </div>
                        <div class="p-8">
                             <div class="flex items-center justify-between mb-6">
                                <div>
                                    <span class="data-label">Marksman Tier</span>
                                    <span class="text-2xl font-black text-military-danger uppercase tracking-tighter">{{ $soldier->shooting_grade }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="data-label">Total Score</span>
                                    <span class="text-3xl font-black text-slate-900 font-mono tracking-tighter">{{ $soldier->shoot_total ?? '000' }}</span>
                                </div>
                             </div>
                             <div class="grid grid-cols-3 gap-4 border-t border-slate-100 pt-6">
                                <div class="text-center">
                                    <span class="text-[9px] font-black text-slate-400 uppercase">Hit</span>
                                    <p class="text-[16px] font-black text-slate-700">{{ $soldier->shoot_ret ?? '00' }}</p>
                                </div>
                                <div class="text-center border-x border-slate-100">
                                    <span class="text-[9px] font-black text-slate-400 uppercase">AP</span>
                                    <p class="text-[16px] font-black text-slate-700">{{ $soldier->shoot_ap ?? '00' }}</p>
                                </div>
                                <div class="text-center">
                                    <span class="text-[9px] font-black text-slate-400 uppercase">ETS</span>
                                    <p class="text-[16px] font-black text-slate-700">{{ $soldier->shoot_ets ?? '00' }}</p>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Section 09-10: Training Analytics Grids -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                     <!-- Section 09: Course & Cadre -->
                     <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-6 py-3 bg-slate-100 border-b border-slate-200 flex items-center gap-3">
                            <span class="section-tag !bg-slate-500">SEC-09</span>
                            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-600">Training Analytics</h3>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left text-[11px]">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100">
                                        <th class="px-6 py-3 font-black text-slate-400 uppercase">Course Name</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Year</th>
                                        <th class="px-6 py-3 font-black text-slate-400 uppercase text-right">Result</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($soldier->courses as $course)
                                        <tr>
                                            <td class="px-6 py-3 font-bold text-slate-700 uppercase">{{ $course->name }}</td>
                                            <td class="px-4 py-3 font-black text-military-primary text-center">{{ $course->year }}</td>
                                            <td class="px-6 py-3 font-bold text-slate-500 text-right uppercase">{{ $course->result }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-6 py-10 text-center text-slate-300 font-bold uppercase tracking-widest italic">No verified records found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section 10: Unit Performance -->
                    <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-6 py-3 bg-slate-100 border-b border-slate-200 flex items-center gap-3">
                            <span class="section-tag !bg-slate-500">SEC-10</span>
                            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-600">Unit Cycle Records</h3>
                        </div>
                        <div class="p-0 overflow-x-auto">
                             <table class="w-full text-left text-[11px]">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100">
                                        <th class="px-6 py-3 font-black text-slate-400 uppercase">Cycle Detail</th>
                                        <th class="px-6 py-3 font-black text-slate-400 uppercase text-right">Standard</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($soldier->unitTrainings as $ut)
                                        <tr>
                                            <td class="px-6 py-3 font-black text-military-secondary uppercase">{{ $ut->cycle }} ({{ $ut->year }})</td>
                                            <td class="px-6 py-3 font-bold text-slate-700 text-right uppercase italic">{{ $ut->standard_remarks }}</td>
                                        </tr>
                                    @empty
                                         <tr><td colspan="2" class="px-6 py-10 text-center text-slate-300 font-bold uppercase tracking-widest italic">Node performance pending evaluation.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Final Logistics Footer -->
                <div class="bg-military-bg border border-slate-200 p-8 flex flex-col md:flex-row justify-between items-center gap-8 shadow-inner">
                    <div class="flex-1 space-y-2">
                        <span class="data-label">Special Strategic Interests [খেলাধুলা ও অন্যান্য]</span>
                        <p class="text-[13px] font-bold text-slate-600 uppercase leading-relaxed">{{ $soldier->sports_participation ?? 'No participation in extra-curricular nodes recorded.' }}</p>
                    </div>
                    <div class="w-full md:w-auto bg-white border border-slate-200 p-4 min-w-[200px]">
                        <span class="data-label">Leave Status</span>
                        <span class="text-[14px] font-black text-military-secondary">{{ $soldier->leave_plan ?? 'Rotation Standby' }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
