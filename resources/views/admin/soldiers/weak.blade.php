@extends('layouts.admin')

@section('title', 'Needs Improvement Registry')

@section('styles')
    <style>
        .weak-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
        }

        .dark .weak-card {
            background: rgba(15, 23, 42, 0.8);
            border-color: rgba(239, 68, 68, 0.2);
        }

        .failure-tag {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.1em;
            padding: 2px 8px;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto space-y-12 animate-fade-in pb-20 px-4">

        <!-- Strategic Header -->
        <div
            class="flex flex-col md:flex-row md:items-center justify-between gap-8 border-b border-slate-200 dark:border-slate-800 pb-10">
            <div class="space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full text-[10px] font-black uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    Critical Training Alert
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                    Improvement <span class="text-red-600">Registry</span></h1>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.4em]">Personnel below operational
                    readiness thresholds [উন্নতি প্রয়োজন এমন সৈনিকদের তালিকা]</p>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-[32px] font-black text-red-600 leading-none">{{ $soldiers->total() }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pending Remediation</p>
                </div>
            </div>
        </div>

        <!-- Category Navigation -->
        <div class="flex flex-wrap gap-4 border-b border-slate-100 dark:border-slate-800 pb-2">
            <a href="{{ route('admin.soldiers.weak', ['category' => 'all']) }}"
                class="px-6 py-4 text-[13px] font-black uppercase tracking-widest transition-all border-b-2 {{ request('category') == 'all' || !request('category') ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                ALL
            </a>
            <a href="{{ route('admin.soldiers.weak', ['category' => 'IP50']) }}" 
               class="px-6 py-4 text-[13px] font-black uppercase tracking-widest transition-all border-b-2 {{ request('category') == 'IP50' ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                IPFT FAIL
            </a>
            <a href="{{ route('admin.soldiers.weak', ['category' => 'RT']) }}" 
               class="px-6 py-4 text-[13px] font-black uppercase tracking-widest transition-all border-b-2 {{ request('category') == 'RT' ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                RT FAIL
            </a>
            <a href="{{ route('admin.soldiers.weak', ['category' => 'Overweight']) }}" 
               class="px-6 py-4 text-[13px] font-black uppercase tracking-widest transition-all border-b-2 {{ request('category') == 'Overweight' ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600' }}">
                OVERWEIGHT
            </a>
        </div>

        <!-- Personnel Grid -->
        @if ($soldiers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($soldiers as $soldier)
                    <div class="weak-card p-6 shadow-xl transition-all hover:-translate-y-1 relative overflow-hidden group">
                        @if ($soldier->weight_status == 'Obese' || $soldier->weight_status == 'Obese (WHR)')
                            <div
                                class="absolute -right-12 -top-12 w-24 h-24 bg-red-600/10 rotate-45 flex items-end justify-center pb-2">
                                <span class="text-[10px] font-black text-red-600 uppercase tracking-tighter">OBESE</span>
                            </div>
                        @endif

                        <div class="flex items-start gap-4">
                            <div
                                class="w-20 h-24 bg-slate-100 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 p-0.5 overflow-hidden ring-4 ring-slate-100 dark:ring-slate-900 group-hover:ring-red-100 transition-all">
                                <img src="{{ $soldier->photo_url }}"
                                    class="w-full h-full object-cover  group-hover:grayscale-0 transition-all">
                            </div>
                            <div class="flex-1 space-y-4">
                                <div>
                                    <h3
                                        class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight leading-tight group-hover:text-red-600 transition-colors">
                                        {{ $soldier->name }}</h3>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">
                                        {{ $soldier->rank }} &bull; {{ $soldier->number }}</p>
                                </div>

                                <!-- Failed Metrics -->
                                <div class="flex flex-wrap gap-2">
                                    @if ($soldier->ipft_biannual_1 == 'Failed')
                                        <span class="failure-tag">IPFT-1 FAIL</span>
                                    @endif
                                    @if ($soldier->ipft_biannual_2 == 'Failed')
                                        <span class="failure-tag">IPFT-2 FAIL</span>
                                    @endif

                                    @php
                                        $hasRtFail =
                                            ((int) $soldier->shoot_total < 180 && (int) $soldier->shoot_total > 0) ||
                                            str_contains(json_encode($soldier->firing_records), '"status":"Fail"') ||
                                            str_contains(
                                                json_encode($soldier->night_firing_records),
                                                '"status":"Fail"',
                                            );
                                    @endphp
                                    @if ($hasRtFail)
                                        <span class="failure-tag">RT FAIL</span>
                                    @endif

                                    @if ($soldier->weight_status != 'Normal' && $soldier->weight_status != 'N/A')
                                        <span
                                            class="failure-tag {{ str_contains($soldier->weight_status, 'Obese') ? 'bg-red-600 text-white border-0' : '' }}">
                                            {{ $soldier->weight_status }} ({{ $soldier->weight }} KG)
                                        </span>
                                    @endif

                                    @php
                                        $smVal = (int) substr($soldier->speed_march, 0, 1);
                                    @endphp
                                    @if (
                                        $soldier->speed_march == 'Fail' ||
                                            ($soldier->speed_march && str_contains($soldier->speed_march, '/') && $smVal < 2))
                                        <span class="failure-tag">SPD MARCH FAIL</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Obesity Details Row (Auto-calculated) -->
                        @if ($soldier->weight_status != 'Normal')
                            <div
                                class="mt-6 p-4 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 space-y-2">
                                <div
                                    class="flex justify-between items-center text-[9px] font-bold uppercase tracking-widest text-slate-400">
                                    <span>Standard: {{ number_format($soldier->standard_weight, 1) }} KG</span>
                                    <span>Allowed:
                                        {{ number_format($soldier->standard_weight + $soldier->weight_allowance, 1) }}
                                        KG</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    @php
                                        $limit = $soldier->standard_weight + $soldier->weight_allowance;
                                        $percent = min(100, ($soldier->weight / max(1, $limit)) * 100);
                                    @endphp
                                    <div class="h-full bg-red-600" style="width: {{ $percent }}%"></div>
                                </div>
                                <p class="text-[9px] font-black text-red-600 text-right uppercase tracking-tighter">
                                    Excess: {{ number_format($soldier->weight - $limit, 1) }} KG
                                </p>
                            </div>
                        @endif

                        <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800">
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div
                                    class="bg-slate-50 dark:bg-slate-900 p-2 border border-slate-100 dark:border-slate-800 text-center">
                                    <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Company</p>
                                    <p class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase truncate"
                                        title="{{ $soldier->company }}">{{ $soldier->company ?: '---' }}</p>
                                </div>
                                <div
                                    class="bg-slate-50 dark:bg-slate-900 p-2 border border-slate-100 dark:border-slate-800 text-center">
                                    <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Platoon</p>
                                    <p class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase truncate"
                                        title="{{ $soldier->platoon }}">{{ $soldier->platoon ?: '---' }}</p>
                                </div>
                                <div
                                    class="bg-slate-50 dark:bg-slate-900 p-2 border border-slate-100 dark:border-slate-800 text-center">
                                    <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Section</p>
                                    <p class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase truncate"
                                        title="{{ $soldier->section }}">{{ $soldier->section ?: '---' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Operational
                                        Unit</p>
                                    <p
                                        class="text-[10px] font-bold text-military-primary dark:text-military-accent uppercase tracking-tight">
                                        {{ $soldier->unit ? $soldier->unit->name : 'Unassigned' }}
                                    </p>
                                </div>
                                <a href="{{ route('admin.soldiers.show', $soldier) }}"
                                    class="p-2 bg-slate-950 text-white hover:bg-red-600 transition-colors shadow-lg active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $soldiers->links() }}
            </div>
        @else
            <div
                class="py-32 bg-emerald-50 dark:bg-emerald-950/20 border-2 border-dashed border-emerald-200 dark:border-emerald-800 text-center space-y-6">
                <div
                    class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/40 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">No Personnel Need
                        Improvement</h3>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest mt-2">All personnel currently
                        meet operational standards.</p>
                </div>
            </div>
        @endif

    </div>
@endsection
