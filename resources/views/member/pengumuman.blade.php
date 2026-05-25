@extends('layouts.member')
@section('title', 'Papan Pengumuman')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    
    <!-- Header Section -->
    <div class="mb-10 text-center relative z-10">
        <h1 class="text-4xl sm:text-5xl font-black mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-700 via-purple-600 to-pink-600 dark:from-blue-400 dark:via-purple-400 dark:to-pink-400 drop-shadow-sm transition-colors">
            Papan Pengumuman
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg max-w-2xl mx-auto font-medium transition-colors">Semua informasi terbaru dan instruksi penting dari pengurus UKM ada di sini.</p>
    </div>

    <!-- Grid Card Pengumuman -->
    @if($pengumumans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($pengumumans as $pengumuman)
                <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-3xl border border-white/80 dark:border-slate-700 p-8 shadow-xl shadow-purple-900/5 dark:shadow-none hover:-translate-y-2 hover:shadow-2xl hover:shadow-purple-500/20 dark:hover:shadow-purple-500/10 transition-all duration-500 flex flex-col h-full overflow-hidden">
                    
                    <!-- Decorative glow inside card -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-br from-pink-300 to-purple-300 dark:from-pink-900/40 dark:to-purple-900/40 rounded-full mix-blend-multiply filter blur-[40px] opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>

                    <!-- Icon & Date -->
                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/50 dark:to-pink-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400 shadow-inner group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-bullhorn text-2xl"></i>
                        </div>
                        <div class="text-right">
                            <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1 transition-colors">Diterbitkan</span>
                            <span class="bg-white/50 dark:bg-slate-900/50 border border-slate-200/50 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold px-3 py-1 rounded-full shadow-sm backdrop-blur-sm transition-colors">
                                {{ $pengumuman->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <!-- Title & Content -->
                    <div class="relative z-10 flex-grow">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3 group-hover:text-purple-700 dark:group-hover:text-purple-400 transition-colors leading-snug">
                            {{ $pengumuman->judul }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6 line-clamp-4 transition-colors">
                            {{ $pengumuman->konten }}
                        </p>
                    </div>

                    <!-- Optional Date -->
                    @if($pengumuman->tanggal_kegiatan)
                        <div class="mt-auto pt-4 border-t border-slate-200/50 dark:border-slate-700/50 relative z-10 transition-colors">
                            <div class="flex items-center gap-2 text-sm font-semibold text-pink-600 dark:text-pink-400 bg-pink-50/50 dark:bg-pink-900/30 px-4 py-2 rounded-xl w-max transition-colors">
                                <i class="fa-regular fa-calendar text-pink-500 dark:text-pink-400"></i>
                                {{ \Carbon\Carbon::parse($pengumuman->tanggal_kegiatan)->format('d M Y') }}
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-3xl border border-white/80 dark:border-slate-700 p-12 text-center shadow-xl shadow-indigo-900/5 dark:shadow-none max-w-2xl mx-auto transition-colors">
            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 rounded-full flex items-center justify-center mb-6 shadow-inner transition-colors">
                <i class="fa-regular fa-bell-slash text-4xl text-purple-300 dark:text-purple-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-2 transition-colors">Belum Ada Pengumuman</h3>
            <p class="text-slate-500 dark:text-slate-400 font-medium transition-colors">Saat ini belum ada informasi terbaru dari pengurus UKM Anda.</p>
        </div>
    @endif

</div>
@endsection
