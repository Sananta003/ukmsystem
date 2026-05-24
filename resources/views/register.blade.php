<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota UKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-blue-600 p-6 text-center">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 text-xl mx-auto mb-3 shadow-sm">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2 class="text-2xl font-bold text-white">Bergabung dengan UKM</h2>
            <p class="text-blue-100 text-sm mt-1">Daftarkan diri Anda untuk mengembangkan minat dan bakat.</p>
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@kampus.com" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <!-- Alert Info UKM -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <div>
                    <p class="text-xs text-blue-600 font-semibold uppercase tracking-wider mb-0.5">Mendaftar untuk bergabung dengan</p>
                    <h3 class="text-base font-bold text-slate-800">{{ $targetUkm->nama_ukm }}</h3>
                </div>
            </div>

            <!-- Hidden input untuk ukm_id -->
            <input type="hidden" name="ukm_id" value="{{ request('ukm_id') }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buat Password</label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition-colors shadow-md shadow-blue-200 mt-2">
                Daftar & Masuk
            </button>
            
            <p class="text-center text-sm text-gray-500 mt-4">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login disini</a>
            </p>
        </form>
    </div>

</body>
</html>