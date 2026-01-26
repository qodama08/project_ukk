

<?php $__env->startSection('title', 'Catat Kehadiran Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/attendance">Kehadiran Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Catat Kehadiran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Catat Kehadiran Siswa</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('attendance.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Informasi Kehadiran</h5>
            </div>
            <div class="card-body">
                <div class="mb-4 p-3 border rounded bg-light">
                    <p><strong>Kelas:</strong> <?php echo e($kelas->nama_kelas); ?></p>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" required value="<?php echo e(old('tanggal')); ?>">
                </div>

                <div id="entries-container">
                    <div class="entry-row mb-4 p-3 border rounded">
                        <h6 class="mb-3">Siswa #1</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                                    <select name="entries[0][siswa_id]" class="form-control" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?> (<?php echo e($s->absen ?? '-'); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="entries[0][status]" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="hadir">Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="alfa">Alfa</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="entries[0][keterangan]" class="form-control" placeholder="Contoh: Sakit flu, dll">
                        </div>

                        <button type="button" class="btn btn-sm btn-danger remove-entry" onclick="removeEntry(this)">Hapus Baris</button>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary mt-3" onclick="addEntry()">+ Tambah Siswa Lain</button>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan Kehadiran</button>
            <a href="<?php echo e(route('attendance.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
let entryCount = 1;

function addEntry() {
    const container = document.getElementById('entries-container');
    const html = `
        <div class="entry-row mb-4 p-3 border rounded">
            <h6 class="mb-3">Siswa #${entryCount + 1}</h6>
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa <span class="text-danger">*</span></label>
                        <select name="entries[${entryCount}][siswa_id]" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?> (<?php echo e($s->absen ?? '-'); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="entries[${entryCount}][status]" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alfa">Alfa</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" name="entries[${entryCount}][keterangan]" class="form-control" placeholder="Contoh: Sakit flu, dll">
            </div>

            <button type="button" class="btn btn-sm btn-danger remove-entry" onclick="removeEntry(this)">Hapus Baris</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    entryCount++;
}

function removeEntry(btn) {
    btn.closest('.entry-row').remove();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/attendance/form.blade.php ENDPATH**/ ?>