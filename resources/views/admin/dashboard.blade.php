@extends('layouts.admin')

@section('title', 'Digital Training Card')

@section('styles')
    <style>
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 12px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1e3a2f;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        [x-cloak] {
            display: none !important;
        }

        .tactical-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(30, 58, 47, 0.1);
        }

        .dark .tactical-glass {
            background: rgba(15, 23, 42, 0.8);
            border-color: rgba(132, 204, 22, 0.1);
        }

        .card-zoom {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s;
        }

        .card-zoom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(30, 58, 47, 0.2);
        }

        .hero-title {
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            user-select: none;
        }

        .dark .hero-title {
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .level-indicator {
            font-family: monospace;
            letter-spacing: 0.3em;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .appointment-content p {
            margin: 0 !important;
            padding: 0 !important;
        }

        .appointment-content ul,
        .appointment-content ol {
            display: inline-block;
            text-align: left;
        }
    </style>
@endsection

@section('content')
    <div class="min-h-[80vh] flex flex-col justify-center relative" x-data="hierarchicalExplorer()">

        <!-- Navigation Controls -->
        <div class="fixed top-20 left-10 lg:left-72 right-10 z-40 flex items-center justify-between pointer-events-none">
            <div class="pointer-events-auto" x-show="level > 1" x-cloak x-transition>
                <button @click="back()"
                    class="flex items-center gap-2 px-6 py-2.5 bg-military-primary text-white text-[11px] font-black uppercase tracking-[0.2em] hover:bg-military-secondary transition-all shadow-xl active:scale-95 border border-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    BACK
                </button>
            </div>
            <div class="pointer-events-auto ml-auto">
                <a href="{{ route('admin.soldiers.create') }}"
                    class="flex items-center gap-2 px-6 py-2.5 bg-military-accent text-slate-900 text-[11px] font-black uppercase tracking-[0.2em] hover:bg-white transition-all shadow-xl active:scale-95 border border-military-accent/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    ENROLL PERSONNEL
                </a>
            </div>
        </div>

        <!-- Level 1: Main Interface -->
        <div x-show="level === 1" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="text-center flex flex-col items-center justify-center space-y-10">
            <div class="space-y-6">
                <img src="{{ asset('assets/logos/SAJHSF.png') }}" alt="Logo"
                    class="h-40 w-auto animate-float mx-auto filter drop-shadow-[0_0_15px_rgba(0,0,0,0.1)] dark:drop-shadow-[0_0_20px_rgba(255,255,255,0.1)]">
                <div class="space-y-2">
                    <p
                        class="text-military-primary dark:text-military-accent text-lg font-black uppercase tracking-[0.6em] opacity-80">
                        Digital Training Card</p>
                    <h1 @click="nextLevel(2)"
                        class="hero-title text-8xl md:text-[10rem] font-black text-military-secondary dark:text-white cursor-pointer hover:text-military-primary dark:hover:text-military-accent transition-all duration-500 transform hover:scale-105 tracking-tighter leading-none">
                        9 E Bengal
                    </h1>
                </div>
            </div>
            <div class="animate-bounce mt-12">
                <p class="text-slate-400 text-[11px] font-black uppercase tracking-[0.6em]">Tap "9E Bengal" to Proceed</p>
                <svg class="w-6 h-6 mx-auto text-slate-300 mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <!-- Level 2: Companies -->
        <div x-show="level === 2" x-cloak x-transition:enter="transition ease-out duration-500"
            class="max-w-7xl mx-auto w-full px-6">
            <div class="text-center mb-20 space-y-4">
                <p class="text-military-primary text-xs font-black level-indicator tracking-[0.5em] uppercase opacity-50">
                    Level 02 &bull; Company</p>
                <h2 class="text-5xl font-black text-military-secondary dark:text-white uppercase tracking-tight">Company
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <template x-for="coy in companies" :key="coy.id">
                    <div @click="selectCoy(coy)"
                        class="tactical-glass px-2 py-10 text-center cursor-pointer card-zoom flex flex-col items-center justify-center space-y-6 min-h-[300px] border-t-4 border-t-military-primary group rounded-none">
                        <div
                            class="w-20 h-20 bg-military-primary/5 rounded-none flex items-center justify-center text-military-primary group-hover:bg-military-primary group-hover:text-white transition-all duration-500 shadow-inner">
                            <span class="text-2xl font-black" x-text="coy.name.split(' ')[0][0]"></span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-military-secondary dark:text-white uppercase tracking-tight"
                                x-text="coy.name"></h3>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-2 appointment-content"
                                x-html="coy.appointment"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Level 3: Platoons -->
        <div x-show="level === 3" x-cloak x-transition:enter="transition ease-out duration-500"
            class="max-w-7xl mx-auto w-full px-6">
            <div class="text-center mb-20 space-y-4">
                <p class="text-military-accent text-xs font-black level-indicator tracking-[0.5em] uppercase opacity-50"
                    x-text="'Level 03 &bull; ' + selectedCoy?.name"></p>
                <h2 class="text-5xl font-black text-military-secondary dark:text-white uppercase tracking-tight">Select
                    Platoon</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <template x-for="pl in platoons" :key="pl.id">
                    <div @click="selectPl(pl)"
                        class="tactical-glass px-2 py-10 text-center cursor-pointer card-zoom flex flex-col items-center justify-center space-y-6 min-h-[300px] border-t-4 border-t-military-accent group rounded-none">
                        <div
                            class="w-20 h-20 bg-military-accent/5 rounded-none flex items-center justify-center text-military-accent group-hover:bg-military-accent group-hover:text-white transition-all duration-500 shadow-inner">
                            <span class="text-2xl font-black" x-text="pl.name.split(' ')[0]"></span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-military-secondary dark:text-white uppercase tracking-tight"
                                x-text="pl.name"></h3>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-2 appointment-content"
                                x-html="pl.appointment"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Level 4: Sections -->
        <div x-show="level === 4" x-cloak x-transition:enter="transition ease-out duration-500"
            class="max-w-7xl mx-auto w-full px-6">
            <div class="text-center mb-20 space-y-4">
                <p class="text-amber-500 text-xs font-black level-indicator tracking-[0.5em] uppercase opacity-50"
                    x-text="'Level 04 &bull; ' + selectedPl?.name"></p>
                <h2 class="text-5xl font-black text-military-secondary dark:text-white uppercase tracking-tight">Select
                    Section</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <template x-for="sec in sections" :key="sec.id">
                    <div @click="selectSec(sec)"
                        class="tactical-glass px-2 py-10 text-center cursor-pointer card-zoom flex flex-col items-center justify-center space-y-6 min-h-[300px] border-t-4 border-t-amber-500 group rounded-none">
                        <div
                            class="w-20 h-20 bg-amber-500/5 rounded-none flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500 shadow-inner">
                            <span class="text-2xl font-black"
                                x-text="sec.name.split(' ')[1] || sec.name.split(' ')[0]"></span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-military-secondary dark:text-white uppercase tracking-tight"
                                x-text="sec.name"></h3>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-2 appointment-content"
                                x-html="sec.appointment"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Level 5: Data Table -->
        <div x-show="level === 5" x-cloak x-transition:enter="transition ease-out duration-500"
            class="max-w-7xl mx-auto w-full px-6 pb-20">
            <div class="text-center mb-12 space-y-4">
                <p class="text-military-primary text-xs font-black level-indicator tracking-[0.5em] uppercase opacity-50"
                    x-text="'Level 05 &bull; ' + selectedSec?.name"></p>
                <h2 class="text-4xl font-black text-military-secondary dark:text-white uppercase tracking-tight">Section
                    Nominaroll</h2>
                <div class="flex items-center justify-center gap-3">
                    <span
                        class="px-3 py-1 bg-military-primary/10 text-military-primary text-[10px] font-bold uppercase tracking-widest"
                        x-text="selectedCoy?.name"></span>
                    <span
                        class="px-3 py-1 bg-military-accent/10 text-military-accent text-[10px] font-bold uppercase tracking-widest"
                        x-text="selectedPl?.name"></span>
                    <span class="px-3 py-1 bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase tracking-widest"
                        x-text="selectedSec?.name"></span>
                </div>
            </div>

            <div
                class="tactical-glass overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 rounded-none">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-military-secondary text-white">
                                <th class="px-8 py-6 text-[11px] font-black uppercase tracking-[0.3em]">Photo</th>
                                <th class="px-8 py-6 text-[11px] font-black uppercase tracking-[0.3em]">Service No</th>
                                <th class="px-8 py-6 text-[11px] font-black uppercase tracking-[0.3em]">Rank & Name</th>
                                <th class="px-8 py-6 text-[11px] font-black uppercase tracking-[0.3em]">Appointment</th>
                                <th class="px-8 py-6 text-[11px] font-black uppercase tracking-[0.3em] text-right">Dossier
                                    Access</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white/50 dark:bg-slate-900/30">
                            <template x-for="sol in personnel" :key="sol.id">
                                <tr class="hover:bg-military-bg/30 dark:hover:bg-slate-800/50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div
                                            class="w-16 h-16 rounded-none border-2 border-slate-200 dark:border-slate-700 p-0.5 bg-white dark:bg-slate-800 overflow-hidden group-hover:border-military-primary transition-all shadow-md">
                                            <img :src="sol.img"
                                                class="w-full h-full object-cover transition-all duration-500 scale-110 group-hover:scale-100">
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 font-mono text-[14px] font-bold text-military-secondary dark:text-slate-300 tracking-tight"
                                        x-text="sol.number"></td>
                                    <td class="px-8 py-6">
                                        <div class="space-y-1">
                                            <p class="text-[15px] font-black text-military-primary dark:text-military-accent uppercase tracking-tight"
                                                x-text="sol.name"></p>
                                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest"
                                                x-text="sol.rank"></p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span
                                            class="inline-flex px-4 py-1.5 text-[10px] font-black bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase tracking-widest border border-slate-300 dark:border-slate-700"
                                            x-text="sol.appointment"></span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a :href="sol.profile_url"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-military-primary text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-military-secondary transition-all shadow-lg active:scale-95 group-hover:-translate-x-1">
                                                <span>View Profile</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                            <a :href="sol.edit_url"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-[10px] font-black uppercase tracking-[0.2em] hover:bg-amber-600 transition-all shadow-lg active:scale-95 group-hover:-translate-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                <span>EDIT</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <template x-if="personnel.length === 0">
                    <div class="p-32 text-center space-y-6 opacity-30">
                        <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <p class="text-[16px] font-black uppercase tracking-[0.4em]">Strategic Assessment Pending &bull; No
                            Records</p>
                    </div>
                </template>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function hierarchicalExplorer() {
            return {
                nodes: @json($treeNodes),
                level: 1,
                selectedCoy: null,
                selectedPl: null,
                selectedSec: null,

                get companies() {
                    return this.nodes.filter(n => n.unit_type === 'company');
                },
                get platoons() {
                    if (!this.selectedCoy) return [];
                    return this.nodes.filter(n => n.pid == this.selectedCoy.id && n.unit_type === 'platoon');
                },
                get sections() {
                    if (!this.selectedPl) return [];
                    return this.nodes.filter(n => n.pid == this.selectedPl.id && n.unit_type === 'section');
                },
                get personnel() {
                    if (!this.selectedSec) return [];
                    return this.nodes.filter(n => n.pid == this.selectedSec.id);
                },

                nextLevel(lv) {
                    this.level = lv;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                selectCoy(coy) {
                    this.selectedCoy = coy;
                    this.nextLevel(3);
                },

                selectPl(pl) {
                    this.selectedPl = pl;
                    this.nextLevel(4);
                },

                selectSec(sec) {
                    this.selectedSec = sec;
                    this.nextLevel(5);
                },

                back() {
                    if (this.level > 1) {
                        this.level--;
                        if (this.level < 5) this.selectedSec = null;
                        if (this.level < 4) this.selectedPl = null;
                        if (this.level < 3) this.selectedCoy = null;
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                }
            }
        }
    </script>
@endsection
