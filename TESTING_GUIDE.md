# 🧪 TESTING GUIDE - Aplikasi BK UKK

Panduan untuk melakukan testing manual pada aplikasi agar semuanya berjalan dengan baik.

---

## 1️⃣ Testing Authentication

### Test Login ✅
```
Steps:
1. Buka http://127.0.0.1:8000/login
2. Masukkan email: admin@gmail.com (atau email terregistrasi)
3. Masukkan password: password123 (atau password terdaftar)
4. Click "Login"
Expected: Redirect ke /dashboard
```

### Test Register ✅
```
Steps:
1. Buka http://127.0.0.1:8000/register
2. Isi form dengan data baru (nama, email, password, confirm password)
3. Click "Register"
Expected: Redirect ke login dengan pesan "Registration successful!"
```

### Test Forgot Password ✅
```
Steps:
1. Buka http://127.0.0.1:8000/forgot-password
2. Masukkan email yang terdaftar
3. Click "Send Reset Link"
Expected: OTP dikirim via email, dapat input OTP
4. Masukkan OTP dan password baru
5. Click "Reset Password"
Expected: Password berhasil direset, bisa login dengan password baru
```

### Test Logout ✅
```
Steps:
1. Login terlebih dahulu
2. Click tombol "Logout" di navbar/profile
Expected: Redirect ke /login
```

---

## 2️⃣ Testing User Management (Admin Only)

### Test Users Index ✅
```
Steps:
1. Login sebagai admin
2. Go to /users
Expected: List semua users dengan pagination
```

### Test Create User ✅
```
Steps:
1. Go to /users/create
2. Isi form user baru
3. Click "Save"
Expected: User dibuat, redirect ke /users dengan pesan sukses
```

### Test Edit User ✅
```
Steps:
1. Go to /users
2. Click edit pada salah satu user
3. Update data
4. Click "Save"
Expected: Data user terupdate, pesan sukses ditampilkan
```

### Test Delete User ✅
```
Steps:
1. Go to /users
2. Click delete pada user
Expected: Konfirmasi ditampilkan, user dihapus setelah konfirmasi
```

---

## 3️⃣ Testing Siswa Management

### Test Siswa Index ✅
```
Steps:
1. Go to /siswa
Expected: List siswa dengan pagination (15 per halaman)
Siswa = user dengan nisn terisi
```

### Test Create Siswa ✅
```
Steps:
1. Go to /siswa/create (admin only)
2. Isi semua field required:
   - NISN (unik)
   - Name
   - Email (unik)
   - Kelas
   - Nomor Absen (unik per kelas)
   - Umur
   - Nomor HP (unik)
   - Alamat
   - Nama Ayah
   - Nama Ibu
   - Nomor HP Wali
3. Click "Save"
Expected: Siswa dibuat, redirect ke /siswa
```

### Test Validation ✅
```
Test Cases:
- Try create siswa dengan NISN duplikat → Error "NISN already exists"
- Try create siswa dengan email duplikat → Error "Email already exists"
- Try create 2 siswa dengan nomor absen sama di kelas sama → Error "Nomor absen sudah ada"
- Try create siswa tanpa field required → Error "Field required"
```

---

## 4️⃣ Testing Guru BK Management (Admin Only)

### Test Guru BK Index ✅
```
Steps:
1. Go to /guru_bk
Expected: List semua guru BK (users dengan role='admin' kecuali admin@gmail.com)
```

### Test Create Guru BK ✅
```
Steps:
1. Go to /guru_bk/create
2. Isi:
   - Name
   - Email (unik)
   - Nomor HP (unik, opsional)
3. Click "Save"
Expected: Guru BK dibuat dengan default password 'password123'
```

---

## 5️⃣ Testing Pelanggaran

### Test Pelanggaran Index ✅
```
Steps:
1. Go to /pelanggaran
Expected: List semua pelanggaran ordered by nama
```

### Test Create Pelanggaran (Admin Only) ✅
```
Steps:
1. Go to /pelanggaran/create
2. Pilih siswa
3. Isi detail pelanggaran
4. Click "Save"
Expected: Pelanggaran tersimpan
```

---

## 6️⃣ Testing Prestasi

### Test Prestasi Index ✅
```
Steps:
1. Go to /prestasi
Expected: List prestasi dengan info siswa & kelas, paginated (20 per halaman)
```

