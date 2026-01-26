<?php $__env->startSection('title', 'Data Pelanggaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Pelanggaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">Data Pelanggaran</h2>
    <?php
      $isAdmin = auth()->check() && auth()->user()->role == 'admin';
    ?>
    <?php if($isAdmin): ?>
      <div class="mb-3 text-end">
        <a href="/pelanggaran/create" class="btn btn-primary">+ Buat Pelanggaran</a>
      </div>
    <?php endif; ?>
    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nama Siswa</th>
          <th>Kelas</th>
          <th>Absen</th>
          <th>Nama Pelanggaran</th>
          <th>Poin</th>
          <th>Total Poin</th>
          <th>Tingkat</th>
          <?php if($isAdmin): ?>
            <th>Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $totalPoin = \App\Models\Pelanggaran::where('siswa_id', $it->siswa_id)->sum('poin');
          $siswaProgressClass = $totalPoin >= 100 ? 'bg-danger text-white' : ($totalPoin >= 80 ? 'bg-warning' : 'bg-light');
        ?>
        <tr>
          <td><?php echo e($loop->iteration); ?></td>
          <td><strong><?php echo e($it->nama_siswa ?? ($it->user->name ?? '-')); ?></strong></td>
          <td><?php echo e($it->kelas ?? '-'); ?></td>
          <td><?php echo e($it->absen ?? '-'); ?></td>
          <td><?php echo e($it->nama_pelanggaran); ?></td>
          <td><?php echo e($it->poin); ?></td>
          <td>
            <span class="badge <?php echo e($siswaProgressClass); ?>"><?php echo e($totalPoin); ?>/100</span>
          </td>
          <td>
            <?php if($it->tingkat_warna == 'hijau'): ?>
              <span class="badge bg-success">Hijau</span>
            <?php elseif($it->tingkat_warna == 'kuning'): ?>
              <span class="badge bg-warning">Kuning</span>
            <?php elseif($it->tingkat_warna == 'merah'): ?>
              <span class="badge bg-danger">Merah</span>
            <?php endif; ?>
          </td>
          <?php if($isAdmin): ?>
            <td>
              <a href="/pelanggaran/<?php echo e($it->id); ?>/edit" class="btn btn-sm btn-warning">Edit</a>
              <form action="/pelanggaran/<?php echo e($it->id); ?>" method="POST" style="display:inline-block">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pelanggaran ini?')">Hapus</button>
              </form>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="<?php echo e($isAdmin ? 9 : 8); ?>" class="text-center text-muted">Belum ada data pelanggaran</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/pelanggaran/index.blade.php ENDPATH**/ ?>