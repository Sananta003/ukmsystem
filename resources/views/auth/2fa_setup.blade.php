<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup 2FA - Portal UKM Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-slate-100">

    <div class="fixed top-[-10%] right-[-10%] w-[800px] h-[800px] bg-emerald-600 rounded-full mix-blend-screen filter blur-[150px] opacity-30"></div>
    <div class="fixed bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-teal-600 rounded-full mix-blend-screen filter blur-[120px] opacity-20"></div>

    <div class="w-full max-w-2xl bg-white/10 backdrop-blur-2xl border border-white/20 rounded-[2.5rem] shadow-2xl shadow-black/50 overflow-hidden relative z-10 flex flex-col md:flex-row">
        
        <div class="p-8 md:w-1/2 bg-black/20 flex flex-col justify-center items-center text-center border-b md:border-b-0 md:border-r border-white/10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-400 flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/30">
                <i class="fa-solid fa-shield-halved text-3xl text-white"></i>
            </div>
            <h2 class="text-2xl font-black text-white mb-2">Amankan Akun Anda</h2>
            <p class="text-emerald-100/80 text-sm mb-6">Scan QR Code ini menggunakan aplikasi Google Authenticator atau Authy di smartphone Anda.</p>
            
            <div class="bg-white p-4 rounded-2xl shadow-inner mb-4 inline-block">
                {!! $QR_Image !!}
            </div>
            <p class="text-xs text-white/50 font-mono tracking-wider">{{ $secret }}</p>
        </div>

        <div class="p-8 md:w-1/2 flex flex-col justify-center">
            <h3 class="text-xl font-bold text-white mb-4">Verifikasi Setup</h3>
            
            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 text-red-200 text-sm p-3 rounded-xl mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('2fa.setup.verify') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-white/90 mb-2">Masukkan 6 Digit OTP</label>
                    <input type="text" name="otp" required maxlength="6" pattern="\d{6}" placeholder="123456" 
                        class="w-full bg-white/10 border border-white/20 rounded-2xl px-4 py-4 text-center text-2xl tracking-[0.5em] text-white focus:outline-none focus:ring-4 focus:ring-emerald-500/40 focus:border-emerald-500/60 focus:bg-white/20 transition-all font-mono">
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-1">
                    Verifikasi & Aktifkan 2FA
                </button>
            </form>
        </div>
    </div>
</body>
</html>
