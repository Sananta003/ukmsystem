<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Proposal - UKM System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 text-slate-800">
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex items-center justify-between">
            <a href="javascript:history.back()" class="text-indigo-600 hover:text-indigo-800 font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Review Proposal Kegiatan</h1>
            <p class="text-gray-500 mb-8">Detail kegiatan: <span class="font-bold text-indigo-600">{{ $proposal->kegiatan->nama_kegiatan }}</span></p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-gray-50 p-6 rounded-xl border border-gray-100">
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pelaksanaan</p>
                    <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($proposal->kegiatan->tanggal)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p class="font-bold text-gray-800">{{ $proposal->kegiatan->kategori }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lokasi</p>
                    <p class="font-bold text-gray-800">{{ $proposal->kegiatan->lokasi }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Anggaran</p>
                    <p class="font-bold text-gray-800">Rp {{ number_format($proposal->kegiatan->anggaran, 0, ',', '.') }}</p>
                </div>
                <div class="col-span-full">
                    <p class="text-sm text-gray-500">Deskripsi Singkat</p>
                    <p class="text-gray-800 mt-1">{{ $proposal->kegiatan->deskripsi }}</p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">File Proposal</h3>
                <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank" class="inline-flex items-center gap-3 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 px-6 py-4 rounded-xl font-bold transition-colors w-full sm:w-auto">
                    <i class="fa-solid fa-file-pdf text-2xl"></i> Buka Dokumen Proposal (PDF)
                </a>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-4">Jalur Persetujuan</h3>
            <div class="space-y-4 mb-10">
                @foreach($approvals as $approval)
                <div class="flex items-start gap-4 p-4 rounded-xl border 
                    {{ $approval->status == 'Disetujui' ? 'bg-emerald-50 border-emerald-100' : 
                      ($approval->status == 'Ditolak' ? 'bg-red-50 border-red-100' : 
                      ($approval->status == 'Revisi' ? 'bg-amber-50 border-amber-100' : 'bg-gray-50 border-gray-100')) }}">
                    <div class="mt-1">
                        @if($approval->status == 'Disetujui') <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                        @elseif($approval->status == 'Ditolak') <i class="fa-solid fa-circle-xmark text-red-500 text-xl"></i>
                        @elseif($approval->status == 'Revisi') <i class="fa-solid fa-circle-exclamation text-amber-500 text-xl"></i>
                        @else <i class="fa-regular fa-circle text-gray-400 text-xl"></i> @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <h4 class="font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $approval->role_approval) }}</h4>
                            <span class="text-xs font-bold px-2 py-1 rounded-md
                                {{ $approval->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 
                                  ($approval->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 
                                  ($approval->status == 'Revisi' ? 'bg-amber-100 text-amber-700' : 'bg-gray-200 text-gray-600')) }}">
                                {{ $approval->status }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Peninjau: {{ $approval->user ? $approval->user->name : '-' }}</p>
                        @if($approval->catatan)
                            <div class="mt-2 text-sm bg-white bg-opacity-60 p-3 rounded-lg text-gray-700 italic border border-gray-200/60">
                                "{{ $approval->catatan }}"
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @php
                $userRole = Auth::user()->role;
                $myApproval = $approvals->where('role_approval', $userRole)->where('status', 'Menunggu')->first();
            @endphp

            @if($myApproval)
                <div class="border-t border-gray-100 pt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Berikan Keputusan Anda</h3>
                    <form action="{{ request()->routeIs('birokrasi.*') ? route('birokrasi.proposal.approve', $proposal->id) : route('superadmin.proposal.approve', $proposal->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Keputusan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="Disetujui" class="peer sr-only" required>
                                    <div class="text-center px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 font-bold transition-all">
                                        <i class="fa-solid fa-check mr-2"></i> Setujui
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="Revisi" class="peer sr-only" required>
                                    <div class="text-center px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 font-bold transition-all">
                                        <i class="fa-solid fa-pen mr-2"></i> Minta Revisi
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="Ditolak" class="peer sr-only" required>
                                    <div class="text-center px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 font-bold transition-all">
                                        <i class="fa-solid fa-xmark mr-2"></i> Tolak
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3" placeholder="Berikan catatan, alasan penolakan, atau poin revisi di sini..."></textarea>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-indigo-200">
                            Simpan Keputusan
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</body>
</html>
