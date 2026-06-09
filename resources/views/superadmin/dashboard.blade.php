@extends('layouts.app')
@section('title', 'Manajemen UKM Kampus')

@section('content')
<div class="grid grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6">
        <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-3xl"><i class="fa-solid fa-sitemap"></i></div>
        <div><p class="text-gray-500 font-medium">Total UKM Terdaftar</p><h3 class="text-3xl font-black text-gray-800">{{ $totalUkm }}</h3></div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6">
        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl"><i class="fa-solid fa-users"></i></div>
        <div><p class="text-gray-500 font-medium">Total Mahasiswa (Semua UKM)</p><h3 class="text-3xl font-black text-gray-800">{{ $totalMahasiswa }}</h3></div>
    </div>
</div>



@if(isset($pengajuans) && $pengajuans->count() > 0)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 border-l-4 border-l-yellow-400">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Menunggu Persetujuan (Proposal Masuk)</h2>
        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1.5 rounded-full">{{ $pengajuans->count() }} Antrean</span>
    </div>

    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
            <tr>
                <th class="px-6 py-4 rounded-tl-lg">Nama UKM Diajukan</th>
                <th class="px-6 py-4">Inisiator (Ketua)</th>
                <th class="px-6 py-4">Waktu Pengajuan</th>
                <th class="px-6 py-4 text-right rounded-tr-lg">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($pengajuans as $pengajuan)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-bold text-gray-800">{{ $pengajuan->nama_ukm }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $pengajuan->user->name ?? 'User Terhapus' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $pengajuan->created_at->diffForHumans() }}</td>
                <td class="px-6 py-4 flex justify-end gap-2">
                    <a href="{{ route('superadmin.pengajuan.show', $pengajuan->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded text-xs font-bold transition-colors">
                        Review & ACC
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@if(isset($proposals) && $proposals->count() > 0)
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8 border-l-4 border-l-indigo-400">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Menunggu Persetujuan (Proposal Kegiatan)</h2>
        <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1.5 rounded-full">{{ $proposals->count() }} Antrean</span>
    </div>

    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
            <tr>
                <th class="px-6 py-4 rounded-tl-lg">UKM</th>
                <th class="px-6 py-4">Nama Kegiatan</th>
                <th class="px-6 py-4">File Proposal</th>
                <th class="px-6 py-4 text-right rounded-tr-lg">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($proposals as $approval)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-bold text-gray-800">{{ $approval->proposal->kegiatan->ukm->nama_ukm }}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $approval->proposal->kegiatan->nama_kegiatan }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    <a href="{{ asset('storage/' . $approval->proposal->file_proposal) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-rose-600 hover:text-rose-700 font-medium bg-rose-50 px-3 py-1.5 rounded-lg border border-rose-100 transition-colors">
                        <i class="fa-solid fa-file-pdf"></i> Lihat File
                    </a>
                </td>
                <td class="px-6 py-4 flex justify-end gap-2">
                    <a href="{{ route('superadmin.proposal.show', $approval->proposal->id) }}" class="text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-4 py-2 rounded text-xs font-bold transition-colors">
                        Review & ACC
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Daftar UKM Terdaftar (Resmi)</h2>
        <a href="{{ route('superadmin.ukm.create') }}" class="text-purple-600 hover:text-purple-800 font-medium text-sm transition-colors">
            <i class="fa-solid fa-plus mr-1"></i> Input Manual Tanpa Proposal
        </a>
    </div>

    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
            <tr>
                <th class="px-6 py-4 rounded-tl-lg">Nama UKM</th>
                <th class="px-6 py-4">Total Anggota</th>
                <th class="px-6 py-4">Ketua (Admin)</th>
                <th class="px-6 py-4 text-right rounded-tr-lg">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($ukms as $ukm)
            @php $admin = \App\Models\User::where('ukm_id', $ukm->id)->where('role', 'admin_ukm')->first(); @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                            @if($ukm->logo) <img src="{{ asset('storage/'.$ukm->logo) }}" class="w-full h-full object-cover">
                            @else <i class="fa-solid fa-users text-gray-400"></i> @endif
                        </div>
                        <span class="font-bold text-gray-800">{{ $ukm->nama_ukm }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 font-medium text-gray-600">{{ $ukm->users_count }} Mahasiswa</td>
                <td class="px-6 py-4">
                    <p class="text-sm font-bold text-gray-800">{{ $admin ? $admin->name : 'Belum Ada' }}</p>
                    <p class="text-xs text-gray-500">{{ $admin ? $admin->email : '-' }}</p>
                </td>
                <td class="px-6 py-4 flex justify-end gap-2">
                    <a href="{{ route('superadmin.ukm.show', $ukm->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1.5 rounded text-xs font-bold transition-colors flex items-center">
                        <i class="fa-solid fa-eye mr-1"></i> Pantau
                    </a>
                    <form action="{{ route('superadmin.ukm.destroy', $ukm->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus UKM ini akan menghapus seluruh data di dalamnya secara permanen. Lanjutkan?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded text-xs font-bold transition-colors">Bubar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $ukms->links() }}</div>
</div>
@endsection
