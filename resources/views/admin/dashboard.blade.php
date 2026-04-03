@extends('layouts.admin')

@section('title', 'Battalion (9E Bengal) | Force Navigator')

@section('content')
<div class="space-y-8" x-data="{ currentLevel: {{ $viewData['level'] }} }">
    
    <!-- 🎖️ Force Navigator Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-military-dark border border-military-primary p-6 rounded-lg shadow-lg">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-military-primary rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-wide uppercase">Force Navigator</h1>
                <p class="text-xs text-military-accent uppercase font-bold mt-1 tracking-widest">9th East Bengal Regiment (9E Bengal)</p>
            </div>
        </div>
        
        <div class="flex flex-col items-end">
            <div class="flex gap-4">
                <div class="text-right">
                    <div class="text-white font-bold text-lg">{{ $stats['total'] }}</div>
                    <div class="text-[10px] text-military-accent uppercase font-bold tracking-widest">Total Personnel</div>
                </div>
                <div class="text-right border-l border-military-primary pl-4 ml-4">
                    <div class="text-military-success font-bold text-lg">{{ $stats['active'] }}</div>
                    <div class="text-[10px] text-military-accent uppercase font-bold tracking-widest">Active Duty</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🍞 Breadcrumb -->
    <div class="bg-military-dark border border-military-secondary px-6 py-3 rounded shadow-inner flex items-center text-xs font-bold uppercase tracking-widest gap-2">
        <a href="{{ route('admin.dashboard') }}" class="text-military-accent hover:text-white transition-colors">9E BENGAL (BN)</a>
        @if($currentCompany)
            <svg class="w-3 h-3 text-military-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('admin.dashboard', ['company' => $currentCompany]) }}" class="text-military-accent hover:text-white transition-colors">{{ $currentCompany }}</a>
        @endif
        @if($currentPlatoon)
            <svg class="w-3 h-3 text-military-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('admin.dashboard', ['company' => $currentCompany, 'platoon' => $currentPlatoon]) }}" class="text-military-accent hover:text-white transition-colors">{{ $currentPlatoon }}</a>
        @endif
        @if($currentSection)
            <svg class="w-3 h-3 text-military-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-military-primary">{{ $currentSection }}</span>
        @endif
    </div>

    <!-- 🗺️ Drill-Down Interface -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        @if($viewData['type'] !== 'personnel')
            @foreach($viewData['items'] as $item)
                <a href="{{ route('admin.dashboard', array_merge(request()->query(), [$viewData['type'] => $item])) }}" 
                   class="group bg-military-dark border border-military-secondary p-8 rounded-lg text-center hover:border-military-primary hover:bg-military-primary transition-all duration-300 transform hover:-translate-y-1 shadow-md hover:shadow-xl">
                    <div class="w-16 h-16 bg-military-primary flex items-center justify-center rounded-lg mx-auto mb-4 group-hover:bg-white transition-colors">
                        <svg class="w-8 h-8 text-white group-hover:text-military-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($viewData['type'] == 'company')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            @endif
                        </svg>
                    </div>
                    <div class="text-white font-bold tracking-widest text-sm uppercase mb-1">{{ $item }}</div>
                    <div class="text-[10px] text-military-accent uppercase font-bold tracking-[0.2em]">Select to Drill Down</div>
                </a>
            @endforeach
        @endif
    </div>

    <!-- 👥 Final Personnel List (Level 5) -->
    @if($viewData['type'] == 'personnel')
        <div class="bg-military-dark border border-military-primary rounded-lg overflow-hidden shadow-2xl">
            <div class="bg-military-primary px-6 py-4 flex justify-between items-center bg-opacity-90">
                <h3 class="text-white font-bold uppercase tracking-widest text-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Personnel Strength - {{ $currentSection }}
                </h3>
                <span class="bg-white text-military-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase">{{ $viewData['items']->count() }} Souls</span>
            </div>
            
            @if($viewData['items']->isEmpty())
                <div class="p-12 text-center text-military-accent font-bold uppercase tracking-widest opacity-50">
                    No Personnel assigned to this section.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-military-secondary bg-opacity-50 border-b border-military-primary">
                                <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest text-military-accent">Service No [সেনা নং]</th>
                                <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest text-military-accent">Name [নাম]</th>
                                <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest text-military-accent">Rank [পদবী]</th>
                                <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest text-military-accent">IPFT Status</th>
                                <th class="px-6 py-5 text-[11px] font-bold uppercase tracking-widest text-military-accent text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-military-secondary bg-opacity-20">
                            @foreach($viewData['items'] as $s)
                                <tr class="hover:bg-military-primary hover:bg-opacity-10 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-white">{{ $s->number }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-white">{{ $s->name }}</div>
                                        <div class="text-[10px] text-military-accent font-bold mt-0.5">{{ $s->name_bn }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 bg-military-primary bg-opacity-20 border border-military-primary text-military-primary text-[10px] font-bold uppercase rounded">
                                            {{ $s->rank }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($s->ipft_1_status == 'Pass' && $s->ipft_2_status == 'Pass')
                                            <span class="text-military-success font-bold text-[10px] uppercase tracking-tighter">PASS (BNL 1&2)</span>
                                        @else
                                            <span class="text-military-accent font-bold text-[10px] uppercase tracking-tighter">PENDING</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.soldiers.show', $s->id) }}" class="inline-flex items-center gap-2 bg-military-primary hover:bg-white hover:text-military-primary px-3 py-1.5 rounded transition-all transform hover:scale-105 shadow-md">
                                            <span class="text-[10px] font-black uppercase tracking-tighter">View Dossier</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7-7 7M3 19V5"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
