

<?php $__env->startSection('title', 'Kehadiran Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kehadiran Siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Kehadiran Siswa</h1>
        <div>
            <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_wali_kelas')->exists()): ?>
                <a href="/attendance/create" class="btn btn-primary">Catat Kehadiran</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if($attendance->count() > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Guru Wali Kelas</th>
                    <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_wali_kelas')->exists()): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $attendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($a->siswa->name ?? '-'); ?></td>
                        <td><?php echo e($a->kelas->nama_kelas ?? '-'); ?></td>
                        <td><?php echo e($a->tanggal->format('d-m-Y')); ?></td>
                        <td>
                            <?php
                                $statusClass = 'bg-secondary';
                                $statusLabel = $a->status;
                                
                                if ($a->status === 'hadir') {
                                    $statusClass = 'bg-success';
                                    $statusLabel = 'Hadir';
                                } elseif ($a->status === 'izin') {
                                    $statusClass = 'bg-info';
                                    $statusLabel = 'Izin';
                                } elseif ($a->status === 'sakit') {
                                    $statusClass = 'bg-warning text-dark';
                                    $statusLabel = 'Sakit';
                                } elseif ($a->status === 'alfa') {
                                    $statusClass = 'bg-danger';
                                    $statusLabel = 'Alfa';
                                }
                            ?>
                            <span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span>
                        </td>
                        <td><?php echo e($a->keterangan ?? '-'); ?></td>
                        <td><?php echo e($a->guruWaliKelas->name ?? '-'); ?></td>
                        <?php if(auth()->check() && auth()->user()->roles()->where('nama_role', 'guru_wali_kelas')->exists() && auth()->id() === $a->guru_wali_kelas_id): ?>
                            <td>
                                <a href="/attendance/<?php echo e($a->id); ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/attendance/<?php echo e($a->id); ?>" method="POST" style="display:inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php echo e($attendance->links()); ?>

    <?php else: ?>
        <div class="alert alert-info">
            Belum ada data kehadiran.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/attendance/index.blade.php ENDPATH**/ ?>