### Test Create Prestasi (Admin Only) ✅
```
Steps:
1. Go to /prestasi/create
2. Pilih siswa
3. Isi nama prestasi & keterangan
4. Upload gambar (optional) - Max 5MB
5. Click "Save"
Expected: Prestasi tersimpan dengan atau tanpa gambar
```

### Test Image Upload ✅
```
Test Cases:
- Upload gambar format jpg/png/gif → Success
- Upload file > 5MB → Error "File too large"
- Upload file bukan image → Error "Invalid file type"
- Update prestasi dengan gambar baru → Gambar lama dihapus, gambar baru tersimpan
```

---

## 7️⃣ Testing Jadwal Konseling

### Test Schedule Visibility ✅
```
Steps:
- Login sebagai siswa
- Go to /jadwal_konseling
Expected: Hanya tampil jadwal milik siswa tersebut

- Login sebagai admin
- Go to /jadwal_konseling
Expected: Tampil semua jadwal konseling
```

### Test Create Schedule ✅
```
Steps (Siswa):
1. Go to /jadwal_konseling/create
2. Isi:
   - Nama Siswa (auto-fill dari user login)
   - Kelas
   - Nomor Absen
   - Tanggal (tidak boleh sebelum hari ini)
   - Jam
   - Tempat (opsional)
   - Pilih Guru BK
3. Click "Save"
Expected: Schedule dibuat dengan status 'pending'
         CatatanKonseling auto-created
         Notifikasi sent to all admins
```

### Test Authorization ✅
```
Test Cases:
- Siswa A try edit schedule milik Siswa B → Error 403 Unauthorized
- Siswa A try delete schedule milik Siswa B → Error 403 Unauthorized
- Admin dapat edit/delete semua schedule
```

---

## 8️⃣ Testing Catatan Konseling

### Test Notes Visibility ✅
```
- Admin melihat notes yang mereka handle
- Siswa dapat melihat semua notes
```

### Test Create Notes (Admin Only) ✅
```
Steps:
1. Go to /catatan_konseling/create
2. Isi hasil konseling, tindak lanjut, evaluasi
3. Click "Save"
Expected: Catatan tersimpan, dapat di-approve
```

---

## 9️⃣ Testing Dashboard & Profile

### Test Dashboard ✅
```
Steps:
1. Login
2. Should redirect to /dashboard
Expected: Dashboard ditampilkan
```

### Test Profile ✅
```
Steps:
1. Click profile menu
2. Go to /myprofile
Expected: Profil user ditampilkan
```

---

## 🔟 Testing Notifications (Admin Only)

### Test Notifications Index ✅
```
Steps:
1. Login sebagai admin
2. Go to /notifikasi
Expected: List notifikasi paginated (30 per halaman)
```

### Test Mark as Read ✅
```
Steps:
1. Click pada notification
Expected: Status berubah dari unread ke read
```

---

## 1️⃣1️⃣ Testing BK AI Chatbot

### Test Chat Interface ✅
```
Steps:
1. Login
2. Go to /bk-ai
Expected: Chat interface ditampilkan
```

### Test Send Message ✅
```
Steps:
1. Type pesan di input field
2. Click send
Expected: Pesan terkirim, response dari AI ditampilkan
```

---

## 1️⃣2️⃣ Testing Navigation & Routes

### Test Route Security ✅
```
Test Cases:
- Access /users without login → Redirect to login ✅
- Access /siswa/create as non-admin → Error 403 atau redirect ✅
- Access /dashboard after logout → Redirect to login ✅
- Access /login as authenticated user → Redirect to dashboard ✅
```

### Test Redirect to Dashboard ✅
```
Steps:
1. Login
2. Go to http://127.0.0.1:8000/
Expected: Redirect ke /dashboard
```

---

## ✅ Final Checklist

- [ ] Login & Register berjalan
- [ ] Password reset berjalan
- [ ] User management OK
- [ ] Siswa management OK
- [ ] Guru BK management OK
- [ ] Pelanggaran CRUD OK
- [ ] Prestasi CRUD OK
- [ ] Jadwal Konseling CRUD OK
- [ ] Catatan Konseling CRUD OK
- [ ] Notifications OK
- [ ] BK AI Chat OK
- [ ] Dashboard & Profile OK
- [ ] All authorization checks OK
- [ ] Validation working correctly
- [ ] Image upload working
- [ ] Pagination working
- [ ] No console errors
- [ ] No PHP errors

---

## 🎯 Kesimpulan Testing

Jika semua test cases di atas berjalan sempurna, aplikasi **SIAP UNTUK PRODUCTION**! 🚀
