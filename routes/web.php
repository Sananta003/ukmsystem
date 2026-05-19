<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SuperAdminController;

Route::get('/', function () {
    $ukms = App\Models\Ukm::withCount(['users' => function ($query) {
        $query->where('role', 'member');
    }])->get();
    
    return view('welcome', compact('ukms'));
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister']);
    
    Route::get('/pengajuan-ukm', [AuthController::class, 'registerFounder'])->name('pengajuan.create');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin-ukm')->name('admin-ukm.')->middleware('can:is_admin')->group(function () {
        Route::get('/', function () { return redirect()->route('admin-ukm.dashboard'); });
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        
        Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
        Route::get('/anggota/tambah', [AnggotaController::class, 'create'])->name('anggota.create');
        Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
        Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
        
        Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/kegiatan/tambah', [KegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/kegiatan/{id}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
        Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
        
        Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
        Route::get('/keuangan/tambah', [KeuanganController::class, 'create'])->name('keuangan.create');
        Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
        Route::get('/keuangan/{id}/edit', [KeuanganController::class, 'edit'])->name('keuangan.edit');
        Route::put('/keuangan/{id}', [KeuanganController::class, 'update'])->name('keuangan.update');
        Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
        
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak-pdf');
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/', function () { return redirect()->route('member.dashboard'); });
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
        Route::get('/kegiatan', [MemberController::class, 'kegiatan'])->name('kegiatan');
        Route::get('/pengajuan-ukm/buat', [MemberController::class, 'buatPengajuan'])->name('pengajuan.create');
        Route::post('/pengajuan-ukm', [MemberController::class, 'storePengajuan'])->name('pengajuan.store');
    });

    Route::prefix('superadmin')->name('superadmin.')->middleware('can:is_super_admin')->group(function () {
        Route::get('/', function () { return redirect()->route('superadmin.dashboard'); });
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');    
        Route::post('/generate-kode', [SuperAdminController::class, 'generateKode'])->name('generate_kode');
        Route::get('/ukm/{id}/pantau', [SuperAdminController::class, 'show'])->name('ukm.show');
        Route::get('/ukm/tambah', [SuperAdminController::class, 'create'])->name('ukm.create');
        Route::post('/ukm', [SuperAdminController::class, 'store'])->name('ukm.store');
        Route::delete('/ukm/{id}', [SuperAdminController::class, 'destroy'])->name('ukm.destroy');
    });
});