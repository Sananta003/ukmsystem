<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Portal UKM Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; }
        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-20px) rotate(5deg); } }
        .animate-float { animation: float 15s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden text-slate-100" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">

    <div class="fixed top-[-10%] right-[-10%] w-[800px] h-[800px] bg-indigo-600 rounded-full mix-blend-screen filter blur-[150px] opacity-40 animate-float"></div>
    <div class="fixed bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-cyan-600 rounded-full mix-blend-screen filter blur-[120px] opacity-30 animate-float" style="animation-delay: -5s;"></div>

    <div :class="loaded ? 'opacity-100 translate-y-0 scale-100' : 'opacity-0 translate-y-12 scale-95'" class="w-full max-w-md p-4 transition-all duration-1000 ease-out z-10 relative">
        <div class="bg-white/10 backdrop-blur-2xl border border-white/20 rounded-[2.5rem] shadow-2xl shadow-black/50 p-8 sm:p-10 relative overflow-hidden">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 border border-white/20 mb-6 shadow-inner">
                    <i class="fa-solid fa-lock-open text-3xl bg-clip-text text-transparent bg-gradient-to-br from-indigo-400 to-cyan-400"></i>
                </div>
                <h2 class="text-3xl font-black text-white tracking-wide mb-2">Buat Sandi Baru</h2>
                <p class="text-indigo-200/80 text-sm font-medium">Amankan kembali akun Anda dengan sandi baru.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-white/90 ml-1">Alamat Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                        <input type="email" name="email" value="{{ $_GET['email'] ?? old('email') }}" required readonly 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl pl-11 pr-4 py-3.5 text-white/50 focus:outline-none cursor-not-allowed">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-white/90 ml-1">Sandi Baru</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                        <input type="password" name="password" required placeholder="••••••••" 
                            class="w-full bg-white/10 border border-white/20 rounded-2xl pl-11 pr-4 py-3.5 text-white placeholder-white/40 focus:outline-none focus:ring-4 focus:ring-cyan-500/40 focus:border-cyan-500/60 focus:bg-white/20 transition-all duration-300">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-white/90 ml-1">Konfirmasi Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-white/50"></i>
                        <input type="password" name="password_confirmation" required placeholder="••••••••" 
                            class="w-full bg-white/10 border border-white/20 rounded-2xl pl-11 pr-4 py-3.5 text-white placeholder-white/40 focus:outline-none focus:ring-4 focus:ring-cyan-500/40 focus:border-cyan-500/60 focus:bg-white/20 transition-all duration-300">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-400 hover:to-cyan-400 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/50 hover:scale-[1.02] hover:-translate-y-1 mt-4">
                    Simpan Sandi Baru
                </button>
            </form>
        </div>
    </div>
</body>
</html>
