@extends('layouts.admin_ukm')
@section('title', 'Kegiatan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin-ukm.kegiatan.index') }}" method="GET" class="mb-6 flex gap-2">
        <div class="relative flex-1 max-w-md">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan atau lokasi..." 
                class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-red-500 hover:text-red-700 px-4 py-2 text-sm font-medium flex items-center">Reset</a>
        @endif
    </form>
    
    <table class="w-full text-left">
        <thead class="border-b bg-gray-50">
            <tr>
                <th class="p-4 text-sm font-semibold text-gray-600">Nama Kegiatan</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                <th class="p-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($kegiatan as $item)
            <tr>
                <td class="p-4 font-medium">{{ $item->nama }}</td>
                <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                <td class="p-4 text-gray-600">
                    <span class="px-2 py-1 rounded text-xs font-medium 
                        {{ $item->status == 'Selesai' ? 'bg-green-100 text-green-700' : ($item->status == 'Berjalan' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                        {{ $item->status }}
                    </span>
                </td>
                
                <td class="p-4 flex justify-end gap-2">
                    <a href="{{ route('admin-ukm.kegiatan.edit', $item->id) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 w-8 h-8 rounded flex items-center justify-center transition-colors" title="Edit">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>
                    
                    <form action="{{ route('admin-ukm.kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 w-8 h-8 rounded flex items-center justify-center transition-colors" title="Hapus">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="p-4 text-center text-gray-500">Belum ada kegiatan.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $kegiatan->links() }}</div>
</div>
@endsection