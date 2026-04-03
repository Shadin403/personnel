@php
    $bgUrl = asset('assets/images/login-bg.png');
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Authentication | Soldier Management System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        military: {
                            primary: '#2F4F3E',
                            secondary: '#0f172a',
                            accent: '#84cc16',
                            gold: '#fbbf24',
                            danger: '#ef4444',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar for overflow cases */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #020617;
        }

        ::-webkit-scrollbar-thumb {
            background: #2F4F3E;
            border-radius: 10px;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-tactical {
            background: linear-gradient(135deg, #1e3a2f 0%, #2F4F3E 100%);
            border: 1px solid rgba(132, 204, 22, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-tactical:hover {
            box-shadow: 0 0 25px rgba(132, 204, 22, 0.4);
            border-color: #84cc16;
            transform: translateY(-2px);
        }

        .input-tactical {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .input-tactical:focus {
            border-color: #84cc16;
            box-shadow: 0 0 15px rgba(132, 204, 22, 0.15);
        }

        @keyframes scanline {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(100%);
            }
        }

        .scanline::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(132, 204, 22, 0.03) 50%);
            background-size: 100% 4px;
            pointer-events: none;
            z-index: 1;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-950 font-sans text-white overflow-y-auto overflow-x-hidden relative scanline">

    <div class="fixed inset-0 z-0">
        <img src="{{ $bgUrl }}" alt="Military Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/50 to-slate-950"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col items-center justify-start lg:justify-center p-4 md:p-8">

        <div class="w-full max-w-4xl flex flex-col items-center text-center mb-8 mt-4 lg:mt-0">
            <div class="mb-6">
                <img src="{{ asset('assets/logos/SAJHSF.png') }}" alt="Logo"
                    class="h-20 md:h-28 lg:h-32 w-auto filter drop-shadow-[0_0_15px_rgba(132,204,22,0.3)]">
            </div>

            <div class="space-y-2">
                <h2 class="text-[10px] md:text-xs font-black text-military-accent uppercase tracking-[0.4em]">
                    {{ $appearance['login_brand_top'] ?? 'CHARGING NINE' }}
                </h2>

                <p class="text-[10px] md:text-xs font-black text-military-accent uppercase tracking-[0.4em]">
                    {{ $appearance['login_brand_bottom'] ?? 'RAISED DURING LIBERATION WAR' }}
                </p>
                <h1
                    class="text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tighter uppercase">
                    DIGITAL TRAINING CARD
                </h1>
            </div>
        </div>

        <div
            class="w-full max-w-[400px] glass-card rounded-xl p-8 md:p-10 shadow-2xl relative overflow-hidden group mb-8">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-military-accent shadow-[0_0_15px_#84cc16]"></div>

            <div class="mb-8">
                <h3 class="text-xl md:text-2xl font-black text-white uppercase tracking-tight">Personnel Login</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Authorize Core Sector
                    Access</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">User ID</label>
                    <input type="email" name="email" value="{{ old('email', 'admin@gmail.com') }}" required
                        class="w-full px-4 py-3.5 rounded-lg input-tactical text-sm font-medium focus:outline-none transition-all"
                        placeholder="service.no@9ebengal.gov">
                    @error('email')
                        <p class="text-military-danger text-[10px] font-bold uppercase mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3.5 rounded-lg input-tactical text-sm font-medium focus:outline-none transition-all"
                        placeholder="••••••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="hidden peer">
                        <div
                            class="w-4 h-4 border border-slate-600 bg-black/40 peer-checked:bg-military-accent peer-checked:border-military-accent transition-all flex items-center justify-center rounded-sm">
                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="4">
                                <path d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span
                            class="ml-2 text-[10px] font-bold text-slate-400 group-hover:text-white transition-colors uppercase tracking-widest">Remember
                            Me</span>
                    </label>
                </div>

                <button type="submit"
                    class="btn-tactical w-full py-4 rounded-lg text-xs font-black uppercase tracking-[0.2em] text-white">
                    Login
                </button>
            </form>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-12 text-white/40 pb-8">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-military-accent animate-pulse"></div>
                <span class="text-[9px] font-black uppercase tracking-widest">System Online</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002-2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
                <span class="text-[9px] font-black uppercase tracking-widest">AES-256 Encrypted</span>
            </div>
        </div>
    </div>

</body>

</html>
