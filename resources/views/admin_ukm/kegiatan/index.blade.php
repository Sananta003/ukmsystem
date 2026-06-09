@extends('layouts.app')
@section('title', 'Kegiatan')

@section('content')
<div class="w-full" x-data="{ modalPengumuman: false }">
    <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-slate-100 transition-colors">Jadwal & Kegiatan</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-2 transition-colors">Kelola semua kegiatan dan program kerja UKM Anda.</p>
        </div>
        <div class="flex gap-3 flex-wrap">
            <button @click="modalPengumuman = true" class="inline-flex items-center justify-center bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-pink-500/30 gap-2 hover:-translate-y-0.5 hover:shadow-pink-500/50">
                <i class="fa-solid fa-bullhorn animate-pulse"></i> Buat Pengumuman
            </button>
            <a href="{{ route('admin-ukm.kegiatan.create') }}" class="inline-flex items-center justify-center bg-brand-accent hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-brand-accent/30 gap-2 hover:-translate-y-0.5">
                <i class="fa-solid fa-plus"></i> Tambah Kegiatan Baru
            </a>
        </div>
    </div>

    <!-- Modal Pengumuman -->
    <div x-show="modalPengumuman" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4">
        <!-- Backdrop -->
        <div x-show="modalPengumuman" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="modalPengumuman = false"></div>

        <!-- Modal Content -->
        <div x-show="modalPengumuman" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" class="relative w-full max-w-lg bg-white/80 dark:bg-slate-900/90 backdrop-blur-xl border border-white/60 dark:border-slate-700 rounded-3xl shadow-2xl shadow-indigo-900/20 overflow-hidden">
            
            <div class="p-8">
                <h3 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-pink-600 to-orange-500 mb-2">Siarkan Pengumuman</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 transition-colors">Pesan ini akan otomatis terlihat oleh seluruh member di halaman dashboard mereka.</p>

                <form action="{{ route('admin-ukm.pengumuman.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1 transition-colors">Judul Pengumuman</label>
                        <input type="text" name="judul" required placeholder="Cth: Jadwal Latihan Diubah" class="w-full bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 dark:text-white rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1 transition-colors">Tanggal Terkait (Opsional)</label>
                        <input type="date" name="tanggal_kegiatan" class="w-full bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 transition-all text-slate-600 dark:text-slate-300">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1 transition-colors">Isi Pesan</label>
                        <textarea name="konten" required rows="4" placeholder="Tuliskan pesan Anda di sini..." class="w-full bg-white/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-600 dark:text-white rounded-2xl px-4 py-3 focus:outline-none focus:ring-4 focus:ring-pink-500/20 focus:border-pink-500 transition-all"></textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="modalPengumuman = false" class="flex-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold py-3 rounded-2xl transition-all">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white font-bold py-3 rounded-2xl shadow-lg shadow-pink-500/30 hover:shadow-pink-500/50 hover:-translate-y-0.5 transition-all">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 relative overflow-hidden mb-6 transition-colors">
        <form action="{{ route('admin-ukm.kegiatan.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan atau lokasi..." 
                    class="w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-accent focus:border-brand-accent transition-all bg-gray-50/50 hover:bg-white focus:bg-white text-sm">
            </div>
            <button type="submit" class="bg-gray-800 dark:bg-slate-700 hover:bg-gray-900 dark:hover:bg-slate-600 text-white px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-md">
                Cari Kegiatan
            </button>
            @if(request('search'))
                <a href="{{ route('admin-ukm.kegiatan.index') }}" class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 hover:text-red-700 px-6 py-3 text-sm font-bold rounded-xl flex items-center justify-center transition-colors">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>
    
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden relative transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-slate-900/50 text-gray-500 dark:text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-gray-100 dark:border-slate-700 transition-colors">
                        <th class="p-5">Informasi Kegiatan</th>
                        <th class="p-5">Tanggal Pelaksanaan</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50">
                    @forelse($kegiatans as $item)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-700/30 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 transition-colors">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-slate-200 group-hover:text-brand-accent transition-colors">{{ $item->nama_kegiatan }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 transition-colors"><i class="fa-solid fa-location-dot text-gray-400 dark:text-slate-500 mr-1"></i> {{ $item->lokasi ?? 'Lokasi tidak ditentukan' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="text-sm font-medium text-gray-800 dark:text-slate-200 transition-colors">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500 dark:text-slate-400 transition-colors">{{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}</div>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border
                                {{ $item->status == 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' : 
                                  ($item->status == 'Berjalan' ? 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50' : 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800/50') }} transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $item->status == 'Selesai' ? 'bg-emerald-500' : ($item->status == 'Berjalan' ? 'bg-amber-500' : 'bg-blue-500') }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        
                        <td class="p-5 flex justify-end gap-2 items-center h-full mt-2">
                            <a href="{{ route('admin-ukm.proposal.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-800 bg-indigo-50 dark:bg-indigo-900/20 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 w-9 h-9 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Upload/Cek Proposal">
                                <i class="fa-solid fa-file-arrow-up text-sm"></i>
                            </a>

                            <a href="{{ route('admin-ukm.kegiatan.edit', $item->id) }}" class="text-amber-600 hover:text-amber-800 bg-amber-50 dark:bg-amber-900/20 dark:text-amber-500 hover:bg-amber-100 dark:hover:bg-amber-900/40 w-9 h-9 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Edit">
                                <i class="fa-solid fa-pen text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin-ukm.kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Semua data terkait akan hilang permanen.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 dark:bg-red-900/20 dark:text-red-500 hover:bg-red-100 dark:hover:bg-red-900/40 w-9 h-9 rounded-lg flex items-center justify-center transition-colors shadow-sm" title="Hapus">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500 mb-4 transition-colors">
                                <i class="fa-solid fa-folder-open text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-slate-200 mb-1 transition-colors">Belum Ada Kegiatan</h3>
                            <p class="text-gray-500 dark:text-slate-400 text-sm transition-colors">Anda belum menambahkan program kerja atau kegiatan apapun.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($kegiatans->hasPages())
    <div class="mt-6">
        {{ $kegiatans->links() }}
    </div>
    @endif
</div>
@endsection
