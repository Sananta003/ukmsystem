@extends('layouts.admin_ukm')
@section('title', 'Cek Proposal UKM')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Cek Proposal</h1>
            <p class="text-gray-500 mt-2">Fitur untuk mengecek dan melacak proposal kegiatan UKM.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-24 h-24 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
            <i class="fa-solid fa-file-invoice"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Fitur Cek Proposal</h2>
        <p class="text-gray-500 mb-6 max-w-lg mx-auto">Fitur ini sedang dalam tahap pengembangan. Nantinya Anda dapat mengecek status persetujuan, riwayat, dan detail dari setiap proposal kegiatan yang diajukan.</p>
        <button class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all opacity-75 cursor-not-allowed">
            Segera Hadir
        </button>
    </div>
</div>
@endsection
