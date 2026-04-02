@extends('layouts.admin')

@section('title', 'Personnel Directory')

@section('content')
<div class="space-y-8 animate-fade-in pb-20">
    <!-- Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-300">
        <div class="space-y-1">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight uppercase">Personnel Directory [সদস্য তালিকা]</h2>
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">Global Registry Assets &bull; Live Database Mode</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.soldiers.create') }}" class="btn-military flex items-center gap-2 shadow-md active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                New Enrollment
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="classic-card p-6 bg-white border border-slate-300">
        <form action="{{ route('admin.soldiers.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="md:col-span-1">
                <label class="text-[9px] font-bold text-military-secondary uppercase tracking-[0.2em] mb-2 block">Search Node [নাম / নং / পদবী]</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="NAME [নাম] / NO. [নং] / RANK" 
                           class="w-full pl-10 pr-4 py-2.5 bg-military-bg border border-slate-200 rounded-none text-[11px] font-bold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all">
                </div>
            </div>
            
            <div>
                <label class="text-[9px] font-bold text-military-secondary uppercase tracking-[0.2em] mb-2 block">Force Classification</label>
                <select name="user_type" class="w-full px-4 py-2.5 bg-military-bg border border-slate-200 rounded-none text-[11px] font-bold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer">
                    <option value="">ALL CLASSIFICATIONS</option>
                    <option value="CO" {{ request('user_type') == 'CO' ? 'selected' : '' }}>COMMAND OFFICER (CO)</option>
                    <option value="JCO" {{ request('user_type') == 'JCO' ? 'selected' : '' }}>JUNIOR OFFICER (JCO)</option>
                    <option value="Staff" {{ request('user_type') == 'Staff' ? 'selected' : '' }}>STAFF PERSONNEL</option>
                </select>
            </div>

            <div>
                <label class="text-[9px] font-bold text-military-secondary uppercase tracking-[0.2em] mb-2 block">Coy. [কোম্পানী]</label>
                <select name="company" class="w-full px-4 py-2.5 bg-military-bg border border-slate-200 rounded-none text-[11px] font-bold uppercase tracking-wider focus:outline-none focus:ring-1 focus:ring-military-primary focus:bg-white transition-all appearance-none cursor-pointer">
                    <option value="">ALL COYs</option>
                    @php 
                        $coyList = ['Alpha', 'Bravo', 'Charlie', 'Delta', 'Echo', 'HQ'];
                    @endphp
                    @foreach($coyList as $coy)
                    <option value="{{ $coy }}" {{ request('company') == $coy ? 'selected' : '' }}>{{ strtoupper($coy) }} COY.</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-military-primary text-white text-[10px] font-bold uppercase tracking-[0.2em] border border-military-secondary hover:bg-military-secondary transition-all shadow-md">
                    Apply Filter
                </button>
                <a href="{{ route('admin.soldiers.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all border border-slate-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="classic-card overflow-hidden border border-slate-300">
        <div class="overflow-x-auto bg-white">
            <table class="w-full text-left">
                <thead class="bg-military-primary text-white">
                    <tr>
                        <th class="px-4 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-center w-12">S/N</th>
                        <th class="px-4 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-center w-16">Image</th>
                        <th class="px-6 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-left">Name [নাম]</th>
                        <th class="px-6 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-left">Service No [সেনা নং]</th>
                        <th class="px-6 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-left">Coy. & Appt [কোম্পানী ও নিয়োগ]</th>
                        <th class="px-6 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-left">Class</th>
                        <th class="px-6 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-left">Readiness</th>
                        <th class="px-6 py-5 text-[9px] font-bold uppercase tracking-[0.2em] opacity-90 border-b border-military-secondary text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($soldiers as $soldier)
                    <tr class="hover:bg-military-bg/30 transition-colors group">
                        <td class="px-4 py-5 text-center">
                            <span class="text-[11px] font-bold text-slate-400 font-mono">{{ $loop->iteration }}</span>
                        </td>
                        <td class="px-4 py-5">
                            <div class="w-12 h-12 rounded-none border border-slate-200 overflow-hidden bg-slate-50 p-0.5 group-hover:border-military-primary transition-all mx-auto">
                                <img src="{{ $soldier->photo_url }}" alt="" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all">
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-[11px] font-bold text-slate-900 uppercase tracking-tight">{{ $soldier->name }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="space-y-0.5">
                                <p class="text-[11px] font-bold text-military-primary uppercase tracking-widest font-mono">{{ $soldier->number }}</p>
                                <p class="text-[8px] font-semibold text-slate-400 uppercase tracking-tighter">{{ $soldier->batch }} BATCH</p>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-[11px] font-bold text-military-secondary uppercase tracking-tighter">{{ $soldier->rank }}</p>
                            <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest">{{ strtoupper($soldier->company) }} COY. &bull; APPT: {{ strtoupper($soldier->appointment) }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="space-y-1.5">
                                <span class="bg-military-bg text-military-primary text-[9px] font-bold px-2 py-0.5 border border-military-primary/20 uppercase tracking-widest">
                                    {{ $soldier->user_type }}
                                    @if($soldier->is_active)
                                        <span class="ml-1 text-[8px] opacity-60">(ACTIVE)</span>
                                    @endif
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @php 
                                $statusStyle = match($soldier->overall_status) {
                                    'Excellent' => 'text-white bg-military-success border-military-success shadow-[0_0_8px_rgba(21,128,61,0.2)]',
                                    'Good' => 'text-white bg-military-primary border-military-primary shadow-[0_0_8px_rgba(47,79,62,0.2)]',
                                    'Average' => 'text-white bg-military-warning border-military-warning shadow-[0_0_8px_rgba(217,119,6,0.2)]',
                                    default => 'text-white bg-military-danger border-military-danger shadow-[0_0_8px_rgba(185,28,28,0.2)]'
                                };
                            @endphp
                            <div class="flex flex-col gap-2 w-32">
                                <span class="inline-flex items-center px-3 py-1 rounded-none text-[9px] font-bold border uppercase tracking-widest {{ $statusStyle }}">
                                    {{ $soldier->overall_status }}
                                </span>
                                <div class="w-full h-1 bg-slate-100 rounded-none overflow-hidden border border-slate-200">
                                    @php
                                        $width = match($soldier->overall_status) {
                                            'Excellent' => '100%',
                                            'Good' => '75%',
                                            'Average' => '50%',
                                            default => '25%'
                                        };
                                        $barColor = match($soldier->overall_status) {
                                            'Excellent' => 'bg-military-success',
                                            'Good' => 'bg-military-primary',
                                            'Average' => 'bg-military-warning',
                                            default => 'bg-military-danger'
                                        };
                                    @endphp
                                    <div class="h-full {{ $barColor }} transition-all duration-1000 shadow-inner" style="width: {{ $width }}"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 transition-all duration-300">
                                <a href="{{ route('admin.soldiers.download-trg', $soldier) }}" class="px-4 py-2 bg-military-secondary text-white hover:bg-military-primary transition-all font-bold text-[9px] uppercase tracking-widest shadow-md">
                                    GEN REPORT
                                </a>
                                <a href="{{ route('admin.soldiers.edit', $soldier) }}" class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-military-primary hover:border-military-primary transition-all shadow-sm" title="Modify Node">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.soldiers.destroy', $soldier) }}" method="POST" class="inline" onsubmit="return confirm('CRITICAL: Permanent termination of personnel node record. Proceed?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-white border border-slate-200 text-slate-300 hover:text-military-danger hover:border-military-danger transition-all shadow-sm" title="Purge Record">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-8 py-20 text-center">
                            <div class="max-w-xs mx-auto space-y-4">
                                <div class="w-16 h-16 bg-military-bg border border-slate-100 rounded-none flex items-center justify-center mx-auto text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 uppercase tracking-widest italic">Zero Signal Lock</h4>
                                <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-tight">Verify registry coordinates or database uplink status.</p>
                            </div>
                        </td>
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

@section('styles')
<style>
    .pagination { @apply flex items-center justify-center gap-1; }
    .page-item { @apply inline-block; }
    .page-link { @apply flex items-center justify-center w-10 h-10 bg-white border border-slate-300 rounded-none text-[10px] font-bold text-military-secondary hover:bg-military-primary hover:text-white hover:border-military-primary transition-all shadow-sm; }
    .active .page-link { @apply bg-military-primary border-military-primary text-white shadow-md; }
    .disabled .page-link { @apply opacity-30 cursor-not-allowed hover:bg-white hover:text-military-secondary hover:border-slate-300; }
</style>
@endsection
