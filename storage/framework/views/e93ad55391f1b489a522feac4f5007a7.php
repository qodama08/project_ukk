<?php $__env->startComponent('mail::message'); ?>
# Peringatan: Poin Pelanggaran Mencapai Batas Maksimal

Halo <?php echo new \Illuminate\Support\EncodedHtmlString($siswa->name); ?>,

Kami ingin memberitahukan bahwa poin pelanggaran Anda telah mencapai batas maksimal **100 poin**.

**Informasi Siswa:**
- Nama: <?php echo new \Illuminate\Support\EncodedHtmlString($siswa->name); ?>

- Email: <?php echo new \Illuminate\Support\EncodedHtmlString($siswa->email); ?>

- Kelas: <?php echo new \Illuminate\Support\EncodedHtmlString($siswa->kelas->nama_kelas ?? '-'); ?>

- Absen: <?php echo new \Illuminate\Support\EncodedHtmlString($siswa->absen ?? '-'); ?>

- Total Poin Pelanggaran: **<?php echo new \Illuminate\Support\EncodedHtmlString($totalPoin); ?> poin**

Anda telah mencapai batas maksimal poin pelanggaran. Mohon segera menemui guru BK untuk penanganan lebih lanjut.

Terima kasih,<br>
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\PC_\bk_ukk2526\resources\views/emails/pelanggaran_threshold.blade.php ENDPATH**/ ?>