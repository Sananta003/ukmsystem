<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan UKM Baru - Portal Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen py-10">

    <div class="max-w-md w-full mx-4">
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                <i class="fa-solid fa-rocket text-white text-xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-slate-800">Inisiator UKM Baru</h2>
            <p class="text-slate-500 mt-2 text-sm">Buat akun untuk mengajukan proposal pendirian Unit Kegiatan Mahasiswa yang baru.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="ukm_id" value="">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (Calon Ketua)</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Kampus / Aktif</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="mahasiswa@kampus.ac.id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4 flex gap-3 text-sm text-indigo-700 mt-2">
                    <i class="fa-solid fa-circle-info mt-0.5"></i>
                    <p>Setelah mendaftar, Anda akan diarahkan ke Dashboard untuk mengisi formulir pengajuan Visi & Misi UKM Baru.</p>
                </div>

                <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold transition-colors mt-4 shadow-md">
                    Daftar & Lanjutkan Pengajuan
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
             <a href="{{ url('/') }}" class="text-gray-400 hover:text-gray-600 text-sm font-medium"><i class="fa-solid fa-arrow-left mr-1"></i> Batal & Kembali</a>
        </div>
    </div>

</body>
</html>