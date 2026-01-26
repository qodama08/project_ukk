

<?php $__env->startSection('title', 'Laporan Masalah'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Laporan Masalah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Laporan Masalah Siswa</h1>
        <div>
            <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_mapel')->exists()): ?>
                <a href="/laporan_masalah/create" class="btn btn-primary">Buat Laporan</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if($laporan->count() > 0): ?>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Mata Pelajaran</th>
                    <th>Guru Mapel</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($l->siswa->name ?? '-'); ?></td>
                        <td><?php echo e($l->kelas->nama_kelas ?? '-'); ?></td>
                        <td><?php echo e($l->tanggal_kejadian->format('d-m-Y')); ?></td>
                        <td><?php echo e($l->jam_pelajaran); ?></td>
                        <td><?php echo e($l->mata_pelajaran); ?></td>
                        <td><?php echo e($l->guruMapel->name ?? '-'); ?></td>
                        <td>
                            <?php
                                $statusClass = 'bg-secondary';
                                $statusLabel = $l->status;
                                
                                if ($l->status === 'baru') {
                                    $statusClass = 'bg-info';
                                    $statusLabel = 'Baru';
                                } elseif ($l->status === 'diterima_wali') {
                                    $statusClass = 'bg-warning text-dark';
                                    $statusLabel = 'Diterima Wali';
                                } elseif ($l->status === 'diteruskan_admin') {
                                    $statusClass = 'bg-primary';
                                    $statusLabel = 'Diteruskan Admin';
                                } elseif ($l->status === 'ditanggani') {
                                    $statusClass = 'bg-warning text-dark';
                                    $statusLabel = 'Ditanggani';
                                } elseif ($l->status === 'selesai') {
                                    $statusClass = 'bg-success';
                                    $statusLabel = 'Selesai';
                                }
                            ?>
                            <span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
                        </td>
                        <td>
                            <a href="/laporan_masalah/<?php echo e($l->id); ?>" class="btn btn-sm btn-info">Detail</a>
                            
                            <?php if($l->status === 'baru' && auth()->check() && auth()->user()->waliKelas && auth()->user()->waliKelas->id === $l->kelas_id): ?>
                                <a href="/laporan_masalah/<?php echo e($l->id); ?>/terima" class="btn btn-sm btn-success">Terima</a>
                            <?php endif; ?>
                            
                            <?php if($l->status === 'diterima_wali' && auth()->check() && auth()->user()->waliKelas && auth()->user()->waliKelas->id === $l->kelas_id): ?>
                                <a href="/laporan_masalah/<?php echo e($l->id); ?>/teruskan" class="btn btn-sm btn-primary">Teruskan</a>
                            <?php endif; ?>
                            
                            <?php if(in_array($l->status, ['diteruskan_admin', 'ditanggani']) && auth()->check() && auth()->user()->role === 'admin'): ?>
                                <a href="/laporan_masalah/<?php echo e($l->id); ?>/handle" class="btn btn-sm btn-warning">Handle</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php echo e($laporan->links()); ?>

    <?php else: ?>
        <div class="alert alert-info">
            Belum ada laporan masalah.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/laporan_masalah/index.blade.php ENDPATH**/ ?>