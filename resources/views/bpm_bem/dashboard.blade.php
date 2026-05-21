@extends('layouts.member')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Dashboard {{ strtoupper(Auth::user()->role) }}</h1>
            <p class="text-gray-500 mt-2">Daftar Pengajuan UKM Baru yang memerlukan tinjauan / revisi.</p>
        </div>
    </div>



    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                        <th class="p-4">Tanggal Pengajuan</th>
                        <th class="p-4">Inisiator</th>
                        <th class="p-4">Nama UKM</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengajuans as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-600">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-sm font-medium text-gray-800">{{ $item->user->name }}</td>
                            <td class="p-4 text-sm font-bold text-indigo-600">{{ $item->nama_ukm }}</td>
                            <td class="p-4">
                                @if($item->status == 'pending_bem' || $item->status == 'pending_bpm')
                                    <span class="bg-amber-100 text-amber-700 text-xs px-2.5 py-1 rounded-md font-semibold border border-amber-200">Menunggu Tinjauan</span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-md font-semibold border border-blue-200">Sedang Direvisi</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('birokrasi.pengajuan.show', $item->id) }}" class="inline-flex items-center text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg px-4 py-2 transition-colors">
                                    Detail & Review <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <i class="fa-solid fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada pengajuan UKM baru yang masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
