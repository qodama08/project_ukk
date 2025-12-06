<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Jurusan;

class KelasJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Jurusan
        $rpl = Jurusan::firstOrCreate(['nama_jurusan' => 'RPL']);
        $tpm = Jurusan::firstOrCreate(['nama_jurusan' => 'TPM']);
        $tkr = Jurusan::firstOrCreate(['nama_jurusan' => 'TKR']);

        // Create Kelas dengan jurusan_id
        $kelas_list = [
            ['nama_kelas' => 'XII RPL 1', 'tingkat' => 12, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $rpl->id],
            ['nama_kelas' => 'XII RPL 2', 'tingkat' => 12, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $rpl->id],
            ['nama_kelas' => 'XII RPL 3', 'tingkat' => 12, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $rpl->id],
            ['nama_kelas' => 'XII RPL 4', 'tingkat' => 12, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $rpl->id],
            ['nama_kelas' => 'XI TPM 1', 'tingkat' => 11, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tpm->id],
            ['nama_kelas' => 'XI TPM 2', 'tingkat' => 11, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tpm->id],
            ['nama_kelas' => 'XI TPM 3', 'tingkat' => 11, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tpm->id],
            ['nama_kelas' => 'X TKR 1', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
            ['nama_kelas' => 'X TKR 2', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
            ['nama_kelas' => 'X TKR 3', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
            ['nama_kelas' => 'X TKR 4', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
            ['nama_kelas' => 'X TKR 5', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
            ['nama_kelas' => 'X TKR 6', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
            ['nama_kelas' => 'X TKR 7', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
            ['nama_kelas' => 'X TKR 8', 'tingkat' => 10, 'tahun_ajaran' => '2025/2026', 'jurusan_id' => $tkr->id],
        ];

        foreach ($kelas_list as $k) {
            Kelas::updateOrCreate(
                ['nama_kelas' => $k['nama_kelas']],
                $k
            );
        }
    }
}
