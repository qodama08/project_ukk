# Bimbingan Konseling SMK Antartika 1 Sidoarjo

Aplikasi Bimbingan Konseling (BK) berbasis web untuk SMK Antartika 1 Sidoarjo. Sistem ini membantu pengelolaan data siswa, guru BK, pelanggaran, prestasi, jadwal konseling, dan catatan konseling secara terintegrasi.
## Fitur Utama
- **Manajemen Siswa**: CRUD data siswa, detail profil, dan pencarian.
- **Manajemen Guru BK**: CRUD data guru BK (khusus admin), siswa dapat melihat daftar guru BK.
- **Pelanggaran**: Pencatatan dan pengelolaan pelanggaran siswa.
- **Prestasi**: Pencatatan dan pengelolaan prestasi siswa.
- **Jadwal Konseling**: Siswa dapat mengajukan jadwal konseling, admin dapat mengelola dan memverifikasi jadwal.
- **Catatan Konseling**: Pencatatan hasil konseling oleh guru/admin.
- **Notifikasi**: Admin menerima notifikasi jika ada pengajuan jadwal konseling baru.
- **Role & Hak Akses**: Terdapat role Admin, Guru BK, dan Siswa/User dengan hak akses berbeda.
- **Autentikasi**: Login, register, verifikasi email, dan reset password.

## Hak Akses
- **Admin**: Semua fitur, termasuk CRUD Guru BK, Siswa, Pelanggaran, Prestasi, Jadwal & Catatan Konseling.
- **Guru BK**: Melihat data, mengelola catatan konseling.
- **Siswa/User**: Melihat data, mengajukan jadwal konseling, melihat catatan dan prestasi.

## Instalasi
1. Clone repository ini.
2. Jalankan `composer install` dan `npm install`.
3. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi database.
4. Jalankan `php artisan key:generate`.
5. Jalankan migrasi dan seeder:
    ```
    php artisan migrate --seed
    ```
6. Jalankan server lokal:
    ```
    php artisan serve
    ```
7. Akses aplikasi di `http://127.0.0.1:8000`

## Struktur Folder Penting
- `app/Http/Controllers/` : Controller utama aplikasi
- `app/Models/` : Model Eloquent
- `resources/views/` : Blade template (landing page, dashboard, dll)
- `routes/web.php` : Definisi route utama
- `public/assets/` : Asset gambar, CSS, JS

## Kontribusi
Pull request dan issue sangat terbuka untuk pengembangan lebih lanjut.

## Lisensi
Aplikasi ini dikembangkan untuk kebutuhan SMK Antartika 1 Sidoarjo.
# 📂 Aplikasi PPDB with Docker – UKK 2526

> **Progress Terakhir:** Membuat fitur **SSO Login** untuk autentikasi pengguna.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-12.x-red" alt="Laravel Version">
<img src="https://img.shields.io/badge/Status-Development-orange" alt="Status">
</p>

---

# 📌 Tentang Proyek

Aplikasi **PPDB** (Penerimaan Peserta Didik Baru) adalah platform berbasis web yang membantu sekolah mengelola pendaftaran siswa baru secara **online**.

## 🎯 Tujuan Utama

-   **Efisiensi:** Mengurangi antrian dan pekerjaan manual saat proses pendaftaran.
-   **Transparansi:** Mempermudah verifikasi dan pelaporan data pendaftar.
-   **Kemudahan Akses:** Calon siswa dapat mendaftar dari mana saja.
-   **Mengurangi Human Error:** Mengurangi kesalahan input data.

## 👥 Pengguna Utama


# Bimbingan Konseling SMK Antartika 1 Sidoarjo

Aplikasi Bimbingan Konseling (BK) berbasis web untuk SMK Antartika 1 Sidoarjo. Sistem ini membantu pengelolaan data siswa, guru BK, pelanggaran, prestasi, jadwal konseling, dan catatan konseling secara terintegrasi.

## Fitur Utama
- **Manajemen Siswa**: CRUD data siswa, detail profil, dan pencarian.
- **Manajemen Guru BK**: CRUD data guru BK (khusus admin), siswa dapat melihat daftar guru BK.
- **Pelanggaran**: Pencatatan dan pengelolaan pelanggaran siswa.
- **Prestasi**: Pencatatan dan pengelolaan prestasi siswa.
- **Jadwal Konseling**: Siswa dapat mengajukan jadwal konseling, admin dapat mengelola dan memverifikasi jadwal.
- **Catatan Konseling**: Pencatatan hasil konseling oleh guru/admin.
- **Notifikasi**: Admin menerima notifikasi jika ada pengajuan jadwal konseling baru.
- **Role & Hak Akses**: Terdapat role Admin, Guru BK, dan Siswa/User dengan hak akses berbeda.
- **Autentikasi**: Login, register, verifikasi email, dan reset password.

## Hak Akses
- **Admin**: Semua fitur, termasuk CRUD Guru BK, Siswa, Pelanggaran, Prestasi, Jadwal & Catatan Konseling.
- **Guru BK**: Melihat data, mengelola catatan konseling.
- **Siswa/User**: Melihat data, mengajukan jadwal konseling, melihat catatan dan prestasi.

## Instalasi
1. Clone repository ini.
2. Jalankan `composer install` dan `npm install`.
3. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi database.
4. Jalankan `php artisan key:generate`.
5. Jalankan migrasi dan seeder:
    ```
    php artisan migrate --seed
    ```
6. Jalankan server lokal:
    ```
    php artisan serve
    ```
7. Akses aplikasi di `http://127.0.0.1:8000`

## Struktur Folder Penting
- `app/Http/Controllers/` : Controller utama aplikasi
- `app/Models/` : Model Eloquent
- `resources/views/` : Blade template (landing page, dashboard, dll)
- `routes/web.php` : Definisi route utama
- `public/assets/` : Asset gambar, CSS, JS

## Kontribusi
Pull request dan issue sangat terbuka untuk pengembangan lebih lanjut.

## Lisensi
Aplikasi ini dikembangkan untuk kebutuhan SMK Antartika 1 Sidoarjo.

