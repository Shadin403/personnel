@extends('layouts.admin')

@section('title', 'Organizational Units')

@section('content')
<div class="animate-fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-black text-military-primary tracking-tight uppercase">Organizational Units</h2>
            <p class="text-[11px] font-bold text-military-accent uppercase tracking-widest mt-1 opacity-70">
                Command & Control Structure
            </p>
        </div>
        <a href="{{ route('admin.units.create') }}" class="btn-military inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Establish New Unit
        </a>
    </div>

    <div class="classic-card overflow-hidden">
        <div class="classic-card-header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/10 border border-white/20">
                    <svg class="w-4 h-4 text-military-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-[11px] font-bold uppercase tracking-[0.2em]">Deployment Manifest</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Unit Name</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Type</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Parent Unit</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Appointment</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($units as $unit)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="text-[13px] font-bold text-military-primary group-hover:text-military-accent transition-colors">
                                {{ $unit->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-none border 
                                @if($unit->type == 'battalion') bg-slate-900 text-white border-slate-900
                                @elseif($unit->type == 'company') bg-military-primary text-white border-military-primary
                                @elseif($unit->type == 'platoon') bg-military-accent/10 text-military-accent border-military-accent/20
                                @else bg-slate-100 text-slate-600 border-slate-200 @endif">
                                {{ $unit->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-[12px] font-medium text-slate-500">
                            {{ $unit->parent->name ?? '--' }}
                        </td>
                        <td class="px-6 py-4 text-[12px] font-medium text-slate-500">
                            {{ $unit->appointment ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.units.edit', $unit) }}" class="p-2 text-slate-400 hover:text-military-primary transition-colors border border-transparent hover:border-slate-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" onsubmit="return confirm('WARNING: Strategic dissolution of this unit requested. Proceed with termination?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors border border-transparent hover:border-red-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">No organizational units currently established.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($units->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $units->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
