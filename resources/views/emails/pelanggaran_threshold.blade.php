@component('mail::message')
# Peringatan: Poin Pelanggaran Mencapai Batas Maksimal

Halo {{ $siswa->name }},

Kami ingin memberitahukan bahwa poin pelanggaran Anda telah mencapai batas maksimal **100 poin**.

**Informasi Siswa:**
- Nama: {{ $siswa->name }}
- Email: {{ $siswa->email }}
- Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}
- Absen: {{ $siswa->absen ?? '-' }}
- Total Poin Pelanggaran: **{{ $totalPoin }} poin**

Anda telah mencapai batas maksimal poin pelanggaran. Mohon segera menemui guru BK untuk penanganan lebih lanjut.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
