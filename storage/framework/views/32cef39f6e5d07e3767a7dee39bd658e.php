<?php $__env->startSection('title', 'Data Prestasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Prestasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Prestasi</h1>
      <div>
        <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?>
          <a href="/prestasi/create" class="btn btn-primary">+ Catat Prestasi</a>
        <?php endif; ?>
      </div>
    </div>

    

    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Nama Siswa</th>
          <th>Kelas</th>
          <th>Absen</th>
          <th>Prestasi</th>
          <th>Gambar</th>
          <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?>
          <th>Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $prestasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><?php echo e($loop->iteration); ?></td>
          <td><strong><?php echo e($p->siswa->name ?? $p->nama_siswa ?? '-'); ?></strong></td>
          <td><?php echo e($p->siswa->kelas->nama_kelas ?? $p->kelas ?? '-'); ?></td>
          <td><?php echo e($p->siswa->absen ?? $p->absen ?? '-'); ?></td>
          <td><?php echo e($p->nama_prestasi ?? '-'); ?></td>
          <td>
            <?php if($p->gambar): ?>
              <img src="<?php echo e(asset('storage/' . $p->gambar)); ?>" alt="Prestasi" style="max-width: 80px; max-height: 80px; border-radius: 4px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo e($p->id); ?>">
              <!-- Modal untuk preview gambar -->
              <div class="modal fade" id="imageModal<?php echo e($p->id); ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo e($p->id); ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="imageModalLabel<?php echo e($p->id); ?>"><?php echo e($p->nama_prestasi); ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                      <img src="<?php echo e(asset('storage/' . $p->gambar)); ?>" alt="Prestasi" style="max-width: 100%; max-height: 500px;">
                    </div>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <span class="text-muted">-</span>
            <?php endif; ?>
          </td>
          <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?>
          <td>
              <a href="/prestasi/<?php echo e($p->id); ?>/edit" class="btn btn-sm btn-warning">Edit</a>
              <form action="/prestasi/<?php echo e($p->id); ?>" method="POST" style="display:inline-block">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
              </form>
          </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" class="text-center text-muted">Belum ada prestasi</td></tr>
      <?php endif; ?>
      </tbody>
    </table>

    <?php echo e($prestasis->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/prestasi/index.blade.php ENDPATH**/ ?>