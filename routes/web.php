<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\LogPelanggaranController;
use App\Http\Controllers\JadwalKonselingController;
use App\Http\Controllers\CatatanKonselingController;
use App\Http\Controllers\CatatanPerkembanganController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\IdentitasSekolahController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SuratPanggilanController;
use App\Http\Controllers\ArsipDokumenController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('kelas', KelasController::class);
Route::resource('jurusan', JurusanController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('pelanggaran', PelanggaranController::class);
Route::resource('log_pelanggaran', LogPelanggaranController::class);
Route::resource('jadwal_konseling', JadwalKonselingController::class);
Route::resource('catatan_konseling', CatatanKonselingController::class);
Route::resource('catatan_perkembangan', CatatanPerkembanganController::class);
Route::resource('prestasi', PrestasiController::class);
Route::resource('identitas_sekolah', IdentitasSekolahController::class);
Route::resource('agenda', AgendaController::class);
Route::resource('pengaduan', PengaduanController::class);
Route::resource('surat_panggilan', SuratPanggilanController::class);
Route::resource('arsip_dokumen', ArsipDokumenController::class);
Route::resource('notifikasi', NotifikasiController::class);
Route::resource('laporan', LaporanController::class);

Route::get('/', function () {
    return view('welcome');
});
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

        Route::get('/verifikasi', function () {
            return view('admin.verifikasi');
        })->name('admin.verifikasi');
        Route::get('/seleksi', function () {
            return view('admin.seleksi');
        })->name('admin.seleksi');
        Route::get('/pengumuman', function () {
            return view('admin.pengumuman');
        })->name('admin.pengumuman');
        Route::get('/laporan', function () {
            return view('admin.laporan');
        })->name('admin.laporan');
    });

    // User routes
    Route::middleware(['cekRole:user'])->group(function () {

        Route::get('/biodata',  [BiodataController::class, 'index'])->name('user.biodata');
        Route::get('/dokumen', function () {
            return view('user.dokumen');
        })->name('user.dokumen');
        Route::get('/status', function () {
            return view('user.status');
        })->name('user.status');
        Route::get('/daftar-ulang', function () {
            return view('user.daftar_ulang');
        })->name('user.daftar_ulang');
    });
});
