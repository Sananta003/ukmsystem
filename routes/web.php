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

Route::get('/run-migrations', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return 'Migrations completed: ' . \Illuminate\Support\Facades\Artisan::output();
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

    Route::prefix('admin-ukm')->name('admin-ukm.')->middleware(['auth', 'can:is_admin_ukm'])->group(function () {
        Route::get('/', function () { return redirect()->route('admin-ukm.dashboard'); });
        Route::get('/dashboard', [\App\Http\Controllers\AdminUkmController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/anggota', [\App\Http\Controllers\AnggotaController::class, 'index'])->name('anggota.index');
        Route::get('/anggota/tambah', [\App\Http\Controllers\AnggotaController::class, 'create'])->name('anggota.create');
        Route::post('/anggota', [\App\Http\Controllers\AnggotaController::class, 'store'])->name('anggota.store');
        Route::delete('/anggota/{id}', [\App\Http\Controllers\AnggotaController::class, 'destroy'])->name('anggota.destroy');
        
        Route::get('/kegiatan', [\App\Http\Controllers\KegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/kegiatan/tambah', [\App\Http\Controllers\KegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/kegiatan', [\App\Http\Controllers\KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/kegiatan/{id}/edit', [\App\Http\Controllers\KegiatanController::class, 'edit'])->name('kegiatan.edit');
        Route::put('/kegiatan/{id}', [\App\Http\Controllers\KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/kegiatan/{id}', [\App\Http\Controllers\KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
        Route::get('/kegiatan/{id}', [\App\Http\Controllers\KegiatanController::class, 'show'])->name('kegiatan.show');
        
        Route::get('/keuangan', [\App\Http\Controllers\KeuanganController::class, 'index'])->name('keuangan.index');
        Route::post('/keuangan', [\App\Http\Controllers\KeuanganController::class, 'store'])->name('keuangan.store');

        Route::get('/evaluasi', [\App\Http\Controllers\EvaluasiController::class, 'index'])->name('evaluasi.index');

        Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak-pdf', [\App\Http\Controllers\LaporanController::class, 'cetakPdf'])->name('laporan.cetak-pdf');

        Route::get('/proposal', [\App\Http\Controllers\ProposalController::class, 'index'])->name('proposal.index');
        Route::get('/proposal/{id}', [\App\Http\Controllers\ProposalController::class, 'show'])->name('proposal.show');
        Route::post('/proposal/{id}/upload', [\App\Http\Controllers\ProposalController::class, 'upload'])->name('proposal.upload');
        Route::post('/proposal/{id}/approve', [\App\Http\Controllers\ProposalController::class, 'approve'])->name('proposal.approve');

        Route::get('/pengaturan', [\App\Http\Controllers\PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan', [\App\Http\Controllers\PengaturanController::class, 'update'])->name('pengaturan.update');
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