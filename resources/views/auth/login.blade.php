@php
    $bgUrl = asset('assets/images/login-bg.png');
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Authentication | Soldier Management System</title>
    
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
                    },
                    backdropBlur: {
                        'xs': '2px',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }

        .glass-card {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .btn-tactical {
            background: #1e3a2f;
            color: white;
            padding: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            transition: all 0.3s;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-tactical:hover {
            background: #2F4F3E;
            box-shadow: 0 0 20px rgba(132, 204, 22, 0.4);
            transform: translateY(-2px);
            border-color: #84cc16;
        }

        .input-tactical {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s;
        }

        .input-tactical:focus {
            border-color: #84cc16;
            background: rgba(0, 0, 0, 0.5);
            outline: none;
            box-shadow: 0 0 15px rgba(132, 204, 22, 0.2);
        }

        .text-glow {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .gold-glow {
            text-shadow: 0 0 15px rgba(251, 191, 36, 0.5);
        }

        @keyframes scanline {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }

        .scanline::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(132, 204, 22, 0.05) 50%);
            background-size: 100% 4px;
            pointer-events: none;
        }
    </style>
</head>
<body class="h-full bg-slate-950 font-sans text-white overflow-hidden relative scanline">
    
    <!-- Background Image with Overlay -->
    <div class="fixed inset-0 z-0">
        <img src="{{ $bgUrl }}" alt="Military Background" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
        <div class="absolute inset-0 bg-slate-950/20 backdrop-brightness-75"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 h-full flex flex-col items-center justify-center p-6 space-y-12 animate-fade-in">
        
        <!-- Branding Section -->
        <div class="text-center space-y-6">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('assets/logos/SAJHSF.png') }}" alt="Logo" class="h-32 w-auto filter drop-shadow-[0_0_20px_rgba(255,255,255,0.2)]">
            </div>
            
            <div class="space-y-2">
                <h2 class="text-military-accent text-lg font-black uppercase tracking-[0.5em] text-glow">Charging Nine</h2>
                <h1 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">Digital Training Card</h1>
                <p class="text-military-gold text-sm font-bold uppercase tracking-[0.3em] gold-glow">Raised During Liberation War</p>
            </div>
        </div>

        <!-- Login Container -->
        <div class="w-full max-w-md glass-card p-10 space-y-8 animate-slide-up">
            <div class="border-l-4 border-military-accent pl-4">
                <h3 class="text-xl font-bold uppercase tracking-widest text-white">Personnel Login</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 opacity-60">Authorize Core Sector Access</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Military Email ID</label>
                    <div class="relative group">
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@gmail.com') }}" required
                               class="w-full pl-4 pr-4 py-4 input-tactical text-sm tracking-wide font-medium"
                               placeholder="service.no@9ebengal.gov">
                    </div>
                    @error('email')
                        <p class="text-military-danger text-[9px] font-bold uppercase tracking-widest mt-1 animate-pulse">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Access Cypher</label>
                    <div class="relative group">
                        <input type="password" id="password" name="password" required
                               class="w-full pl-4 pr-4 py-4 input-tactical text-sm tracking-wide font-medium"
                               placeholder="••••••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer group">
                        <input id="remember" name="remember" type="checkbox" class="hidden peer">
                        <div class="w-4 h-4 border border-slate-600 bg-black/40 peer-checked:bg-military-accent peer-checked:border-military-accent transition-all flex items-center justify-center">
                            <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="ml-3 text-[10px] font-bold text-slate-400 group-hover:text-white transition-colors uppercase tracking-widest">Hold Authorization</span>
                    </label>
                </div>

                <button type="submit" class="btn-tactical w-full shadow-2xl active:scale-[0.98]">
                    Initiate Connection
                </button>
            </form>
        </div>

        <!-- Footer Stats -->
        <div class="flex items-center gap-12 text-white/40">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-military-accent animate-pulse shadow-[0_0_8px_#84cc16]"></div>
                <span class="text-[9px] font-black uppercase tracking-[0.2em]">Secure Server Online</span>
            </div>
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002-2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <span class="text-[9px] font-black uppercase tracking-[0.2em]">AES-256 Encryption Active</span>
            </div>
        </div>
    </div>

    <!-- UI Animations -->
    <style>
        .animate-fade-in { animation: fadeIn 1s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .animate-slide-up { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</body>
</html>
