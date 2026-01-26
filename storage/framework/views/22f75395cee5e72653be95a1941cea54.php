

<?php $__env->startSection('title', 'Detail Laporan Masalah'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/laporan_masalah">Laporan Masalah</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Detail Laporan Masalah</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Informasi Laporan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Nama Siswa:</strong></label>
                            <p><?php echo e($laporan->siswa->name); ?></p>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Kelas:</strong></label>
                            <p><?php echo e($laporan->kelas->nama_kelas ?? '-'); ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label><strong>Tanggal Kejadian:</strong></label>
                            <p><?php echo e($laporan->tanggal_kejadian->format('d-m-Y')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Jam Pelajaran:</strong></label>
                            <p><?php echo e($laporan->jam_pelajaran); ?></p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><strong>Mata Pelajaran:</strong></label>
                        <p><?php echo e($laporan->mata_pelajaran); ?></p>
                    </div>

                    <div class="mb-3">
                        <label><strong>Guru Mata Pelajaran:</strong></label>
                        <p><?php echo e($laporan->guruMapel->name ?? '-'); ?></p>
                    </div>

                    <div class="mb-3">
                        <label><strong>Deskripsi Masalah:</strong></label>
                        <div class="p-3 border rounded">
                            <?php echo e($laporan->deskripsi_masalah); ?>

                        </div>
                    </div>

                    <?php if($laporan->tindakan_guru): ?>
                        <div class="mb-3">
                            <label><strong>Tindakan Guru:</strong></label>
                            <div class="p-3 border rounded">
                                <?php echo e($laporan->tindakan_guru); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($laporan->catatan_wali_kelas): ?>
                <div class="card mb-4">
                    <div class="card-header bg-info">
                        <h5>Catatan Guru Wali Kelas</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Guru Wali Kelas:</strong> <?php echo e($laporan->guruWaliKelas->name ?? '-'); ?></p>
                        <p><strong>Diterima pada:</strong> <?php echo e($laporan->diterima_wali_at?->format('d-m-Y H:i') ?? '-'); ?></p>
                        <div class="p-3 border rounded">
                            <?php echo e($laporan->catatan_wali_kelas); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($laporan->catatan_admin): ?>
                <div class="card mb-4">
                    <div class="card-header bg-warning">
                        <h5>Catatan Admin</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Admin:</strong> <?php echo e($laporan->admin->name ?? '-'); ?></p>
                        <p><strong>Ditanggani pada:</strong> <?php echo e($laporan->ditanggani_admin_at?->format('d-m-Y H:i') ?? '-'); ?></p>
                        <div class="p-3 border rounded">
                            <?php echo e($laporan->catatan_admin); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Status Laporan</h5>
                </div>
                <div class="card-body">
                    <?php
                        $statusClass = 'bg-secondary';
                        $statusLabel = $laporan->status;
                        
                        if ($laporan->status === 'baru') {
                            $statusClass = 'bg-info';
                            $statusLabel = 'Baru';
                        } elseif ($laporan->status === 'diterima_wali') {
                            $statusClass = 'bg-warning text-dark';
                            $statusLabel = 'Diterima Wali Kelas';
                        } elseif ($laporan->status === 'diteruskan_admin') {
                            $statusClass = 'bg-primary';
                            $statusLabel = 'Diteruskan ke Admin';
                        } elseif ($laporan->status === 'ditanggani') {
                            $statusClass = 'bg-warning text-dark';
                            $statusLabel = 'Sedang Ditanggani Admin';
                        } elseif ($laporan->status === 'selesai') {
                            $statusClass = 'bg-success';
                            $statusLabel = 'Selesai';
                        }
                    ?>
                    <p class="mb-3"><span class="badge <?php echo e($statusClass); ?>" style="font-size: 16px; padding: 10px;"><?php echo e($statusLabel); ?></span></p>

                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon bg-info">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Laporan Dibuat</h6>
                                <small><?php echo e($laporan->created_at->format('d-m-Y H:i')); ?></small>
                            </div>
                        </div>

                        <?php if($laporan->diterima_wali_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-warning">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Diterima Wali Kelas</h6>
                                    <small><?php echo e($laporan->diterima_wali_at->format('d-m-Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($laporan->diteruskan_admin_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-primary">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Diteruskan ke Admin</h6>
                                    <small><?php echo e($laporan->diteruskan_admin_at->format('d-m-Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($laporan->ditanggani_admin_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-warning">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Ditanggani Admin</h6>
                                    <small><?php echo e($laporan->ditanggani_admin_at->format('d-m-Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($laporan->selesai_at): ?>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Selesai</h6>
                                    <small><?php echo e($laporan->selesai_at->format('d-m-Y H:i')); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="<?php echo e(route('laporan_masalah.index')); ?>" class="btn btn-secondary btn-block">Kembali</a>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 20px;
        position: relative;
    }

    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .timeline-content h6 {
        margin: 0;
        font-weight: 600;
    }

    .timeline-content small {
        display: block;
        color: #666;
        margin-top: 5px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/laporan_masalah/show.blade.php ENDPATH**/ ?>