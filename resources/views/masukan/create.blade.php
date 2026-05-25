<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Masukan - Portal SIM-UKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
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
<body class="bg-slate-50 dark:bg-slate-900 flex flex-col min-h-screen transition-colors duration-500" x-data="{ darkMode: document.documentElement.classList.contains('dark') }" x-init="$watch('darkMode', val => { if(val){ document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">

    <!-- Navbar -->
    <nav class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-gray-100 dark:border-slate-800 sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logopnc.png') }}" alt="Logo Kampus" class="h-10 w-auto object-contain">
                    <div class="hidden sm:flex flex-col border-l-2 border-gray-100 dark:border-slate-700 pl-3">
                        <span class="font-bold text-lg text-slate-800 dark:text-slate-100 leading-none">Portal SIM-UKM</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Beri Masukan</span>
                    </div>
                </a>
                <div class="flex items-center gap-4">
                    <button @click="darkMode = !darkMode" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition-all shadow-inner">
                        <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                    </button>
                    <a href="{{ url('/') }}" class="text-gray-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Kembali</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center py-12 px-4 relative overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse z-0"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse z-0" style="animation-delay: 2s;"></div>

        <div class="max-w-2xl w-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border border-white/60 dark:border-slate-700 rounded-3xl shadow-2xl p-8 sm:p-12 relative z-10">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <i class="fa-regular fa-comment-dots text-3xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100">Beri Masukan</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Bantu kami mengembangkan Portal SIM-UKM menjadi lebih baik.</p>
            </div>

            <form action="{{ route('masukan.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="Masukkan nama Anda">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500" placeholder="nama@email.com">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Masukan / Pesan</label>
                    <textarea name="pesan" rows="5" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 resize-none" placeholder="Tuliskan saran, kritik, atau temuan bug di sini..."></textarea>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-700 dark:to-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 focus:ring-4 focus:ring-blue-500/50">
                    Kirim Masukan <i class="fa-solid fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-400 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} Portal Mahasiswa. By Sananta Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>
