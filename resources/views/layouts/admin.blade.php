<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Soldier Management') }} - @yield('title', 'Admin')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        military: {
                            primary: '#2F4F3E',
                            secondary: '#1F2937',
                            accent: '#6B8E23',
                            bg: '#F5F1E8',
                            text: '#1F2937',
                            'text-light': '#E5E7EB',
                            warning: '#D97706',
                            danger: '#B91C1C',
                            success: '#15803D',
                        },
                        slate: {
                            950: '#0a0a0a',
                        }
                    },
                    fontFamily: {
                        sans: ['Roboto', 'Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #2F4F3E;
            border-radius: 0;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #1F2937;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .classic-card {
            background: white;
            border: 1px solid #d1d5db;
            box-shadow: 2px 2px 0 0 rgba(47, 79, 62, 0.05);
        }

        .classic-card-header {
            background: #2F4F3E;
            color: white;
            padding: 0.75rem 1.5rem;
            border-bottom: 2px solid #1F2937;
        }

        .btn-military {
            background: #2F4F3E;
            color: white;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            font-size: 13px;
            border: 1px solid #1F2937;
            transition: all 0.2s;
        }

        .btn-military:hover {
            background: #1F2937;
            transform: translateY(-1px);
        }

        .bg-parchment {
            background-color: #F5F1E8;
        }

        .text-military {
            color: #1F2937;
        }

        .border-military {
            border-color: #2F4F3E;
        }
    </style>
    @yield('styles')
</head>

<body class="h-full overflow-hidden bg-parchment font-sans text-military antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-military-secondary text-white transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 border-r border-black/20 shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="flex items-center gap-4 h-16 bg-slate-950 px-6 border-b border-white/5">
                    <img src="{{ asset('assets/logos/SAJHSF.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="text-lg font-bold tracking-tight text-white whitespace-nowrap">
                        Management <span class="text-military-accent font-extrabold">System</span>
                    </span>
                </div>

                <!-- User Info -->
                <div class="px-6 py-6 border-b border-white/5 bg-black/20">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-none bg-military-primary flex items-center justify-center text-white font-bold border border-white/10 shadow-lg text-base">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-gray-100 tracking-tight">
                                {{ Auth::user()->name ?? 'System Admin' }}</p>
                            <p class="text-[11px] text-military-accent font-bold tracking-wide uppercase opacity-70">
                                Authorized Administrator</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                    <p class="px-4 text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-3 opacity-40">
                        Operational Center</p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-military-primary text-white shadow-lg translate-x-1' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <p class="px-4 pt-8 text-[11px] font-bold uppercase tracking-widest text-slate-500 mb-3 opacity-40">
                        Force Management</p>
                    <a href="{{ route('admin.soldiers.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium transition-all duration-200 group {{ request()->routeIs('admin.soldiers.index') ? 'bg-military-primary text-white shadow-lg translate-x-1' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Personnel Directory
                    </a>

                    <a href="{{ route('admin.soldiers.create') }}"
                        class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium transition-all duration-200 group {{ request()->routeIs('admin.soldiers.create') ? 'bg-military-primary text-white shadow-lg translate-x-1' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                        New Enrollment
                    </a>
                </nav>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-white/5 bg-black/40">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full gap-3 px-4 py-3 text-[12px] font-bold text-red-500 hover:bg-red-500/10 transition-all duration-200">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Terminate Connection
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full bg-parchment overflow-hidden relative">
            <!-- Top Navbar -->
            <header
                class="flex items-center justify-between h-14 px-6 bg-white border-b border-slate-300 lg:px-8 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-military-primary hover:text-military-secondary lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-[13px] font-bold text-military-primary tracking-tight">@yield('title', 'Admin Panel')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <span
                        class="text-[12px] font-medium text-slate-400 tracking-tight">{{ now()->format('D, d M Y') }}</span>
                    <div class="h-4 w-px bg-slate-200"></div>
                    <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[11px] font-bold text-emerald-700 tracking-tight">Active Operations</span>
                    </div>
                </div>
            </header>

            <!-- Scrollable Page Content -->
            <div class="flex-1 overflow-y-auto p-6 lg:p-10 custom-scrollbar">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 flex items-center gap-4 animate-fade-in shadow-sm"
                        x-data="{ show: true }" x-show="show">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span
                            class="flex-1 text-[11px] font-bold uppercase tracking-widest">{{ session('success') }}</span>
                        <button @click="show = false"
                            class="text-emerald-400 hover:text-emerald-700 font-bold text-lg">&times;</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-military-secondary/40 lg:hidden"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
    </div>

    @yield('scripts')
</body>

</html>
