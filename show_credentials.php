<?php

// Setup Laravel
$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new \Symfony\Component\Console\Input\ArrayInput([
        'command' => 'tinker'
    ]),
    new \Symfony\Component\Console\Output\BufferedOutput
);

echo "=== DEMO LOGIN CREDENTIALS ===\n\n";

echo "1. ADMIN\n";
echo "Email: admin@gmail.com\n";
echo "Password: admin123\n";
echo "Akses: Admin Panel, Dashboard, Kelola Siswa, Kelola Guru\n\n";

echo "2. GURU MATA PELAJARAN (Guru Mapel)\n";
$guruMapel = \App\Models\User::where('role', 'guru_mapel')->get();
foreach ($guruMapel as $guru) {
    echo "   - Email: " . $guru->email . "\n";
    echo "     Nama: " . $guru->name . "\n";
    echo "     Password: password123\n";
}
echo "Akses: Input Kehadiran, Laporan Masalah, Lihat Data Siswa\n\n";

echo "3. GURU WALI KELAS (Guru Wali Kelas) - Demo Accounts\n";
$guruWaliKelas = \App\Models\User::where('role', 'guru_wali_kelas')
    ->where('email', 'LIKE', '%.demo.com')
    ->get();
foreach ($guruWaliKelas as $wali) {
    echo "   - Email: " . $wali->email . "\n";
    echo "     Nama: " . $wali->name . "\n";
    echo "     Kelas: " . ($wali->kelas->nama_kelas ?? '-') . "\n";
    echo "     Password: password123\n";
}
echo "Akses: Input Kehadiran, Lihat Data Siswa Kelas, Terima Laporan Masalah\n\n";

echo "4. GURU WALI KELAS - Semua Kelas\n";
$guruWaliKelasAll = \App\Models\User::where('role', 'guru_wali_kelas')->count();
echo "Total: " . $guruWaliKelasAll . " guru wali kelas untuk 15 kelas\n";
echo "Password: password123 (untuk semua)\n\n";

echo "5. SISWA (User)\n";
echo "Email: hadi.setiawan.1.3@student.com (dan 74 siswa lainnya)\n";
echo "Password: password123\n";
echo "Akses: Lihat Data Siswa, Ajukan Jadwal Konseling, Lihat Prestasi & Pelanggaran\n";
