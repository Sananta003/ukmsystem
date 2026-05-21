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

// Utility routes for cPanel / Shared Hosting users
Route::get('/artisan/clear', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Application cache cleared!';
});

Route::get('/artisan/migrate', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return 'Database migrated successfully!';
});

Route::get('/artisan/storage-link', function() {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Storage linked successfully!';
});

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
        Route::get('/laporan/proposal', [LaporanController::class, 'proposal'])->name('laporan.proposal');
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/', function () { return redirect()->route('member.dashboard'); });
        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
        Route::get('/kegiatan', [MemberController::class, 'kegiatan'])->name('kegiatan');
    });

    Route::prefix('inisiator')->name('inisiator.')->group(function () {
        Route::get('/', function () { return redirect()->route('inisiator.dashboard'); });
        Route::get('/dashboard', [MemberController::class, 'inisiatorDashboard'])->name('dashboard');
        Route::get('/pengajuan-ukm/buat', [MemberController::class, 'buatPengajuan'])->name('pengajuan.create');
        Route::post('/pengajuan-ukm', [MemberController::class, 'storePengajuan'])->name('pengajuan.store');
        Route::get('/pengajuan-ukm/{id}/edit', [MemberController::class, 'editPengajuan'])->name('pengajuan.edit');
        Route::put('/pengajuan-ukm/{id}', [MemberController::class, 'updatePengajuan'])->name('pengajuan.update');
    });

    Route::prefix('superadmin')->name('superadmin.')->middleware('can:is_super_admin')->group(function () {
        Route::get('/', function () { return redirect()->route('superadmin.dashboard'); });
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');    
        Route::get('/pengajuan/{id}', [SuperAdminController::class, 'showPengajuan'])->name('pengajuan.show');
        Route::get('/ukm/{id}/pantau', [SuperAdminController::class, 'show'])->name('ukm.show');
        Route::post('/ukm/{id}/approve', [SuperAdminController::class, 'approvePengajuan'])->name('ukm.approve');
        Route::post('/ukm/{id}/reject', [SuperAdminController::class, 'rejectPengajuan'])->name('ukm.reject');
        Route::get('/ukm/tambah', [SuperAdminController::class, 'create'])->name('ukm.create');
        Route::post('/ukm', [SuperAdminController::class, 'store'])->name('ukm.store');
        Route::delete('/ukm/{id}', [SuperAdminController::class, 'destroy'])->name('ukm.destroy');
    });

    Route::prefix('birokrasi')->name('birokrasi.')->middleware(['auth', 'can:is_bem_or_bpm'])->group(function () {
        Route::get('/', function () { return redirect()->route('birokrasi.dashboard'); });
        Route::get('/dashboard', [\App\Http\Controllers\BpmBemController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan/{id}', [\App\Http\Controllers\BpmBemController::class, 'show'])->name('pengajuan.show');
        Route::post('/pengajuan/{id}/acc', [\App\Http\Controllers\BpmBemController::class, 'acc'])->name('pengajuan.acc');
        Route::post('/pengajuan/{id}/revisi', [\App\Http\Controllers\BpmBemController::class, 'storeRevisi'])->name('pengajuan.revisi');
    });
});