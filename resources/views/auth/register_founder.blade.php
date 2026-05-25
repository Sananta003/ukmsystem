<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan UKM Baru - Portal Kampus</title>
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
<body class="bg-slate-50 dark:bg-slate-900 flex items-center justify-center min-h-screen py-10 transition-colors duration-500" x-data="{ darkMode: document.documentElement.classList.contains('dark') }" x-init="$watch('darkMode', val => { if(val){ document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">

    <!-- Dark Mode Toggle Absolute Top Right -->
    <button @click="darkMode = !darkMode" class="absolute top-4 right-4 sm:top-8 sm:right-8 w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 bg-white dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all shadow-md">
        <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
    </button>

    <div class="max-w-md w-full mx-4 relative z-10">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-indigo-600 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200 dark:shadow-none transition-colors">
                <i class="fa-solid fa-rocket text-white dark:text-indigo-400 text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-slate-100 transition-colors">Inisiator UKM Baru</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm transition-colors">Buat akun untuk mengajukan proposal pendirian Unit Kegiatan Mahasiswa yang baru.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 transition-colors duration-300">
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="ukm_id" value="">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1 transition-colors">Nama Lengkap (Calon Ketua)</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso" class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1 transition-colors">Email Kampus / Aktif</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="mahasiswa@kampus.ac.id" class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1 transition-colors">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-lg p-4 flex gap-3 text-sm text-indigo-700 dark:text-indigo-400 mt-2 transition-colors">
                    <i class="fa-solid fa-circle-info mt-0.5"></i>
                    <p>Setelah mendaftar, Anda akan diarahkan ke Dashboard untuk mengisi formulir pengajuan Visi & Misi UKM Baru.</p>
                </div>

                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600 dark:hover:bg-indigo-500 text-white rounded-lg font-bold transition-colors mt-4 shadow-md dark:shadow-none">
                    Daftar & Lanjutkan Pengajuan
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
             <a href="{{ url('/') }}" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 text-sm font-medium transition-colors"><i class="fa-solid fa-arrow-left mr-1"></i> Batal & Kembali</a>
        </div>
    </div>

</body>
</html>