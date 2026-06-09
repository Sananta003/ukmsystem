@extends('layouts.app')
@section('title', 'Manajemen Anggota')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <form action="{{ route('admin-ukm.anggota.index') }}" method="GET" class="mb-6 flex gap-2">
        <div class="relative flex-1 max-w-md">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email anggota..." 
                class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin-ukm.anggota.index') }}" class="text-red-500 hover:text-red-700 px-4 py-2 text-sm font-medium flex items-center">Reset</a>
        @endif
    </form>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="border-b border-gray-200 bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Anggota</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($anggota as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase">
                                {{ substr($item->name, 0, 2) }}
                            </div>
                            {{ $item->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $item->email }}</td>
                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 flex justify-end gap-2">
                        <form action="{{ route('admin-ukm.anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus akun anggota ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 w-8 h-8 rounded flex items-center justify-center transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-gray-500">Belum ada anggota yang didaftarkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $anggota->links() }}</div>
</div>
@endsection
