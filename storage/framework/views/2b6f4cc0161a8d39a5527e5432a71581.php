<?php $__env->startSection('title', isset($item) ? 'Edit Pelanggaran' : 'Buat Pelanggaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/pelanggaran">Data Pelanggaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e(isset($item) ? 'Edit' : 'Buat'); ?> Pelanggaran</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4"><?php echo e(isset($item) ? 'Edit' : 'Buat'); ?> Pelanggaran</h2>
    
    <?php if(isset($item) && $item->siswa_id): ?>
      <?php
        $totalPoinSiswa = \App\Models\Pelanggaran::where('siswa_id', $item->siswa_id)->sum('poin');
      ?>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo e(isset($item) ? url('/pelanggaran/'.$item->id) : url('/pelanggaran')); ?>">
      <?php echo csrf_field(); ?>
      <?php if(isset($item)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
      
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
              <?php
                $isMasximum = $s->total_poin >= 100 && (!isset($item) || $item->siswa_id != $s->id);
                $disabledAttr = $isMasximum ? 'disabled' : '';
              ?>
                <option value="<?php echo e($s->id); ?>" <?php echo e(old('siswa_id') == $s->id || (isset($item) && $item->siswa_id == $s->id) ? 'selected' : ''); ?> <?php echo e($disabledAttr); ?>>
                    <?php echo e($s->name); ?> | <?php echo e($s->kelas->nama_kelas ?? '-'); ?> | <?php echo e($s->absen ?? '-'); ?>

                    <?php if($s->total_poin > 0): ?>
                      (<?php echo e($s->total_poin); ?>/100 poin)
                    <?php endif; ?>
                    <?php if($isMasximum): ?>
                      - MAKSIMAL
                    <?php endif; ?>
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
        <small class="form-text text-muted d-block mt-2">Siswa yang sudah mencapai 100 poin tidak bisa dipilih</small>
      </div>
      
      <?php if(isset($item) && $item->siswa_id): ?>
        <?php
          $siswaItem = \App\Models\User::find($item->siswa_id);
          $totalPoin = \App\Models\Pelanggaran::where('siswa_id', $item->siswa_id)->sum('poin');
        ?>
        <div class="alert alert-info mb-3">
          <strong>Status Poin Siswa <?php echo e($siswaItem->name ?? ''); ?>:</strong> 
          <span class="badge bg-primary"><?php echo e($totalPoin); ?>/100 poin</span>
          <?php if($totalPoin >= 100): ?>
            <div class="mt-2 text-danger"><strong>⚠️ Siswa sudah mencapai poin maksimal (100 poin). Tidak bisa menambahkan poin lagi.</strong></div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label">Nama Pelanggaran</label>
        <input name="nama_pelanggaran" class="form-control <?php $__errorArgs = ['nama_pelanggaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama_pelanggaran', $item->nama_pelanggaran ?? '')); ?>" required>
        <?php $__errorArgs = ['nama_pelanggaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Poin</label>
        <input name="poin" type="number" class="form-control <?php $__errorArgs = ['poin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('poin', $item->poin ?? 0)); ?>" required>
        <?php $__errorArgs = ['poin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Tingkat Warna</label>
        <select name="tingkat_warna" class="form-control <?php $__errorArgs = ['tingkat_warna'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
          <option value="">-- Pilih Tingkat Warna --</option>
          <option value="hijau" <?php echo e((old('tingkat_warna', $item->tingkat_warna ?? '')=='hijau')?'selected':''); ?>>Hijau</option>
          <option value="kuning" <?php echo e((old('tingkat_warna', $item->tingkat_warna ?? '')=='kuning')?'selected':''); ?>>Kuning</option>
          <option value="merah" <?php echo e((old('tingkat_warna', $item->tingkat_warna ?? '')=='merah')?'selected':''); ?>>Merah</option>
        </select>
        <?php $__errorArgs = ['tingkat_warna'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="/pelanggaran" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\bk_ukk2526\resources\views/pelanggaran/form.blade.php ENDPATH**/ ?>