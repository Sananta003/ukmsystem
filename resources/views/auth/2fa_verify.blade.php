<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi 2FA - Portal UKM Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 50% { box-shadow: 0 0 20px 10px rgba(16, 185, 129, 0); } }
        .animate-glow { animation: pulse-glow 2s infinite; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-slate-100" x-data="{ otp: '' }">

    <div class="fixed inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-emerald-600/20 rounded-full mix-blend-screen filter blur-[150px]"></div>

    <div class="w-full max-w-md bg-white/10 backdrop-blur-2xl border border-white/20 rounded-[2.5rem] shadow-2xl shadow-black/50 p-10 text-center relative z-10">
        
        <div class="w-20 h-20 mx-auto rounded-full bg-white/10 border border-emerald-500/50 flex items-center justify-center mb-6 animate-glow">
            <i class="fa-solid fa-lock text-3xl text-emerald-400"></i>
        </div>
        
        <h2 class="text-3xl font-black text-white tracking-wide mb-2">Verifikasi 2 Langkah</h2>
        <p class="text-emerald-100/70 text-sm mb-8">Buka aplikasi Authenticator Anda dan masukkan 6 digit kode yang tertera.</p>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-200 text-sm p-3 rounded-xl mb-6">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('2fa.verify.post') }}" method="POST">
            @csrf
            <div class="mb-8">
                <input type="text" name="one_time_password" required maxlength="6" pattern="\d{6}" x-model="otp" placeholder="••••••" autocomplete="off"
                    class="w-full bg-white/5 border-b-2 border-emerald-500/50 px-4 py-4 text-center text-4xl tracking-[0.5em] text-white focus:outline-none focus:border-emerald-400 focus:bg-white/10 transition-all font-mono rounded-t-xl">
            </div>
            
            <button type="submit" :disabled="otp.length !== 6" :class="otp.length === 6 ? 'from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 shadow-emerald-500/50 hover:-translate-y-1' : 'from-slate-600 to-slate-700 opacity-50 cursor-not-allowed'" class="w-full bg-gradient-to-r text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-lg">
                Verifikasi
            </button>
        </form>

        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="text-sm text-slate-400 hover:text-white transition-colors">Batal & Kembali ke Login</button>
        </form>
    </div>
</body>
</html>
