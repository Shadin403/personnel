@extends('layouts.admin')

@section('title', 'Improvement Registry')

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

        .tactical-checkbox {
            appearance: none;
            -webkit-appearance: none;
            display: inline-block;
            width: 22px;
            height: 22px;
            background-color: white;
            border: 2px solid #94a3b8;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            vertical-align: middle;
        }

        .dark .tactical-checkbox {
            background-color: #1e293b;
            border-color: #475569;
        }

        .tactical-checkbox:hover {
            transform: scale(1.1);
            border-color: #ef4444;
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.2);
        }

        .tactical-checkbox:checked {
            background-color: #ef4444;
            border-color: #ef4444;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        .tactical-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }

        .tactical-checkbox:focus {
            outline: none;
        }
    </style>
@endsection

@section('content')
<div class="space-y-8 animate-fade-in pb-20" 
     x-data="{ 
        selectedIds: [], 
        isProcessing: false,
        allIds: {{ json_encode($soldiers->pluck('id')) }},
        toggleAll() {
            if (this.selectedIds.length === this.allIds.length) {
                this.selectedIds = [];
            } else {
                this.selectedIds = [...this.allIds];
            }
        },
        toggleSelection(id) {
            if (this.selectedIds.includes(id)) {
                this.selectedIds = this.selectedIds.filter(i => i !== id);
            } else {
                this.selectedIds.push(id);
            }
        },
        submitBulk(action) {
            if (this.selectedIds.length === 0) return;

            const executeSubmission = () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.soldiers.bulk-action') }}';
                
                const csrfToken = document.querySelector('meta[name=\'csrf-token\']').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = action;
                form.appendChild(actionInput);

                this.selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                if (action !== 'delete') this.isProcessing = true;
                form.submit();
                if (action !== 'delete') setTimeout(() => this.isProcessing = false, 5000);
            };

            if (action === 'delete') {
                Swal.fire({
                    title: '<span class=\'text-lg font-black uppercase tracking-widest text-[#0f172a]\'>Strategic Warning</span>',
                    html: '<span class=\'text-xs font-bold text-slate-500 uppercase tracking-widest\'>Are you sure you want to PERMANENTLY remove ' + this.selectedIds.length + ' soldiers?</span>',
                    icon: 'warning',
                    iconColor: '#ef4444',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#334155',
                    confirmButtonText: 'CONFIRM DELETION',
                    cancelButtonText: 'ABORT'
                }).then((result) => {
                    if (result.isConfirmed) {
                        executeSubmission();
                    }
                });
            } else {
                executeSubmission();
            }
        }
     }">
    
    <!-- Global Loader Overlay -->
    <template x-if="isProcessing">
        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-military-primary/80 backdrop-blur-md">
            <div class="text-center space-y-6">
                <div class="relative w-24 h-24 mx-auto">
                    <div class="absolute inset-0 border-4 border-white/20 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-military-accent rounded-full animate-spin border-t-transparent"></div>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xl font-black text-white uppercase tracking-[0.3em]">Processing Records</h3>
                    <p class="text-[10px] font-bold text-military-accent uppercase tracking-widest animate-pulse">Generating Secure PDF Artifacts...</p>
                </div>
            </div>
        </div>
    </template>

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-300">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full text-[10px] font-black uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Critical Training Alert
            </div>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                Improvement <span class="text-red-600">Registry</span></h2>
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.4em]">Personnel below operational readiness thresholds [সদ্য তালিকা]</p>
        </div>
        <div class="text-right">
            <p class="text-[32px] font-black text-red-600 leading-none">{{ $soldiers->total() }}</p>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pending Remediation</p>
        </div>
    </div>

    <!-- Category & Selection Controls Bar -->
    <div class="classic-card p-0 bg-white overflow-hidden flex flex-wrap items-center justify-between">
        <div class="flex flex-wrap border-r border-slate-200">
            <a href="{{ route('admin.soldiers.weak', ['category' => 'all']) }}"
                class="px-8 py-5 text-[12px] font-black uppercase tracking-wider transition-all border-b-2 {{ request('category') == 'all' || !request('category') ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
                ALL PERSONNEL
            </a>
            <a href="{{ route('admin.soldiers.weak', ['category' => 'IP50']) }}" 
               class="px-8 py-5 text-[12px] font-black uppercase tracking-wider transition-all border-b-2 {{ request('category') == 'IP50' ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
                IPFT FAIL Roll
            </a>
            <a href="{{ route('admin.soldiers.weak', ['category' => 'RT']) }}" 
               class="px-8 py-5 text-[12px] font-black uppercase tracking-wider transition-all border-b-2 {{ request('category') == 'RT' ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
                RET FAIL Roll
            </a>
            <a href="{{ route('admin.soldiers.weak', ['category' => 'Overweight']) }}" 
               class="px-8 py-5 text-[12px] font-black uppercase tracking-wider transition-all border-b-2 {{ request('category') == 'Overweight' ? 'border-red-600 text-red-600 bg-red-50/50' : 'border-transparent text-slate-400 hover:text-slate-600 hover:bg-slate-50' }}">
                OVERWEIGHT Roll
            </a>
        </div>

        @if ($soldiers->count() > 0)
        <div class="px-8 py-5 bg-slate-50 flex items-center gap-6">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" 
                       @click="toggleAll()" 
                       :checked="selectedIds.length === allIds.length && allIds.length > 0"
                       class="tactical-checkbox">
                <span class="text-[11px] font-black uppercase tracking-widest text-slate-600 group-hover:text-red-600 transition-colors">Select Page Personnel</span>
            </label>

            <button @click="submitBulk('registry-pdf')" 
                    class="ml-auto inline-flex items-center gap-2 px-6 py-2 bg-slate-900 hover:bg-red-600 text-white rounded font-black text-[10px] uppercase tracking-widest transition-all hover:shadow-lg hover:shadow-red-600/20 active:scale-95 disabled:opacity-50 disabled:pointer-events-none"
                    :disabled="selectedIds.length === 0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Secure PDF Nominal Roll
            </button>
        </div>
        @endif
    </div>

    <!-- Personnel Grid(s) -->
    @if ($soldiers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($soldiers as $soldier)
                @include('admin.soldiers.partials.weak-card', ['soldier' => $soldier])
            @endforeach
        </div>

        <div class="mt-12">
            {{ $soldiers->links() }}
        </div>
    @else
        <!-- Premium Empty State -->
        <div class="py-32 classic-card bg-emerald-50/30 border-2 border-dashed border-emerald-200 dark:border-emerald-800 text-center space-y-6">
            <div class="w-20 h-20 bg-emerald-100 dark:bg-emerald-900/40 rounded-full flex items-center justify-center mx-auto shadow-inner">
                <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="max-w-md mx-auto">
                <h3 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Operational Excellence</h3>
                 <p class="text-[12px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-3 leading-relaxed"> No personnel currently identified under remediation criteria. All units report status "NORMAL".</p>
            </div>
            <div class="flex justify-center pt-4">
                <span class="px-4 py-2 bg-emerald-600 text-white text-[10px] font-black uppercase tracking-widest shadow-lg">Verified Operational Registry</span>
            </div>
        </div>
    @endif

    <!-- Strategic Bulk Action Bar -->
    <div x-show="selectedIds.length > 0" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-20 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-20 opacity-0"
         class="fixed bottom-12 left-1/2 -translate-x-1/2 z-50 w-full max-w-2xl px-4">
        <div class="bg-slate-900 dark:bg-slate-800 text-white p-5 rounded-none shadow-2xl border border-white/10 flex items-center justify-between backdrop-blur-xl ring-1 ring-white/20">
            <div class="flex items-center gap-5">
                <div class="w-12 h-12 bg-red-600 rounded-none flex items-center justify-center font-black animate-pulse shadow-lg border border-red-400/20">
                    <span x-text="selectedIds.length" class="text-xl"></span>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40">Tactical Selection</p>
                    <p class="text-sm font-bold tracking-tight">Generate Bulk Records</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button @click="submitBulk('download')" 
                        class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-lg active:scale-95 flex items-center gap-2 border border-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download PDF
                </button>
                <button @click="submitBulk('print')" 
                        class="px-8 py-3 bg-slate-700 hover:bg-slate-600 text-white text-[10px] font-black uppercase tracking-[0.2em] transition-all border border-white/10 active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print All
                </button>
                <button @click="selectedIds = []" class="p-3 hover:bg-red-600 transition-colors bg-white/5 border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
