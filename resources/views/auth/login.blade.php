<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Entry | Soldier Management System</title>
    
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
                            primary: '#2F4F3E',   /* Dark Olive Green */
                            secondary: '#1F2937', /* Slate/Gray 800 */
                            accent: '#6B8E23',    /* Olive Drab */
                            bg: '#F5F1E8',        /* Parchment */
                            success: '#15803D',
                            warning: '#D97706',
                            danger: '#B91C1C',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .classic-card {
            background: white;
            border: 1px solid #cbd5e1; /* slate-300 */
            box-shadow: 4px 4px 0px rgba(47, 79, 62, 0.2);
        }
        .btn-military {
            background: #2F4F3E;
            color: white;
            border: 1px solid #1F2937;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.2s;
        }
        .btn-military:hover {
            background: #1F2937;
            box-shadow: 4px 4px 0px #6B8E23;
            transform: translate(-2px, -2px);
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-6 bg-slate-950 overflow-hidden font-sans">
    <!-- Tactical Grid Overlay -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(#6B8E23 1px, transparent 1px); background-size: 32px 32px;"></div>
    
    <div class="relative w-full max-w-[440px] z-10 animate-fade-in">
        <!-- Command Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center mb-6">
                <img src="{{ asset('assets/logos/SAJHSF.png') }}" alt="Logo" class="h-24 w-auto drop-shadow-[0_0_15px_rgba(47,79,62,0.4)]">
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">
                Command <span class="text-military-accent">Portal</span>
            </h1>
            <div class="mt-2 flex items-center justify-center gap-3">
                <div class="h-[1px] w-8 bg-military-accent/40"></div>
                <p class="text-slate-500 font-bold text-[11px] uppercase tracking-widest opacity-60">Strategic Management System</p>
                <div class="h-[1px] w-8 bg-military-accent/40"></div>
            </div>
        </div>

        <!-- Authentication Terminal -->
        <div class="classic-card rounded-none p-10 bg-military-bg relative">
            <!-- Security Identifier -->
            <div class="absolute top-0 right-0 px-4 py-1.5 bg-military-primary text-white text-[10px] font-bold tracking-widest opacity-80">
                VER-A.02
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-8">
                @csrf
                
                @if($errors->any() && false) {{-- Suppressing top alert to show errors below inputs --}}
                    <div class="p-4 bg-military-danger/10 border border-military-danger text-military-danger text-[10px] font-bold uppercase tracking-widest animate-shake">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                <div class="space-y-2">
                    <label for="email" class="text-[12px] font-bold text-military-secondary ml-1 tracking-wide opacity-70">Personnel Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-military-secondary/40 group-focus-within:text-military-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                    </div>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@gmail.com') }}" required
                               class="w-full pl-12 pr-4 py-4 bg-white border @error('email') border-military-danger @else border-slate-300 @enderror rounded-none text-slate-900 text-[14px] font-medium tracking-tight focus:outline-none focus:ring-1 focus:ring-military-primary focus:border-military-primary transition-all shadow-inner"
                               placeholder="admin@management.gov">
                    </div>
                    @error('email')
                        <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1 ml-1 animate-shake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-[12px] font-bold text-military-secondary ml-1 tracking-wide opacity-70">Access Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-military-secondary/40 group-focus-within:text-military-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002-2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-12 pr-4 py-4 bg-white border @error('password') border-military-danger @else border-slate-300 @enderror rounded-none text-slate-900 text-[14px] font-medium tracking-tight focus:outline-none focus:ring-1 focus:ring-military-primary focus:border-military-primary transition-all shadow-inner"
                               placeholder="Password Cipher">
                    </div>
                    @error('password')
                        <p class="text-military-danger text-[9px] font-bold uppercase tracking-tight mt-1 ml-1 animate-shake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer group">
                        <input id="remember" name="remember" type="checkbox" class="hidden peer">
                        <div class="w-5 h-5 border border-slate-300 bg-white peer-checked:bg-military-primary peer-checked:border-military-primary transition-all flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="ml-3 text-[12px] font-bold text-slate-500 group-hover:text-military-secondary transition-colors tracking-tight">Remember this connection</span>
                    </label>
                </div>

                <button type="submit" 
                        class="btn-military w-full py-4 text-[13px] font-bold shadow-lg active:scale-95">
                    Authorize Core Access
                </button>
            </form>
        </div>

        <div class="mt-10 flex items-center justify-between border-t border-slate-800 pt-6">
            <div class="flex items-center gap-3">
                <div class="w-2.5 h-2.5 rounded-full bg-military-success animate-pulse shadow-[0_0_8px_#15803D]"></div>
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest opacity-60">System Ready</span>
            </div>
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 text-slate-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L10 9.503l7.834-4.603a1 1 0 00-1.168-1.6L10 7.497 3.334 3.297a1 1 0 10-1.168 1.603zM10 11.503l-7.834-4.603a1 1 0 00-1.168 1.603l8.418 4.951a1 1 0 001.168 0l8.418-4.951a1 1 0 00-1.168-1.603L10 11.503z" clip-rule="evenodd"></path></svg>
                <span class="text-[11px] font-bold text-slate-700 uppercase tracking-widest font-mono opacity-60">Encrypted Uplink</span>
            </div>
        </div>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.6s cubic-bezier(.36,.07,.19,.97) both;
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>
