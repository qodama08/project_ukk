<?php $__env->startSection('title', isset($prestasi) ? 'Edit Prestasi' : 'Catat Prestasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/prestasi">Data Prestasi</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e(isset($prestasi) ? 'Edit' : 'Catat'); ?> Prestasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4"><?php echo e(isset($prestasi) ? 'Edit' : 'Catat'); ?> Prestasi</h2>
    <form method="POST" action="<?php echo e(isset($prestasi) ? url('/prestasi/'.$prestasi->id) : url('/prestasi')); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <?php if(isset($prestasi)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Siswa (Nama | Kelas | Absen)</label>
        <select name="siswa_id" id="siswa_id" class="form-control <?php $__errorArgs = ['siswa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
            <option value="">-- Pilih Siswa --</option>
            <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s->id); ?>" <?php echo e(old('siswa_id') == $s->id ? 'selected' : ''); ?>>
                    <?php echo e($s->name); ?> | <?php echo e($s->kelas->nama_kelas ?? '-'); ?> | <?php echo e($s->absen ?? '-'); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['siswa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Prestasi</label>
        <input name="nama_prestasi" type="text" class="form-control <?php $__errorArgs = ['nama_prestasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama_prestasi', $prestasi->nama_prestasi ?? '')); ?>" required>
        <?php $__errorArgs = ['nama_prestasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea name="keterangan" class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('keterangan', $prestasi->deskripsi ?? '')); ?></textarea>
        <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Gambar Prestasi</label>
        <input type="file" name="gambar" class="form-control <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
        <small class="text-muted">Format: JPG, PNG, GIF, WebP, BMP, SVG, TIFF, ICO (Max 5MB)</small>
        <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php if(isset($prestasi) && $prestasi->gambar): ?>
          <div class="mt-2">
            <p class="text-muted">Gambar saat ini:</p>
            <img src="<?php echo e(asset('storage/' . $prestasi->gambar)); ?>" alt="Prestasi" style="max-width: 200px; max-height: 200px;">
          </div>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="/prestasi" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bk_ukk\resources\views/prestasi/form.blade.php ENDPATH**/ ?>