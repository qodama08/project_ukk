<?php $__env->startSection('title', 'Jadwal Konseling'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jadwal Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Jadwal Konseling</h1>
      <div>
        <?php if(auth()->check() && !auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?>
          <a href="/jadwal_konseling/create" class="btn btn-primary">Ajukan Konseling</a>
        <?php endif; ?>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr><th>#</th><th>Nama Siswa</th><th>Kelas</th><th>Absen</th><th>Guru</th><th>Tanggal</th><th>Jam</th><th>Status</th><th>Alasan Batal</th><?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?><th>Actions</th><?php endif; ?></tr>
      </thead>
      <tbody>
      <?php $__currentLoopData = $jadwals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><?php echo e($loop->iteration); ?></td>
          <td><?php echo e($j->nama_siswa ?? $j->siswa->name ?? '-'); ?></td>
          <td><?php echo e($j->kelas ?? '-'); ?></td>
          <td><?php echo e($j->absen ?? '-'); ?></td>
          <td><?php echo e($j->guru->name ?? '-'); ?></td>
          <td><?php echo e($j->tanggal); ?></td>
          <td><?php echo e($j->jam); ?></td>
          <td>
            <?php
              $statusClass = 'bg-secondary';
              if ($j->status == 'pending') $statusClass = 'bg-warning text-dark';
              elseif ($j->status == 'terjadwal') $statusClass = 'bg-primary';
              elseif ($j->status == 'selesai') $statusClass = 'bg-success';
              elseif ($j->status == 'batal') $statusClass = 'bg-danger';
              $statusLabels = [
                'pending' => 'Menunggu',
                'terjadwal' => 'Terjadwal',
                'selesai' => 'Selesai',
                'batal' => 'Batal'
              ];
              $statusLabel = $statusLabels[$j->status] ?? ucwords(str_replace('_',' ',$j->status));
            ?>
            <span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
          </td>
          <td>
            <?php if($j->status == 'batal' && $j->alasan_batal): ?>
              <span data-bs-toggle="tooltip" title="<?php echo e($j->alasan_batal); ?>"><?php echo e(strlen($j->alasan_batal) > 20 ? substr($j->alasan_batal, 0, 20) . '...' : $j->alasan_batal); ?></span>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?>
          <td>
            <div class="btn-group" role="group">
              
              <?php if($j->status == 'pending' || $j->status == 'terjadwal'): ?>
                  <form action="<?php echo e(url('/jadwal_konseling/'.$j->id.'/set_status')); ?>" method="POST" style="display:inline-block">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status" value="selesai">
                    <button class="btn btn-sm btn-success" title="Tandai jadwal sebagai selesai">Set Selesai</button>
                  </form>
                  <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal<?php echo e($j->id); ?>" title="Batalkan jadwal dengan alasan">Batal</button>
              <?php endif; ?>
              <?php if($j->status == 'batal' && $j->alasan_batal): ?>
                  <button class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="<?php echo e($j->alasan_batal); ?>">Info Batal</button>
              <?php endif; ?>
            </div>
          </td>
          <?php endif; ?>
        </tr>

        
        <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?>
        <div class="modal fade" id="cancelModal<?php echo e($j->id); ?>" tabindex="-1" aria-labelledby="cancelModalLabel<?php echo e($j->id); ?>" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel<?php echo e($j->id); ?>">Batalkan Jadwal Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="<?php echo e(route('jadwal_konseling.cancel', $j->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                  <p><strong>Siswa:</strong> <?php echo e($j->nama_siswa ?? $j->siswa->name ?? '-'); ?></p>
                  <p><strong>Tanggal:</strong> <?php echo e($j->tanggal); ?> <?php echo e($j->jam); ?></p>
                  <div class="mb-3">
                    <label for="alasan<?php echo e($j->id); ?>" class="form-label">Alasan Pembatalan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="alasan<?php echo e($j->id); ?>" name="alasan_batal" rows="3" placeholder="Masukkan alasan pembatalan jadwal konseling..." required></textarea>
                    <small class="form-text text-muted">Minimal 5 karakter, maksimal 500 karakter</small>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-danger">Batalkan Jadwal</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
</div>

<script>
$(document).ready(function(){
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\bk_ukk2526\resources\views/jadwal_konseling/index.blade.php ENDPATH**/ ?>