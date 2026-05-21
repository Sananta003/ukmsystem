@extends('layouts.admin_ukm')
@section('title', 'Kegiatan')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Jadwal & Kegiatan</h1>
            <p class="text-gray-500 mt-2">Kelola semua kegiatan dan program kerja UKM Anda.</p>
        </div>
        <a href="{{ route('admin-ukm.kegiatan.create') }}" class="inline-flex items-center justify-center bg-brand-accent hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-brand-accent/30 gap-2 hover:-translate-y-0.5">
            <i class="fa-solid fa-plus"></i> Tambah Kegiatan Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden mb-6">
        <form action="{{ route('admin-ukm.kegiatan.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan atau lokasi..." 
                    class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-accent focus:border-brand-accent transition-all bg-gray-50/50 hover:bg-white focus:bg-white text-sm">
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-md">
                Cari Kegiatan
            </button>
            @if(request('search'))
                <a href="{{ route('admin-ukm.kegiatan.index') }}" class="bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 px-6 py-3 text-sm font-bold rounded-xl flex items-center justify-center transition-colors">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider font-bold border-b border-gray-100">
                        <th class="p-5">Informasi Kegiatan</th>
                        <th class="p-5">Tanggal Pelaksanaan</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kegiatan as $item)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 group-hover:text-brand-accent transition-colors">{{ $item->nama }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><i class="fa-solid fa-location-dot text-gray-400 mr-1"></i> {{ $item->lokasi ?? 'Lokasi tidak ditentukan' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}</div>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border
                                {{ $item->status == 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                  ($item->status == 'Berjalan' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-blue-50 text-blue-700 border-blue-200') }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $item->status == 'Selesai' ? 'bg-emerald-500' : ($item->status == 'Berjalan' ? 'bg-amber-500' : 'bg-blue-500') }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        
                        <td class="p-5 flex justify-end gap-2 items-center h-full mt-2">
                            <a href="{{ route('admin-ukm.kegiatan.edit', $item->id) }}" class="text-amber-600 hover:text-amber-800 bg-amber-50 hover:bg-amber-100 w-9 h-9 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Edit">
                                <i class="fa-solid fa-pen text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin-ukm.kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Semua data terkait akan hilang permanen.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 w-9 h-9 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Hapus">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                                <i class="fa-solid fa-folder-open text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Kegiatan</h3>
                            <p class="text-gray-500 text-sm">Anda belum menambahkan program kerja atau kegiatan apapun.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($kegiatan->hasPages())
    <div class="mt-6">
        {{ $kegiatan->links() }}
    </div>
    @endif
</div>
@endsection