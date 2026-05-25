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
<body class="bg-slate-50 dark:bg-slate-900 min-h-screen flex items-center justify-center p-4 transition-colors duration-500" x-data="{ darkMode: document.documentElement.classList.contains('dark') }" x-init="$watch('darkMode', val => { if(val){ document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">

    <!-- Dark Mode Toggle Absolute Top Right -->
    <button @click="darkMode = !darkMode" class="absolute top-4 right-4 sm:top-8 sm:right-8 w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 bg-white dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all shadow-md">
        <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
    </button>

    <div class="max-w-md w-full bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors duration-300 relative z-10">
        <div class="bg-blue-600 dark:bg-indigo-950 p-6 text-center transition-colors duration-300">
            <div class="w-12 h-12 bg-white dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-indigo-400 text-xl mx-auto mb-3 shadow-sm transition-colors duration-300">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">Bergabung dengan UKM</h2>
            <p class="text-blue-100 dark:text-indigo-200 text-sm mt-1">Daftarkan diri Anda untuk mengembangkan minat dan bakat.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="p-6 md:p-8 space-y-5">
            @csrf
            
            @if($errors->any())
                <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1 transition-colors">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda" class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1 transition-colors">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@kampus.com" class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
            </div>

            <!-- Alert Info UKM -->
            <div class="bg-blue-50 dark:bg-indigo-900/20 border border-blue-200 dark:border-indigo-800 rounded-xl p-4 flex items-center gap-3 transition-colors">
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-indigo-900/50 text-blue-600 dark:text-indigo-400 flex items-center justify-center shrink-0 transition-colors">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-blue-600 dark:text-indigo-400 font-semibold uppercase tracking-wider mb-0.5 transition-colors">Mendaftar untuk bergabung dengan</p>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 transition-colors">{{ $targetUkm->nama_ukm }}</h3>
                </div>
            </div>

            <!-- Hidden input untuk ukm_id -->
            <input type="hidden" name="ukm_id" value="{{ request('ukm_id') }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1 transition-colors">Buat Password</label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white dark:bg-slate-900/50 text-slate-800 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 transition-colors">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-indigo-600 dark:hover:bg-indigo-500 text-white font-bold py-3 rounded-lg transition-colors shadow-md shadow-blue-200 dark:shadow-none mt-2">
                Daftar & Masuk
            </button>
            
            <p class="text-center text-sm text-gray-500 dark:text-slate-400 mt-4 transition-colors">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 dark:text-indigo-400 font-semibold hover:underline transition-colors">Login disini</a>
            </p>
        </form>
    </div>

</body>
</html>