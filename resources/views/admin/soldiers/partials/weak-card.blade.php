<div @click="toggleSelection({{ $soldier->id }})"
    class="weak-card p-6 shadow-xl transition-all hover:-translate-y-1 relative overflow-hidden group cursor-pointer"
    :class="selectedIds.includes({{ $soldier->id }}) ? 'ring-2 ring-red-600 bg-red-50/10' : ''">
    <!-- Selection Checkbox -->
    <div class="absolute left-4 top-4 z-10">
        <input type="checkbox" x-model="selectedIds" value="{{ $soldier->id }}" @click.stop class="tactical-checkbox">
    </div>

    @if ($soldier->weight_status == 'Obese' || $soldier->weight_status == 'Obese (WHR)')
        <div class="absolute -right-12 -top-12 w-24 h-24 bg-red-600/10 rotate-45 flex items-end justify-center pb-2">
            <span class="text-[10px] font-black text-red-600 uppercase tracking-tighter">OBESE</span>
        </div>
    @endif

    <div class="flex items-start gap-4 pt-4">
        <div
            class="w-20 h-24 bg-slate-100 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 p-0.5 overflow-hidden ring-4 ring-slate-100 dark:ring-slate-900 group-hover:ring-red-100 transition-all">
            <img src="{{ $soldier->photo_url }}"
                class="w-full h-full object-cover group-hover:grayscale-0 transition-all">
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
                @if ($soldier->ipft_biannual_1 == 'Fail' || $soldier->ipft_biannual_1 == 'Failed')
                    <span class="failure-tag">IPFT-1 FAIL</span>
                @endif
                @if ($soldier->ipft_biannual_2 == 'Fail' || $soldier->ipft_biannual_2 == 'Failed')
                    <span class="failure-tag">IPFT-2 FAIL</span>
                @endif

                @php
                    $hasRtFail =
                        ((int) $soldier->shoot_total < 180 && (int) $soldier->shoot_total > 0) ||
                        str_contains(json_encode($soldier->firing_records), '"status":"Fail"') ||
                        str_contains(json_encode($soldier->night_firing_records), '"status":"Fail"');
                @endphp
                @if ($hasRtFail)
                    <span class="failure-tag">RET FAIL</span>
                @endif

                @if ($soldier->weight_status != 'Normal' && $soldier->weight_status != 'N/A')
                    <span
                        class="failure-tag {{ str_contains($soldier->weight_status, 'Obese') ? 'bg-red-600 text-white border-0' : '' }}">
                        {{ $soldier->weight_status }} ({{ $soldier->weight }} KG)
                    </span>
                @endif

                @if (strtolower($soldier->speed_march) == 'fail')
                    <span class="failure-tag">SPD MARCH FAIL</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Obesity Details Row (Auto-calculated) -->
    @if ($soldier->weight_status != 'Normal')
        <div
            class="mt-6 p-4 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 space-y-2 shadow-inner relative overflow-hidden">
            @php
                $extraWeight = $soldier->weight - $soldier->standard_weight;
            @endphp
            @if ($extraWeight > 0)
                <div
                    class="absolute right-0 top-0 px-3 py-1 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest shadow-lg">
                    +{{ number_format($extraWeight, 1) }} KG EXTRA
                </div>
            @endif
            <div class="flex justify-between items-center text-[9px] font-black uppercase tracking-[0.1em]">
                <span class="text-blue-600 dark:text-blue-400">Required:
                    {{ number_format($soldier->standard_weight, 1) }} KG</span>
                <span class="text-slate-400">Allowed:
                    {{ number_format($soldier->standard_weight + $soldier->weight_allowance, 1) }} KG</span>
            </div>
            <div class="relative w-full bg-slate-200 dark:bg-slate-800 h-1.5 rounded-none overflow-hidden">
                @php
                    $limit = $soldier->standard_weight + $soldier->weight_allowance;
                    $percent = min(100, ($soldier->weight / max(1, $limit)) * 100);
                    $targetPercent = ($soldier->standard_weight / max(1, $limit)) * 100;
                @endphp
                <div class="absolute inset-0 bg-blue-600/20" style="width: {{ $targetPercent }}%"></div>
                <div class="h-full bg-red-600 relative z-10" style="width: {{ $percent }}%"></div>
            </div>
        </div>
    @endif

    <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800">
        <div class="grid grid-cols-3 gap-2 mb-4">
            <div class="bg-slate-50 dark:bg-slate-900 p-2 border border-slate-100 dark:border-slate-800 text-center">
                <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Company</p>
                <p class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase truncate"
                    title="{{ $soldier->company }}">{{ $soldier->company ?: '---' }}</p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900 p-2 border border-slate-100 dark:border-slate-800 text-center">
                <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Platoon</p>
                <p class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase truncate"
                    title="{{ $soldier->platoon }}">{{ $soldier->platoon ?: '---' }}</p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900 p-2 border border-slate-100 dark:border-slate-800 text-center">
                <p class="text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Section</p>
                <p class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase truncate"
                    title="{{ $soldier->section }}">{{ $soldier->section ?: '---' }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="space-y-0.5">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Battalion</p>
                <p
                    class="text-[10px] font-bold text-military-primary dark:text-military-accent uppercase tracking-tight">
                    {{ $soldier->battalion_name }}
                </p>
            </div>
            <a href="{{ route('admin.soldiers.show', $soldier) }}" @click.stop
                class="p-2 bg-slate-950 text-white hover:bg-red-600 transition-colors shadow-lg active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</div>
