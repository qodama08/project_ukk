<?php $__env->startSection('title', 'Dashboard Page'); ?>

<?php $__env->startSection('content'); ?>
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Home</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <?php
            $user = auth()->user();
            $isAdmin = $user && ($user->role == 'admin' || $user->roles()->where('nama_role','admin')->exists());
            
            // Get data untuk dashboard - sama untuk semua user
            $totalSiswa = \App\Models\User::whereHas('roles', function($q) { $q->where('nama_role', 'user'); })->whereNotNull('kelas_id')->count();
            $totalGuruBK = \App\Models\User::where('role', 'admin')->count();
            $totalJadwal = \App\Models\JadwalKonseling::count();
            $totalPrestasi = \App\Models\Prestasi::count();
        ?>

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Dashboard</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-left: 4px solid #4680ff; border-radius: 8px;">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-2" style="font-size: 0.85rem; font-weight: 500;">Total Siswa</h6>
                        <div class="h2 mb-0 text-primary" style="font-weight: 700;"><?php echo e($totalSiswa); ?></div>
                        <small class="text-muted">Siswa aktif</small>
                        <div class="mt-3">
                            <a href="<?php echo e(route('siswa.index')); ?>" class="text-primary" style="text-decoration: none; font-size: 0.9rem; font-weight: 500;">Lihat Data →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-left: 4px solid #2ed8b6; border-radius: 8px;">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-2" style="font-size: 0.85rem; font-weight: 500;">Guru BK</h6>
                        <div class="h2 mb-0" style="color: #2ed8b6; font-weight: 700;"><?php echo e($totalGuruBK); ?></div>
                        <small class="text-muted">Guru pembimbing</small>
                        <div class="mt-3">
                            <a href="<?php echo e(route('siswa.index')); ?>" class="text-success" style="text-decoration: none; font-size: 0.9rem; font-weight: 500;">Kelola →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-left: 4px solid #a0d468; border-radius: 8px;">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-2" style="font-size: 0.85rem; font-weight: 500;">Jadwal Konseling</h6>
                        <div class="h2 mb-0" style="color: #a0d468; font-weight: 700;"><?php echo e($totalJadwal); ?></div>
                        <small class="text-muted">Jadwal terjadwal</small>
                        <div class="mt-3">
                            <a href="<?php echo e(route('jadwal_konseling.index')); ?>" class="text-success" style="text-decoration: none; font-size: 0.9rem; font-weight: 500;">Lihat →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card" style="border-left: 4px solid #ffd500; border-radius: 8px;">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-2" style="font-size: 0.85rem; font-weight: 500;">Prestasi</h6>
                        <div class="h2 mb-0" style="color: #ffd500; font-weight: 700;"><?php echo e($totalPrestasi); ?></div>
                        <small class="text-muted">Pencapaian siswa</small>
                        <div class="mt-3">
                            <a href="<?php echo e(route('prestasi.index')); ?>" class="text-warning" style="text-decoration: none; font-size: 0.9rem; font-weight: 500;">Lihat →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h5 class="mb-3" style="font-weight: 600;">Kelola Fitur</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('pelanggaran.index')); ?>" class="text-decoration-none">
                        <div class="card h-100" style="border-radius: 8px; transition: all 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem;">⛔</div>
                                <h6 class="card-title mb-0" style="font-weight: 600; color: #333;">Pelanggaran</h6>
                                <small class="text-muted">Kelola pelanggaran siswa</small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('prestasi.index')); ?>" class="text-decoration-none">
                        <div class="card h-100" style="border-radius: 8px; transition: all 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem;">🏆</div>
                                <h6 class="card-title mb-0" style="font-weight: 600; color: #333;">Prestasi</h6>
                                <small class="text-muted">Pencapaian siswa</small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('jadwal_konseling.index')); ?>" class="text-decoration-none">
                        <div class="card h-100" style="border-radius: 8px; transition: all 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem;">📅</div>
                                <h6 class="card-title mb-0" style="font-weight: 600; color: #333;">Jadwal Konseling</h6>
                                <small class="text-muted">Atur jadwal konseling</small>
                            </div>
                        </div>
                    </a>
                </div>

                <?php if($isAdmin || $user->roles()->where('nama_role', 'guru_wali_kelas')->exists()): ?>
                <div class="col-md-3 mb-3">
                    <a href="<?php echo e(route('attendance.index')); ?>" class="text-decoration-none">
                        <div class="card h-100" style="border-radius: 8px; transition: all 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem;">✅</div>
                                <h6 class="card-title mb-0" style="font-weight: 600; color: #333;">Kehadiran</h6>
                                <small class="text-muted">Catat kehadiran siswa</small>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <style>
            .card {
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                border: none;
            }
            .card:hover {
                box-shadow: 0 0.3rem 3.5rem 0 rgba(58, 59, 69, 0.25);
                transform: translateY(-2px);
            }
        </style>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/dashboard.blade.php ENDPATH**/ ?>