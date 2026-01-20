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
        <tr><th>#</th><th>Nama Siswa</th><th>Kelas</th><th>Absen</th><th>Guru</th><th>Tanggal</th><th>Jam</th><th>Status</th><?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?><th>Actions</th><?php endif; ?></tr>
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
              $note = $j->catatan ?? null;
            ?>

            <?php if($note): ?>
              <?php
                $noteStatus = $note->status ?? 'pending';
                $noteBadge = ($noteStatus == 'setuju') ? 'bg-success' : 'bg-warning text-dark';
                $noteLabel = ($noteStatus == 'setuju') ? 'Disetujui' : 'Menunggu';
              ?>
              <span class="badge <?php echo e($noteBadge); ?>"><?php echo e($noteLabel); ?></span>
            <?php else: ?>
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
            <?php endif; ?>
          </td>
          <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'admin')->exists()): ?>
          <td>
            
            <?php if($j->status == 'pending'): ?>
                <form action="<?php echo e(url('/jadwal_konseling/'.$j->id.'/set_status')); ?>" method="POST" style="display:inline-block">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="status" value="selesai">
                  <button class="btn btn-sm btn-success">Set Selesai</button>
                </form>
            <?php endif; ?>
          </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bk_ukk\resources\views/jadwal_konseling/index.blade.php ENDPATH**/ ?>