<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota UKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom animations */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(20px) rotate(-5deg); }
        }
        
        .animate-float { animation: float 15s ease-in-out infinite; }
        .animate-float-reverse { animation: float-reverse 20s ease-in-out infinite; }
    </style>
    <script>
        // FOUC prevention for dark mode
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        tailwind.config = { darkMode: 'class' };
    </script>
</head>
<body class="min-h-screen flex flex-col relative overflow-x-hidden bg-slate-50 dark:bg-[#0f172a] text-slate-900 dark:text-slate-100 p-4 py-10 transition-colors duration-500" x-data="{ darkMode: document.documentElement.classList.contains('dark') }" x-init="$watch('darkMode', val => { if(val){ document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">

    <!-- Dark Mode Toggle Absolute Top Right -->
    <div class="fixed top-6 right-6 z-50">
        <button @click="darkMode = !darkMode" class="w-12 h-12 rounded-full flex items-center justify-center text-slate-500 hover:text-sky-500 dark:text-slate-400 dark:hover:text-amber-400 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md hover:bg-white dark:hover:bg-slate-700 transition-all shadow-lg border border-slate-200 dark:border-slate-700">
            <i class="fa-solid text-xl" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
        </button>
    </div>

    <!-- Animated Mesh Gradient Background Elements (PNC Logo Colors) -->
    <div class="fixed top-[-10%] left-[-10%] w-[800px] h-[800px] bg-sky-300 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[150px] opacity-50 dark:opacity-40 animate-float"></div>
    <div class="fixed top-[20%] right-[-10%] w-[600px] h-[600px] bg-slate-300 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[120px] opacity-50 dark:opacity-40 animate-float-reverse" style="animation-delay: -5s;"></div>
    <div class="fixed bottom-[-10%] left-[20%] w-[700px] h-[700px] bg-amber-300 dark:bg-pink-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[150px] opacity-40 dark:opacity-30 animate-float" style="animation-delay: -10s;"></div>


    <div class="m-auto max-w-md w-full bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/50 dark:border-slate-700/50 overflow-hidden transition-colors duration-300 relative z-10">
        
        <div class="bg-slate-800 dark:bg-slate-900 p-8 text-center transition-colors duration-300 relative overflow-hidden">
            <!-- decorative gradient inside header -->
            <div class="absolute inset-0 bg-gradient-to-r from-sky-500/20 to-amber-500/20 mix-blend-overlay pointer-events-none"></div>
            
            <a href="{{ url('/') }}" class="inline-flex w-14 h-14 bg-white/10 dark:bg-slate-800 rounded-full items-center justify-center text-sky-400 text-2xl mx-auto mb-4 shadow-sm border border-white/10 hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-user-plus"></i>
            </a>
            <h2 class="text-2xl font-bold text-white relative z-10">Bergabung dengan UKM</h2>
            <p class="text-slate-300 text-sm mt-1 relative z-10">Daftarkan diri Anda untuk mengembangkan minat dan bakat.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="p-6 md:p-8 space-y-5">
            @csrf
            
            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-sm p-4 rounded-xl border border-red-200 dark:border-red-500/30">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1 transition-colors">Nama Lengkap</label>
                <div class="relative group">
                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-sky-500 transition-colors"></i>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda" class="w-full border border-slate-200 dark:border-slate-600 rounded-2xl pl-11 pr-4 py-3 focus:ring-4 focus:ring-sky-500/20 focus:border-sky-500 outline-none bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 transition-all duration-300">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1 transition-colors">Alamat Email</label>
                <div class="relative group">
                    <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-sky-500 transition-colors"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@kampus.com" class="w-full border border-slate-200 dark:border-slate-600 rounded-2xl pl-11 pr-4 py-3 focus:ring-4 focus:ring-sky-500/20 focus:border-sky-500 outline-none bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 transition-all duration-300">
                </div>
            </div>

            <!-- Alert Info UKM -->
            <div class="bg-sky-50 dark:bg-slate-800/50 border border-sky-100 dark:border-slate-700 rounded-2xl p-4 flex items-center gap-4 transition-colors">
                <div class="w-12 h-12 rounded-full bg-sky-100 dark:bg-slate-700 text-sky-600 dark:text-sky-400 flex items-center justify-center shrink-0 transition-colors">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-[11px] text-sky-600 dark:text-sky-400 font-bold uppercase tracking-wider mb-0.5 transition-colors">Mendaftar untuk UKM</p>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 transition-colors">{{ $targetUkm->nama_ukm }}</h3>
                </div>
            </div>

            <!-- Hidden input untuk ukm_id -->
            <input type="hidden" name="ukm_id" value="{{ request('ukm_id') }}">

            <div class="space-y-1.5">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1 transition-colors">Buat Password</label>
                <div class="relative group">
                    <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-sky-500 transition-colors"></i>
                    <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full border border-slate-200 dark:border-slate-600 rounded-2xl pl-11 pr-4 py-3 focus:ring-4 focus:ring-sky-500/20 focus:border-sky-500 outline-none bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 transition-all duration-300">
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-sky-500 to-amber-500 hover:from-sky-400 hover:to-amber-400 text-white font-bold py-3.5 rounded-2xl transition-all duration-300 shadow-lg shadow-sky-500/30 hover:shadow-sky-500/50 hover:-translate-y-1 mt-4">
                Daftar & Masuk
            </button>
            
            <div class="relative flex items-center py-2 mt-4">
                <div class="flex-grow border-t border-slate-200 dark:border-white/20"></div>
                <span class="flex-shrink-0 mx-4 text-slate-400 dark:text-white/50 text-xs font-semibold uppercase tracking-wider">Atau</span>
                <div class="flex-grow border-t border-slate-200 dark:border-white/20"></div>
            </div>

            <a href="{{ route('auth.google', ['ukm_id' => request('ukm_id')]) }}" class="w-full bg-white dark:bg-white/5 hover:bg-slate-50 dark:hover:bg-white/10 border border-slate-200 dark:border-white/10 text-slate-700 dark:text-white font-bold py-3.5 rounded-2xl flex items-center justify-center gap-3 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none mt-4">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Daftar dengan Google
            </a>
            
            <p class="text-center text-sm text-slate-500 dark:text-slate-400 mt-6 font-medium transition-colors">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-sky-600 dark:text-sky-400 font-bold hover:text-sky-700 hover:underline transition-colors">Login disini</a>
            </p>
        </form>
    </div>

</body>
</html>