<?php $__env->startSection('title', 'Data Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Data Siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-2">Data Siswa</h2>
    <?php
      $isAdmin = auth()->check() && auth()->user()->role == 'admin';
    ?>
    <?php if($isAdmin): ?>
      <div class="mb-2 text-end">
        <a href="/siswa/create" class="btn btn-primary">+ Tambah Siswa</a>
      </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
      <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <div class="table-responsive">
      <table class="table table-striped table-hover table-sm">
        <thead class="table-dark" style="font-weight: 600; font-size: 0.95rem; letter-spacing: 0.3px;">
          <tr>
            <th style="padding: 12px 8px; text-align: center; width: 5%;">#</th>
            <th style="padding: 12px 8px;">Nama</th>
            <?php if($isAdmin): ?>
              <th style="padding: 12px 8px; text-align: center;">Aksi</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td style="padding: 10px 8px; text-align: center; vertical-align: middle;"><?php echo e($loop->iteration); ?></td>
            <td style="padding: 10px 8px; vertical-align: middle;"><strong><?php echo e($s->name); ?> | <?php echo e($s->kelas->nama_kelas ?? '-'); ?> | <?php echo e($s->absen ?? '-'); ?></strong></td>
            <?php if($isAdmin): ?>
              <td style="padding: 10px 8px; text-align: center; vertical-align: middle;">
                <a href="/siswa/<?php echo e($s->id); ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                <form action="/siswa/<?php echo e($s->id); ?>" method="POST" style="display:inline-block">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus siswa ini?')">Hapus</button>
                </form>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="<?php echo e($isAdmin ? 3 : 2); ?>" class="text-center text-muted py-2">Belum ada data siswa</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?php if($siswa->hasPages()): ?>
      <div class="mt-2">
        <?php echo e($siswa->links()); ?>

      </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bk_ukk\resources\views/user/siswa/index.blade.php ENDPATH**/ ?>