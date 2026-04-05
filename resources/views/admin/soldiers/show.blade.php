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

        @media print {

            .no-print,
            .sidebar,
            .top-header,
            .btn-group,
            .fixed-top {
                display: none !important;
            }

            .content-wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }

            .tactical-border {
                border: 1px solid #ddd !important;
            }
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Individual <span
                            class="text-military-primary">Training Records</span></h2>
                    <div class="flex items-center gap-3 mt-1">
                        <span
                            class="px-2 py-0.5 bg-military-bg text-military-primary text-[9px] font-black border border-military-primary/20 tracking-tighter uppercase">{{ $soldier->user_type }}</span>
                        <span class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Protocol ID:
                            {{ $soldier->number }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 no-print">
                <a href="{{ route('admin.soldiers.print-record-book', $soldier) }}" target="_blank"
                    class="px-6 py-3 bg-slate-100 text-slate-700 text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center gap-3 shadow group border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Print Profile
                </a>
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
                    Modify Records
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-8">
            <!-- Left Column: Identity Matrix (4 cols) -->
            <div class="col-span-12 lg:col-span-4 space-y-8">
                <!-- SEC-01: Personal Identity [গোপনীয় তথ্য] -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 tactical-header flex items-center justify-between text-white">
                        <div class="flex items-center gap-3">
                            <span class="section-tag">SEC-01</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Personal Identity
                                [গোপনীয় তথ্য]</h3>
                        </div>
                    </div>

                    <div class="p-8 flex flex-col items-center text-center">
                        <div class="relative mb-8">
                            <div
                                class="w-48 h-56 border-2 border-slate-200 p-1.5 bg-slate-50 relative z-10 overflow-hidden shadow-inner ring-8 ring-military-bg">
                                <img src="{{ $soldier->photo_url }}" class="w-full h-full object-cover">
                            </div>
                            <div
                                class="absolute -top-4 -right-4 w-12 h-12 bg-military-accent border-4 border-white flex items-center justify-center shadow-lg z-20">
                                <span
                                    class="text-[14px] font-black text-military-primary">{{ $soldier->blood_group }}</span>
                            </div>
                        </div>

                        <div class="space-y-1 mb-6">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ $soldier->name }}</h3>
                            <p class="font-bengali text-lg font-bold text-slate-500">{{ $soldier->name_bn }}</p>
                        </div>

                        <div class="w-full grid grid-cols-2 gap-4 pt-6 border-t border-slate-100">
                            <div class="text-left bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label">Personal No</span>
                                <span
                                    class="text-[14px] font-black text-military-primary">{{ $soldier->personal_no }}</span>
                            </div>
                            <div class="text-left bg-slate-50 p-4 border border-slate-200">
                                <span class="data-label">Rank</span>
                                <span class="text-[14px] font-black text-slate-800">{{ $soldier->rank }}</span>
                                <div class="hidden flex-col items-end">
                                    <span class="text-slate-400 text-[11px] font-bold uppercase tracking-widest">Protocol
                                        ID:</span>
                                    <span
                                        class="text-[13px] font-black text-slate-700 tracking-tight">{{ $soldier->number }}</span>
                                </div>
                                <p class="font-bengali text-[11px] font-bold text-slate-400 mt-0.5 italic">
                                    {{ $soldier->rank_bn }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEC-02: Tactical Chain of Command [ব্যক্তিগত তথ্য] -->
                <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                    <div class="px-6 py-3 bg-military-bg border-b border-slate-200 flex items-center gap-3">
                        <span class="section-tag">SEC-02</span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-600">Personal Profile &
                            Bio-data [ব্যক্তিগত তথ্য]</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-6 pb-4 border-b border-slate-100">
                            <div class="space-y-1">
                                <span class="data-label">Join Date</span>
                                <span
                                    class="data-value text-sm">{{ $soldier->enrolment_date ? $soldier->enrolment_date->format('d M Y') : 'N/A' }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="data-label">Rank Date</span>
                                <span
                                    class="data-value text-sm">{{ $soldier->rank_date ? $soldier->rank_date->format('d M Y') : 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Unit</span>
                                <span
                                    class="text-[13px] font-black text-military-primary">{{ $soldier->battalion_name }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Company</span>
                                <span class="text-[13px] font-black text-slate-700">{{ $soldier->company ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Platoon</span>
                                <span class="text-[13px] font-black text-slate-700">{{ $soldier->platoon ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Section</span>
                                <span class="text-[13px] font-black text-slate-700">{{ $soldier->section ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="pt-4 space-y-3 border-t border-slate-100">
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Home District [জেলা]</span>
                                <span
                                    class="text-[13px] font-black text-military-primary">{{ $soldier->home_district ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Religion</span>
                                <span
                                    class="text-[13px] font-black text-slate-700">{{ $soldier->religion ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Gender [লিঙ্গ]</span>
                                <span
                                    class="text-[13px] font-black text-military-primary">{{ $soldier->gender ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Marital Status</span>
                                <span
                                    class="text-[13px] font-black text-slate-700">{{ $soldier->marital_status ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">National ID (NID)</span>
                                <span class="text-[13px] font-black text-slate-700">{{ $soldier->nid ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-3 border border-slate-200">
                                <span class="data-label !mb-0">Spouse Name [স্ত্রীর নাম]</span>
                                <span
                                    class="text-[13px] font-black text-military-primary">{{ $soldier->spouse_name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Training Matrix (8 cols) -->
            <div class="col-span-12 lg:col-span-8 space-y-8">
                <!-- SEC-03: Tactical Training Records [প্রশিক্ষণ রেকর্ড] -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-8 py-5 bg-military-primary text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="section-tag !bg-white !text-military-primary">SEC-03</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Individual Training
                                Records [ ব্যক্তিগত প্রশিক্ষণ রেকর্ড]</h3>
                        </div>
                    </div>

                    <!-- 3.1 IPFT -->
                    <div class="p-6 border-b border-slate-100">
                        {{-- <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 bg-military-accent"></span>
                            <h4 class="text-[11px] font-black uppercase tracking-widest text-white"></h4>
                        </div> --}}
                        <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                            <span class="section-tag !bg-amber-500 !text-slate-900">3.1</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Individual Physical
                                Fitness Training (IPFT) [শারীরিক সক্ষমতা]</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex justify-between items-center bg-slate-50 p-4 border border-slate-200">
                                <div>
                                    <span class="data-label !mb-0">Biannual 01</span>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase">(জানুয়ারি - জুন)</p>
                                </div>
                                <span
                                    class="px-4 py-1 {{ in_array(strtoupper($soldier->ipft_biannual_1 ?? ''), ['PASS', 'P']) ? 'bg-military-success' : 'bg-military-danger' }} text-white text-[11px] font-black uppercase">{{ $soldier->ipft_biannual_1 ?? '---' }}</span>
                            </div>
                            <div class="flex justify-between items-center bg-slate-50 p-4 border border-slate-200">
                                <div>
                                    <span class="data-label !mb-0">Biannual 02</span>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase">(জুলাই - ডিসেম্বর)</p>
                                </div>
                                <span
                                    class="px-4 py-1 {{ in_array(strtoupper($soldier->ipft_biannual_2 ?? ''), ['PASS', 'P']) ? 'bg-military-success' : 'bg-military-danger' }} text-white text-[11px] font-black uppercase">{{ $soldier->ipft_biannual_2 ?? '---' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3.2 RET Firing -->
                    <div class="p-6 border-b border-slate-100">
                        {{-- <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 bg-military-danger"></span>
                            <h4 class="text-[11px] font-black uppercase tracking-widest text-slate-800">3.2 RET Firing
                                [আরইটি ফায়ারিং প্রোফাইল]</h4>
                        </div> --}}
                        <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                            <span class="section-tag !bg-amber-500 !text-slate-900">3.2</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">RET Firing
                                [আরইটি ফায়ারিং প্রোফাইল]</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-[11px] border-collapse bg-slate-50/50">
                                <thead>
                                    <tr class="bg-slate-100 border-b border-slate-200">
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase w-12 text-center">Sl</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Date</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Grouping</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Hit</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">ETS</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Status</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Mark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($soldier->firing_records ?? [] as $index => $rec)
                                        <tr class="border-b border-slate-100 text-center font-bold">
                                            <td class="px-2 py-3 text-slate-400">{{ $index + 1 }}</td>
                                            <td class="px-2 py-3 text-military-primary">{{ $rec['date'] ?? '---' }}</td>
                                            <td class="px-2 py-3">{{ $rec['grouping'] ?? '---' }}</td>
                                            <td class="px-2 py-3">{{ $rec['hit'] ?? '---' }}</td>
                                            <td class="px-2 py-3">{{ $rec['ets'] ?? '---' }}</td>
                                            <td
                                                class="px-2 py-3 uppercase {{ strtoupper($rec['status'] ?? '') == 'PASS' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $rec['status'] ?? '---' }}</td>
                                            <td
                                                class="px-2 py-3 {{ strtoupper($rec['status'] ?? '') == 'PASS' ? 'text-green-600' : 'text-military-danger' }}">
                                                {{ $rec['total'] ?? '---' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7"
                                                class="px-4 py-8 text-center text-slate-300 italic uppercase">No records
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 3.3 Night Firing -->
                    <div class="p-6 border-b border-slate-100">
                        {{-- <div class="flex items-center gap-2 mb-4">
                            <span class="w-1.5 h-6 bg-blue-900"></span>
                            <h4 class="text-[11px] font-black uppercase tracking-widest text-slate-800">3.3 Night Firing
                                [নাইট ফায়ারিং]</h4>
                        </div> --}}
                        <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                            <span class="section-tag !bg-amber-500 !text-slate-900">3.3</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Night Firing
                                [নাইট ফায়ারিং]</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-[11px] border-collapse bg-slate-50/50">
                                <thead>
                                    <tr class="bg-slate-100 border-b border-slate-200">
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase w-12 text-center">Sl</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Date</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Hit</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Status</th>
                                        <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Mark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($soldier->night_firing_records ?? [] as $index => $rec)
                                        <tr class="border-b border-slate-100 text-center font-bold">
                                            <td class="px-2 py-3 text-slate-400">{{ $index + 1 }}</td>
                                            <td class="px-2 py-3 text-blue-900">{{ $rec['date'] ?? '---' }}</td>
                                            <td class="px-2 py-3">{{ $rec['hit'] ?? '---' }}</td>
                                            <td
                                                class="px-2 py-3 uppercase {{ strtoupper($rec['status'] ?? '') == 'PASS' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $rec['status'] ?? '---' }}</td>
                                            <td
                                                class="px-2 py-3 {{ strtoupper($rec['status'] ?? '') == 'PASS' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $rec['total'] ?? '---' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                class="px-4 py-8 text-center text-slate-300 italic uppercase">No records
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- 3.4 & 3.5 Speed March & Grenade -->
                    <div class="grid grid-cols-2">
                        <div class="p-0 border-r border-slate-100">
                            <div class="px-6 py-3 bg-slate-900 flex items-center gap-3 text-white mb-4">
                                <span class="section-tag !bg-rose-500 !text-white">3.4</span>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-white">Speed March [স্পিড
                                    মার্চ]</h4>
                            </div>
                            <div class="bg-slate-50 p-4 border border-slate-200 flex justify-between items-center">
                                <span class="data-label !mb-0">Result</span>
                                <span
                                    class="text-xs font-black text-military-primary uppercase tracking-widest">{{ $soldier->speed_march ?? '---' }}</span>
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="px-6 py-3 bg-slate-900 flex items-center gap-3 text-white mb-4">
                                <span class="section-tag !bg-emerald-500 !text-white">3.5</span>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-white">Grenade Firing
                                    [গ্রেনেড ফায়ার]</h4>
                            </div>
                            <div class="bg-slate-50 p-4 border border-slate-200 flex justify-between items-center">
                                <span class="data-label !mb-0">Result</span>
                                <span
                                    class="text-xs font-black text-military-primary uppercase tracking-widest">{{ $soldier->grenade_fire ?? '---' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3.6 & 3.7 NI Trg & GP Trg -->
                    <div class="grid grid-cols-2 border-t border-slate-100">
                        <div class="p-0 border-r border-slate-100">
                            <div class="px-6 py-3 bg-slate-900 flex items-center gap-3 text-white mb-4">
                                <span class="section-tag !bg-cyan-500 !text-slate-900">3.6</span>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-white">Night Training
                                    [রাত্রীকালীন প্রশিক্ষণ]</h4>
                            </div>
                            <div class="space-y-2">
                                @forelse($soldier->night_trainings ?? [] as $nt)
                                    <div
                                        class="flex justify-between items-center text-[10px] p-2 bg-slate-50 border border-slate-100 font-bold uppercase transition-colors hover:bg-slate-100">
                                        <span class="text-slate-500">{{ $nt['date'] ?? '---' }}</span>
                                        <span
                                            class="text-military-primary text-right">{{ $nt['appointment'] ?? '---' }}</span>
                                    </div>
                                @empty
                                    <p class="text-[10px] text-slate-300 uppercase italic">No records.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="p-0">
                            <div class="px-6 py-3 bg-slate-900 flex items-center gap-3 text-white mb-4">
                                <span class="section-tag !bg-purple-500 !text-white">3.7</span>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-white">Group Training
                                    [দলগত প্রশিক্ষণ]</h4>
                            </div>
                            <div class="space-y-2">
                                @forelse($soldier->group_trainings ?? [] as $gt)
                                    <div
                                        class="flex flex-col gap-1 p-2 bg-slate-50 border border-slate-100 font-bold uppercase transition-colors hover:bg-slate-100">
                                        <div class="flex justify-between items-center text-[10px]">
                                            <span class="text-slate-500">{{ $gt['circle'] ?? '---' }} Circle
                                                ({{ $gt['year'] ?? '---' }})
                                            </span>
                                            <span
                                                class="text-military-primary text-right">{{ $gt['appointment'] ?? '---' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-[10px] text-slate-300 uppercase italic">No records.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- 3.8 Cycle Ending -->
                    <div class="p-0 border-t border-slate-100">
                        <div class="px-6 py-3 bg-slate-900 flex items-center gap-3 text-white mb-4">
                            <span class="section-tag !bg-blue-500 !text-white">3.8</span>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-white">Cycle Ending Exercise
                                [চক্র সমাপনী অনুশীলন]</h4>
                        </div>
                        @forelse($soldier->cycle_ending_exercises ?? [] as $ce)
                            <div
                                class="bg-slate-50 border border-slate-200 p-4 font-bold flex justify-between uppercase hover:bg-slate-100 transition-colors">
                                <span class="text-[9px] text-slate-400">{{ $ce['circle'] ?? '---' }} Circle |
                                    {{ $ce['year'] ?? '---' }}</span>
                                <span
                                    class="text-[11px] font-black text-military-primary">{{ $ce['unit'] ?? '---' }}</span>
                            </div>
                        @empty
                            <div
                                class="col-span-2 py-8 bg-slate-50 border border-dashed border-slate-200 text-center text-[10px] font-black text-slate-300 uppercase tracking-widest italic">
                                No records found.</div>
                        @endforelse
                    </div>
                </div>

                <!-- SEC-03.9: Summer Training -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                        <span class="section-tag !bg-amber-500 !text-slate-900">3.9</span>
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Summer Training Record
                            [গ্রীষ্মকালীন প্রশিক্ষণ]</h3>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse text-[11px]">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-4 py-4 font-black text-slate-400 uppercase w-12 text-center">Sl</th>
                                    <th class="px-4 py-4 font-black text-slate-400 uppercase w-24">Year</th>
                                    <th class="px-4 py-4 font-black text-slate-400 uppercase">Unit</th>
                                    <th class="px-4 py-2 font-black text-slate-400 uppercase">Appointment</th>
                                    <th class="px-4 py-2 font-black text-slate-400 uppercase">Standard/Remarks</th>
                                    <th class="px-4 py-2 font-black text-slate-400 uppercase w-32 text-center">Sign</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($soldier->field_trainings_summer ?? [] as $index => $trg)
                                    <tr
                                        class="hover:bg-amber-50/50 transition-colors border-b border-slate-100 font-bold uppercase">
                                        <td class="px-4 py-4 text-slate-400 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 text-amber-600">{{ $trg['year'] ?? '---' }}</td>
                                        <td class="px-4 py-4 text-slate-700">{{ $trg['unit'] ?? '---' }}</td>
                                        <td class="px-4 py-4 text-slate-700">{{ $trg['appointment'] ?? '---' }}</td>
                                        <td class="px-4 py-4 text-slate-500 italic lowercase">
                                            {{ $trg['remarks'] ?? '---' }}</td>
                                        <td class="px-4 py-4">
                                            <div class="h-4 border-b border-slate-200 border-dashed"></div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-20 text-center border-2 border-dashed border-slate-100 bg-slate-50/30">
                                            <div class="flex flex-col items-center justify-center space-y-3 opacity-30">
                                                <svg class="w-12 h-12 text-slate-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                                <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">
                                                    Tactical
                                                    Log: Awaiting Summer Training Records</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SEC-03.10: Winter Training -->
                <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
                    <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                        <span class="section-tag !bg-blue-500 !text-white">3.10</span>
                        <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Winter Training Record
                            [শীতকালীন
                            প্রশিক্ষণ]</h3>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left border-collapse text-[11px]">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-4 py-4 font-black text-slate-400 uppercase w-12 text-center">Sl</th>
                                    <th class="px-4 py-4 font-black text-slate-400 uppercase w-24">Year</th>
                                    <th class="px-4 py-4 font-black text-slate-400 uppercase">Unit</th>
                                    <th class="px-4 py-2 font-black text-slate-400 uppercase">Appointment</th>
                                    <th class="px-4 py-2 font-black text-slate-400 uppercase">Standard/Remarks</th>
                                    <th class="px-4 py-2 font-black text-slate-400 uppercase w-32 text-center">Sign</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($soldier->field_trainings_winter ?? [] as $index => $trg)
                                    <tr
                                        class="hover:bg-blue-50/50 transition-colors border-b border-slate-100 font-bold uppercase">
                                        <td class="px-4 py-4 text-slate-400 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 text-blue-600">{{ $trg['year'] ?? '---' }}</td>
                                        <td class="px-4 py-4 text-slate-700">{{ $trg['unit'] ?? '---' }}</td>
                                        <td class="px-4 py-4 text-slate-700">{{ $trg['appointment'] ?? '---' }}</td>
                                        <td class="px-4 py-4 text-slate-500 italic lowercase">
                                            {{ $trg['remarks'] ?? '---' }}</td>
                                        <td class="px-4 py-4">
                                            <div class="h-4 border-b border-slate-200 border-dashed"></div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-20 text-center border-2 border-dashed border-slate-100 bg-slate-50/30">
                                            <div class="flex flex-col items-center justify-center space-y-3 opacity-30">
                                                <svg class="w-12 h-12 text-slate-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                                    </path>
                                                </svg>
                                                <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">
                                                    Tactical
                                                    Log: Awaiting Winter Training Records</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SEC-04 & SEC-05: Courses & Cadres -->
                <div class="grid grid-cols-1 gap-8">
                    <!-- SEC-04: Courses -->
                    <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                            <span class="section-tag !bg-indigo-500 !text-white">SEC-04</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Promotion Training
                                Course / Cadre</h3>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left text-[11px] border-collapse">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                        <th class="px-4 py-2">Course</th>
                                        <th class="px-4 py-2 text-center">Year</th>
                                        <th class="px-4 py-2 text-right">Result</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($soldier->courses ?? [] as $course)
                                        <tr class="hover:bg-slate-50 font-bold">
                                            <td class="px-4 py-3">{{ $course->name ?? '---' }}</td>
                                            <td class="px-4 py-3 text-center">{{ $course->year ?? '---' }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <span class="text-military-primary">{{ $course->result ?? 'PASS' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"
                                                class="px-4 py-10 text-center uppercase italic text-slate-300">No courses
                                                logged.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SEC-05: Special Training -->
                    <div class="bg-white border border-slate-200 shadow-lg overflow-hidden">
                        <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                            <span class="section-tag !bg-teal-500 !text-white">SEC-05</span>
                            <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Army level
                                course/cadre & special training [বিশেষ প্রশিক্ষণ]</h3>
                        </div>
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left text-[11px] border-collapse">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                        <th class="px-4 py-2">Training</th>
                                        <th class="px-4 py-2 text-center">Year</th>
                                        <th class="px-4 py-2 text-right">Unit</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($soldier->special_courses ?? [] as $sc)
                                        <tr class="hover:bg-slate-50 font-bold uppercase">
                                            <td class="px-4 py-3">
                                                <div class="text-slate-900">{{ $sc['name'] ?? '---' }}</div>
                                                <div
                                                    class="text-[8px] text-slate-400 font-black uppercase tracking-widest mt-0.5">
                                                    {{ $sc['details'] ?? '---' }}</div>
                                            </td>
                                            <td class="px-4 py-3 text-center text-slate-500">{{ $sc['year'] ?? '---' }}
                                            </td>
                                            <td class="px-4 py-3 text-right text-military-primary">
                                                {{ $sc['unit'] ?? '---' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3"
                                                class="px-4 py-10 text-center uppercase italic text-slate-300">No training
                                                records logged.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- SEC-06: Annual Career Plan -->
        <div class="bg-white border border-slate-200 shadow-xl overflow-hidden">
            <div class="px-8 py-5 bg-slate-900 flex items-center gap-3 text-white">
                <span class="section-tag !bg-military-accent !text-slate-900">SEC-06</span>
                <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Annual Career Plan [বাৎসরিক পেশা
                    পরিকল্পনা]</h3>
            </div>
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-3 font-black text-slate-400 uppercase text-center w-12">Sl</th>
                            <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Year</th>
                            <th class="px-4 py-3 font-black text-slate-400 uppercase">Leave</th>
                            <th class="px-4 py-3 font-black text-slate-400 uppercase">Unit Trg</th>
                            <th class="px-4 py-3 font-black text-slate-400 uppercase">Personal</th>
                            <th class="px-4 py-3 font-black text-slate-400 uppercase">Admin</th>
                            <th class="px-4 py-3 font-black text-slate-400 uppercase text-center">Sign</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($soldier->annual_career_plans ?? [] as $index => $plan)
                            <tr class="font-bold uppercase hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-center text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-center text-military-primary">{{ $plan['year'] ?? '---' }}</td>
                                <td class="px-4 py-3">{{ $plan['leave'] ?? '---' }}</td>
                                <td class="px-4 py-3">{{ $plan['unit_trg'] ?? '---' }}</td>
                                <td class="px-4 py-3">{{ $plan['personal_trg'] ?? '---' }}</td>
                                <td class="px-4 py-3">{{ $plan['admin'] ?? '---' }}</td>
                                <td class="px-4 py-3 text-center text-[9px] italic text-slate-400">
                                    {{ $plan['signature'] ?? '---' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="px-8 py-10 text-center text-slate-300 font-bold uppercase italic">No records
                                    found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SEC-07: Sports Participation [খেলাধুলা ও অন্যান্য] -->
        <div class="bg-white border border-slate-200 shadow-lg p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="section-tag !bg-green-600">SEC-07</span>
                <h3 class="text-[11px] font-black uppercase tracking-widest text-slate-800">Physical & Extra Curricular
                    Activities</h3>
            </div>
            <div class="p-6 bg-slate-50 border border-slate-200 rounded-sm">
                <p class="text-xs font-bold text-slate-700 uppercase leading-relaxed text-left">
                    {!! nl2br(e($soldier->sports_participation ?? 'No participation in extra-curricular nodes recorded.')) !!}
                </p>
            </div>
        </div>

        <!-- SEC-08: Physical & Obesity Analysis [শারীরিক ও স্থূলতা বিশ্লেষণ] -->
        <div class="bg-white border border-slate-200 shadow-xl overflow-hidden mt-8">
            <div class="px-8 py-5 tactical-header flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <span class="section-tag">SEC-08</span>
                    <h3 class="text-[11px] font-black uppercase tracking-widest text-white">Physical & Obesity Analysis
                        [শারীরিক ও স্থূলতা বিশ্লেষণ]</h3>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="space-y-1 p-4 bg-slate-50 border-l-4 border-slate-200">
                        <span class="data-label">Height [উচ্চতা]</span>
                        <span
                            class="data-value">{{ $soldier->height_inch ? floor($soldier->height_inch / 12) . '\'' . $soldier->height_inch % 12 . '"' : '---' }}</span>
                        <p class="text-[10px] font-bold text-slate-400">
                            ({{ number_format(($soldier->height_inch ?? 0) * 2.54, 1) }} CM)</p>
                    </div>
                    <div class="space-y-1 p-4 bg-slate-50 border-l-4 border-slate-200">
                        <span class="data-label">Weight [ওজন]</span>
                        <span
                            class="data-value {{ !in_array($soldier->weight_status, ['Normal', 'N/A']) ? 'text-red-600' : 'text-emerald-600' }}">{{ $soldier->weight ?? '---' }}
                            KG</span>
                        <p class="text-[10px] font-bold text-slate-400">
                            ({{ number_format(($soldier->weight ?? 0) * 2.20462, 1) }} LBS)</p>
                    </div>
                    <div class="space-y-1 p-4 bg-slate-50 border-l-4 border-slate-200">
                        <span class="data-label">Body Frame [গঠন]</span>
                        <span class="data-value">{{ $soldier->body_frame }}</span>
                        <p class="text-[10px] font-bold text-slate-400">{{ $soldier->wrist_cm ?? '---' }} CM WRIST</p>
                    </div>
                    <div class="space-y-1 p-4 bg-slate-50 border-l-4 border-slate-200">
                        <span class="data-label">WHR Index</span>
                        <span class="data-value">{{ $soldier->whr ?? '---' }}</span>
                        <p class="text-[10px] font-bold text-slate-400">{{ $soldier->waist_inch ?? '---' }} /
                            {{ $soldier->hip_inch ?? '---' }}</p>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-100">
                    <div class="space-y-4">
                        <div
                            class="flex justify-between items-center text-[11px] font-black uppercase tracking-widest text-slate-500">
                            <span>Military Allowance: +{{ $soldier->weight_allowance }} KG</span>
                            <span>Limit: {{ number_format($soldier->standard_weight + $soldier->weight_allowance, 1) }}
                                KG</span>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                            @php
                                $limit = $soldier->standard_weight + $soldier->weight_allowance;
                                $percent = min(100, (($soldier->weight ?? 0) / max(1, $limit)) * 100);
                                $color = in_array($soldier->weight_status, ['Obese', 'Obese (WHR)'])
                                    ? 'bg-red-600'
                                    : ($soldier->weight_status == 'Overweight'
                                        ? 'bg-amber-500'
                                        : 'bg-emerald-500');
                            @endphp
                            <div class="h-full {{ $color }} transition-all" style="width: {{ $percent }}%">
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-900 p-6 flex flex-col items-center justify-center text-center">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2">Tactical
                            Readiness Status</span>
                        <h4
                            class="text-2xl font-black {{ in_array($soldier->weight_status, ['Obese', 'Obese (WHR)']) ? 'text-red-500' : ($soldier->weight_status == 'Overweight' ? 'text-amber-400' : 'text-emerald-400') }} uppercase tracking-widest">
                            {{ $soldier->weight_status }}
                        </h4>
                        @if ($soldier->weight_status != 'Normal' && $soldier->weight_status != 'N/A')
                            <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase">REPLACEMENT/EXERCISE REQUIRED:
                                {{ number_format($soldier->weight - $limit, 1) }} KG EXCESS</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
