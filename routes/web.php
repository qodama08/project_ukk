<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\JadwalKonselingController;
use App\Http\Controllers\CatatanKonselingController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


use App\Http\Controllers\GuruBKController;
use App\Http\Controllers\BkAiController;

Route::middleware('auth')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
});

Route::middleware(['auth', 'cekRole:admin'])->group(function () {
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    Route::resource('roles', RoleController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('jurusan', JurusanController::class);
});

// Siswa CRUD - admin only
Route::middleware(['auth', 'cekRole:admin'])->group(function () {
    Route::post('siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::get('siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});

// Siswa index/show - everyone can view
Route::middleware('auth')->group(function () {
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
});

// Guru BK - index/show untuk semua user login, create/edit/delete hanya admin
Route::middleware(['auth', 'cekRole:admin'])->group(function () {
    Route::get('guru_bk/create', [GuruBKController::class, 'create'])->name('guru_bk.create');
    Route::post('guru_bk', [GuruBKController::class, 'store'])->name('guru_bk.store');
    Route::get('guru_bk/{guru_bk}/edit', [GuruBKController::class, 'edit'])->name('guru_bk.edit');
    Route::put('guru_bk/{guru_bk}', [GuruBKController::class, 'update'])->name('guru_bk.update');
    Route::delete('guru_bk/{guru_bk}', [GuruBKController::class, 'destroy'])->name('guru_bk.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('guru_bk', [GuruBKController::class, 'index'])->name('guru_bk.index');
    Route::get('guru_bk/{guru_bk}', [GuruBKController::class, 'show'])->name('guru_bk.show');
});

// Pelanggaran - admin only CUD, everyone can view
Route::middleware(['auth', 'cekRole:admin'])->group(function () {
    Route::post('pelanggaran', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    Route::get('pelanggaran/create', [PelanggaranController::class, 'create'])->name('pelanggaran.create');
    Route::get('pelanggaran/{pelanggaran}/edit', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
    Route::put('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
    Route::delete('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
    Route::get('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'show'])->name('pelanggaran.show');
});

// Prestasi - admin only CUD, everyone can view
Route::middleware(['auth', 'cekRole:admin'])->group(function () {
    Route::post('prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::get('prestasi/create', [PrestasiController::class, 'create'])->name('prestasi.create');
    Route::get('prestasi/{prestasi}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit');
    Route::put('prestasi/{prestasi}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::delete('prestasi/{prestasi}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
    Route::get('prestasi/{prestasi}', [PrestasiController::class, 'show'])->name('prestasi.show');
});

// Catatan Konseling - admin only CUD, everyone can view
Route::middleware(['auth', 'cekRole:admin'])->group(function () {
    Route::post('catatan_konseling', [CatatanKonselingController::class, 'store'])->name('catatan_konseling.store');
    Route::get('catatan_konseling/create', [CatatanKonselingController::class, 'create'])->name('catatan_konseling.create');
    Route::get('catatan_konseling/{catatan_konseling}/edit', [CatatanKonselingController::class, 'edit'])->name('catatan_konseling.edit');
    Route::put('catatan_konseling/{catatan_konseling}', [CatatanKonselingController::class, 'update'])->name('catatan_konseling.update');
    Route::delete('catatan_konseling/{catatan_konseling}', [CatatanKonselingController::class, 'destroy'])->name('catatan_konseling.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('catatan_konseling', [CatatanKonselingController::class, 'index'])->name('catatan_konseling.index');
    Route::get('catatan_konseling/{catatan_konseling}', [CatatanKonselingController::class, 'show'])->name('catatan_konseling.show');
    Route::post('catatan_konseling/{id}/approve', [CatatanKonselingController::class, 'approve'])->name('catatan_konseling.approve');
});

// Jadwal Konseling - student ONLY create, admin ONLY set_status
Route::middleware('auth')->group(function () {
    Route::get('jadwal_konseling', [JadwalKonselingController::class, 'index'])->name('jadwal_konseling.index');
    Route::post('notifikasi/reduce-unread', [\App\Http\Controllers\NotifikasiController::class, 'reduceUnread'])->name('notifikasi.reduceUnread');
});

// Student only - dapat create jadwal
Route::middleware('auth')->group(function () {
    Route::post('jadwal_konseling', [JadwalKonselingController::class, 'store'])->name('jadwal_konseling.store');
    Route::get('jadwal_konseling/create', [JadwalKonselingController::class, 'create'])->name('jadwal_konseling.create');
    Route::get('jadwal_konseling/{jadwal_konseling}/edit', [JadwalKonselingController::class, 'edit'])->name('jadwal_konseling.edit');
    Route::put('jadwal_konseling/{jadwal_konseling}', [JadwalKonselingController::class, 'update'])->name('jadwal_konseling.update');
    Route::delete('jadwal_konseling/{jadwal_konseling}', [JadwalKonselingController::class, 'destroy'])->name('jadwal_konseling.destroy');
    // show route moved here so /jadwal_konseling/create is not captured by the {jadwal_konseling} route
    Route::get('jadwal_konseling/{jadwal_konseling}', [JadwalKonselingController::class, 'show'])->name('jadwal_konseling.show');
});

// Admin only - dapat ubah status
Route::post('jadwal_konseling/{id}/set_status', [JadwalKonselingController::class, 'setStatus'])->middleware('auth')->name('jadwal_konseling.set_status');
Route::post('jadwal_konseling/{id}/cancel', [JadwalKonselingController::class, 'cancelSchedule'])->middleware('auth')->name('jadwal_konseling.cancel');

Route::get('/', function () {
    // Jika user sudah login
    if (auth()->check()) {
        // Redirect ke dashboard
        return redirect()->route('dashboard');
    }
    // Jika belum login, tampilkan welcome page
    return view('welcome');
})->name('home');
Route::get('/contact-us', function () {
    return view('contact');
});
Route::get('/verify-email', [AuthController::class, 'showVerifyForm'])->name('verify.form');

Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');

Route::post('/verify-email', [AuthController::class, 'verify'])->name('verify.otp');
// Route yang hanya bisa diakses oleh user yang belum login
Route::middleware(['guest'])->group(
    function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');

        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.post');




        Route::get('/auth/{provider}', [AuthController::class, 'redirect'])->name('sso.redirect');
        Route::get('/auth/{provider}/callback', [AuthController::class, 'callback'])->name('sso.callback');


        // Request reset link
        Route::get('/forgot-password', [AuthController::class, 'showRequestForm'])->name('forgot_password.email_form');
        Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot_password.send_link');

        // Reset password form
        Route::get('/password-reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
        Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('password.verify-otp-form');
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify-otp');
        Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update');
    }
);


// Route yang hanya bisa diakses oleh user yang sudah login
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/myprofile', function () {
        return view('myprofile');
    });

    // Admin routes
    Route::middleware(['cekRole:admin'])->group(function () {
        Route::get('notifikasi', [\App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::post('notifikasi/{id}/read', [\App\Http\Controllers\NotifikasiController::class, 'markRead'])->name('notifikasi.read');
        Route::post('notifikasi/{id}/delete', [\App\Http\Controllers\NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
    });

    // BK AI Routes
    Route::prefix('bk-ai')->name('bk_ai.')->group(function () {
        Route::get('/', [BkAiController::class, 'index'])->name('index');
        Route::post('/chat', [BkAiController::class, 'chat'])->name('chat');
    });

});
