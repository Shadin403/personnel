@extends('layouts.admin')

@section('title', 'Personnel Directory')

@section('styles')
<style>
    .tactical-checkbox {
        appearance: none;
        -webkit-appearance: none;
        width: 1.25rem;
        height: 1.25rem;
        background: transparent;
        border: 2px solid #94a3b8;
        border-radius: 4px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-block;
        vertical-align: middle;
    }

    .tactical-checkbox:hover {
        border-color: #f8fafc;
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }

    .tactical-checkbox:checked {
        background: #f1f5f9;
        border-color: #f1f5f9;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .tactical-checkbox:checked::after {
        content: '';
        position: absolute;
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid #0f172a;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    /* Custom style for the dark table header */
    .header-checkbox {
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .header-checkbox:hover {
        border-color: white;
    }
</style>
@endsection

@section('content')
<div class="space-y-8 animate-fade-in pb-20" x-data="{ 
    selectedIds: [], 
    toggleAll() {
        if (this.selectedIds.length === {{ $soldiers->count() }}) {
            this.selectedIds = [];
        } else {
            this.selectedIds = Array.from(document.querySelectorAll('.soldier-checkbox')).map(el => el.value);
        }
    }
}">

    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-300">
        <div class="space-y-1">
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Personnel Directory [সদস্য তালিকা]</h2>
            <p class="text-[12px] font-semibold text-slate-500 tracking-wide">Registry Assets &bull; Strategic Database Mode</p>
        </div>
        <div class="flex items-center gap-3">
            <div x-show="selectedIds.length > 0" x-transition class="flex items-center gap-3 pr-4 border-r border-slate-300">
                <span class="text-[11px] font-black text-military-primary uppercase tracking-widest" x-text="selectedIds.length + ' Selected'"></span>
                <form action="{{ route('admin.soldiers.bulk-action') }}" method="POST">
                    @csrf
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="submit" name="action" value="delete" 
                            @click.prevent="if(confirm('Operational Warning: Are you sure you want to PERMANENTLY remove ' + selectedIds.length + ' soldiers from the registry?')) $el.form.submit()"
                            class="px-4 py-2 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition-all shadow-sm flex items-center gap-2 border border-red-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Selected
                    </button>
                </form>
            </div>
            <a href="{{ route('admin.soldiers.create') }}" class="btn-military flex items-center gap-2 shadow-md active:scale-95 px-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                New Enrollment
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="classic-card p-6 bg-white border border-slate-300">
        <form action="{{ route('admin.soldiers.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="md:col-span-1">
                <label class="text-[11px] font-bold text-military-secondary uppercase tracking-widest mb-2 block opacity-70">Search Records [নাম / নং / পদবী]</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name / Service No. / Rank" 
                           class="w-full pl-10 pr-4 py-2.5 bg-military-bg border border-slate-200 rounded-none text-[13px] font-medium tracking-tight focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all shadow-inner">
                </div>
            </div>
            
            <div>
                <label class="text-[11px] font-bold text-military-secondary uppercase tracking-widest mb-2 block opacity-70">Classification</label>
                <select name="user_type" class="w-full px-4 py-2.5 bg-military-bg border border-slate-200 rounded-none text-[13px] font-medium tracking-tight focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer shadow-inner">
                    <option value="">All Classifications</option>
                    <option value="CO" {{ request('user_type') == 'CO' ? 'selected' : '' }}>Command Officer (CO)</option>
                    <option value="JCO" {{ request('user_type') == 'JCO' ? 'selected' : '' }}>Junior Officer (JCO)</option>
                    <option value="Staff" {{ request('user_type') == 'Staff' ? 'selected' : '' }}>Staff Personnel</option>
                </select>
            </div>

            <div>
                <label class="text-[11px] font-bold text-military-secondary uppercase tracking-widest mb-2 block opacity-70">Company [কোম্পানী]</label>
                <select name="company" class="w-full px-4 py-2.5 bg-military-bg border border-slate-200 rounded-none text-[13px] font-medium tracking-tight focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer shadow-inner">
                    <option value="">All Companies</option>
                    @foreach($companies as $coy)
                    <option value="{{ $coy->name }}" {{ request('company') == $coy->name ? 'selected' : '' }}>{{ $coy->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-military-primary text-white text-[12px] font-bold uppercase tracking-widest border border-military-secondary hover:bg-military-secondary transition-all shadow-md">
                    Apply Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="classic-card overflow-hidden border border-slate-300">
        <div class="overflow-x-auto bg-white">
            <table class="w-full text-left">
                <thead class="bg-military-primary text-white">
                    <tr>
                        <th class="px-4 py-5 border-b border-military-secondary text-center w-12">
                            <input type="checkbox" @click="toggleAll()" :checked="selectedIds.length === {{ $soldiers->count() }} && {{ $soldiers->count() }} > 0"
                                   class="tactical-checkbox header-checkbox">
                        </th>
                        <th class="px-4 py-5 text-[11px] font-bold uppercase tracking-widest opacity-90 border-b border-military-secondary text-center w-12">Pos</th>
                        <th class="px-4 py-5 text-[11px] font-bold uppercase tracking-widest opacity-90 border-b border-military-secondary text-center w-16">Image</th>
                        <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest opacity-90 border-b border-military-secondary text-left">Name [নাম]</th>
                        <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest opacity-90 border-b border-military-secondary text-left">Service No [সেনা নং]</th>
                        <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest opacity-90 border-b border-military-secondary text-left">Coy. & Appt [কোম্পানী ও নিয়োগ]</th>
                        <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest opacity-90 border-b border-military-secondary text-left">Readiness</th>
                        <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest opacity-90 border-b border-military-secondary text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($soldiers as $soldier)
                    <tr class="hover:bg-military-bg/30 transition-colors group">
                        <td class="px-4 py-5 text-center">
                            <input type="checkbox" :value="{{ $soldier->id }}" x-model="selectedIds"
                                   class="tactical-checkbox border-slate-300">
                        </td>
                        <td class="px-4 py-5 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-military-primary text-[11px] font-black border border-slate-200 shadow-inner">
                                {{ $soldier->sort_order ?? 0 }}
                            </span>
                        </td>
                        <td class="px-4 py-5">
                            <div class="w-12 h-12 rounded-none border border-slate-200 overflow-hidden bg-slate-50 p-0.5 group-hover:border-military-primary transition-all mx-auto shadow-sm">
                                <img src="{{ $soldier->photo_url }}" alt="" class="w-full h-full object-cover transition-all">
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-[13px] font-bold text-slate-900 tracking-tight">{{ $soldier->name }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-[13px] font-bold text-military-primary tracking-wide font-mono">{{ $soldier->number }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-[12px] font-bold text-military-secondary tracking-tight">{{ $soldier->rank }}</p>
                            <p class="text-[11px] font-medium text-slate-500 mt-0.5">{{ $soldier->company }} &bull; {{ $soldier->appointment }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @php 
                                $statusStyle = match($soldier->overall_status) {
                                    'Excellent' => 'text-white bg-military-success border-military-success',
                                    'Good' => 'text-white bg-military-primary border-military-primary',
                                    'Average' => 'text-white bg-military-warning border-military-warning',
                                    default => 'text-white bg-military-danger border-military-danger'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] font-bold border tracking-wide {{ $statusStyle }}">
                                {{ $soldier->overall_status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.soldiers.show', $soldier) }}" class="px-4 py-2 bg-military-primary/5 border border-military-primary/20 text-military-primary text-[10px] font-black uppercase tracking-widest hover:bg-military-primary hover:text-white transition-all shadow-sm">
                                    View Personnel
                                </a>
                                <a href="{{ route('admin.soldiers.edit', $soldier) }}" class="px-4 py-2 bg-amber-500/5 border border-amber-500/20 text-amber-600 text-[10px] font-black uppercase tracking-widest hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                    Edit Profile
                                </a>
                                <form action="{{ route('admin.soldiers.destroy', $soldier) }}" method="POST" onsubmit="return confirm('Personnel De-listing Confirmation: Are you sure?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center italic text-slate-400">No personnel found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($soldiers->hasPages())
        <div class="px-8 py-6 bg-military-bg border-t border-slate-300">
            {{ $soldiers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
