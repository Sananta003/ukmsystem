@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('birokrasi.dashboard') }}" class="text-gray-500 hover:text-indigo-600 font-medium transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <span class="bg-indigo-100 text-indigo-800 text-sm font-bold px-3 py-1 rounded-full border border-indigo-200">
            Status: {{ strtoupper($pengajuan->status) }}
        </span>
    </div>



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Detail Proposal -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-start justify-between mb-6 border-b border-gray-100 pb-6">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $pengajuan->nama_ukm }}</h1>
                        <p class="text-gray-500 text-sm"><i class="fa-solid fa-user mr-2"></i> Inisiator: <span class="font-bold text-gray-700">{{ $pengajuan->user->name }}</span> ({{ $pengajuan->created_at->format('d M Y') }})</p>
                    </div>
                    @if($pengajuan->logo)
                        <div class="w-16 h-16 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/'.$pengajuan->logo) }}" alt="Logo" class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Visi, Misi & Latar Belakang</h3>
                        <p class="text-gray-800 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 whitespace-pre-wrap">{{ $pengajuan->latar_belakang }}</p>
                    </div>
                    
                    @if($pengajuan->file_proposal)
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Dokumen Proposal</h3>
                        <a href="{{ asset('storage/'.$pengajuan->file_proposal) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors font-semibold">
                            <i class="fa-solid fa-download mr-2"></i> Download File Proposal (PDF)
                        </a>
                    </div>
                    @endif
                    <!-- Jika ingin menambahkan field rencana_kegiatan dll bisa di sini -->
                </div>
            </div>

            <!-- Action ACC -->
            <div x-data="{ modalBuka: false }" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-100 pb-4"><i class="fa-solid fa-check-double text-emerald-500 mr-2"></i> Keputusan {{ strtoupper(Auth::user()->role) }}</h2>
                <button @click="modalBuka = true" type="button" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-lg transition-colors shadow-lg shadow-emerald-200 flex items-center justify-center">
                    <i class="fa-solid fa-check-circle mr-2"></i> ACC PROPOSAL & TERUSKAN
                </button>

                <!-- Modal Konfirmasi ACC -->
                <div x-show="modalBuka" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="modalBuka" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="modalBuka" x-transition @click.away="modalBuka = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <i class="fa-solid fa-check text-emerald-600"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Konfirmasi Persetujuan</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Anda yakin ingin menyetujui proposal ini dan meneruskannya? Tindakan ini tidak dapat dibatalkan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <form action="{{ route('birokrasi.pengajuan.acc', $pengajuan->id) }}" method="POST" class="inline-block w-full sm:w-auto">
                                    @csrf
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                        Ya, Setujui
                                    </button>
                                </form>
                                <button @click="modalBuka = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Revisi -->
            <div x-data="{ modalRevisi: false }" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-100 pb-4"><i class="fa-solid fa-comment-medical text-amber-500 mr-2"></i> Minta Revisi ke Inisiator</h2>
                
                <button @click="modalRevisi = true" type="button" class="w-full py-4 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-lg transition-colors shadow-lg shadow-amber-200 flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> MINTA REVISI
                </button>

                <!-- Modal Form Revisi -->
                <div x-show="modalRevisi" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="modalRevisi" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="modalRevisi" x-transition @click.away="modalRevisi = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                            <form action="{{ route('birokrasi.pengajuan.revisi', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <i class="fa-solid fa-comment-dots text-amber-600"></i>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Form Revisi</h3>
                                            <div class="mt-4 space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Revisi / Evaluasi <span class="text-red-500">*</span></label>
                                                    <textarea name="komentar" rows="4" required placeholder="Tulis catatan revisi untuk inisiator di sini..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 outline-none"></textarea>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Lampiran (Opsional, PDF/Word/Img max 5MB)</label>
                                                    <input type="file" name="file_revisi" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 border border-gray-200 rounded-lg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                        Kirim Revisi
                                    </button>
                                    <button @click="modalRevisi = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Riwayat Revisi -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center"><i class="fa-solid fa-clock-rotate-left text-gray-400 mr-2"></i> Riwayat Peninjauan</h3>
                
                @if($pengajuan->revisis->count() > 0)
                    <div class="space-y-4 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                        @foreach($pengajuan->revisis as $revisi)
                            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-300 group-[.is-active]:bg-indigo-500 text-white group-[.is-active]:text-emerald-50 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                                    <i class="fa-solid fa-user-pen text-xs"></i>
                                </div>
                                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded border border-slate-200 bg-white shadow-sm">
                                    <div class="flex items-center justify-between space-x-2 mb-1">
                                        <div class="font-bold text-slate-900">{{ $revisi->user->name }}</div>
                                        <time class="font-caveat font-medium text-indigo-500">{{ $revisi->created_at->format('d/m y') }}</time>
                                    </div>
                                    <div class="text-xs text-gray-500 uppercase font-semibold mb-2">{{ $revisi->user->role }}</div>
                                    <div class="text-slate-500 text-sm">{{ $revisi->komentar }}</div>
                                    @if($revisi->file_revisi)
                                        <a href="{{ asset('storage/'.$revisi->file_revisi) }}" target="_blank" class="mt-2 inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                            <i class="fa-solid fa-paperclip mr-1"></i> File
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <i class="fa-regular fa-comment-dots text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada catatan peninjauan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
