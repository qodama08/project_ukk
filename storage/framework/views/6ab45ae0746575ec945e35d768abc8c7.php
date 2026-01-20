<?php $__env->startSection('title', 'Catatan Konseling'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Catatan Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Catatan Konseling</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <?php if(auth()->check() && (auth()->user()->roles()->where('nama_role', 'admin')->exists() || auth()->user()->roles()->where('nama_role', 'guru_bk')->exists())): ?>
        <a href="/catatan_konseling/create" class="btn btn-primary">Buat Catatan</a>
      <?php endif; ?>
    </div>

    <table class="table table-striped">
      <thead>
        <tr><th>#</th><th>Siswa</th><th>Guru</th><th>Hasil</th><th>Tanggal</th></tr>
      </thead>
      <tbody>
      <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><?php echo e($loop->iteration); ?></td>
          <td><?php echo e($n->siswa->name ?? ($n->jadwal->nama_siswa ?? '-')); ?></td>
          <td><?php echo e($n->jadwal->guru->name ?? $n->guru->name ?? '-'); ?></td>
            <td><?php echo e(\Illuminate\Support\Str::limit($n->hasil,60)); ?></td>
          <td><?php echo e($n->created_at); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bk_ukk\resources\views/catatan_konseling/index.blade.php ENDPATH**/ ?>