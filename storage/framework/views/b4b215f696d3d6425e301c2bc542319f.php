<?php $__env->startSection('title', 'Daftar Guru BK'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Guru BK</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">Daftar Guru BK</h2>
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
        </div>
        <div class="col-md-4 text-end">
            <?php if(auth()->user()->role === 'admin'): ?>
                <a href="<?php echo e(route('guru_bk.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Guru BK
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if($gurus->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <?php if(auth()->user()->role === 'admin'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guru): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($guru->name); ?></td>
                            <td><?php echo e($guru->email); ?></td>
                            <td><?php echo e($guru->nomor_hp ?? '-'); ?></td>
                            <?php if(auth()->user()->role === 'admin'): ?>
                            <td>
                                <a href="<?php echo e(route('guru_bk.edit', $guru->id)); ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="<?php echo e(route('guru_bk.destroy', $guru->id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            <?php echo e($gurus->links()); ?>

        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Tidak ada Guru BK yang terdaftar
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\bk_ukk\resources\views/guru_bk/index.blade.php ENDPATH**/ ?>