<?php $__env->startSection('title', isset($note) ? 'Edit Catatan Konseling' : 'Buat Catatan Konseling'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/catatan_konseling">Catatan Konseling</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e(isset($note) ? 'Edit' : 'Buat'); ?> Catatan Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4"><?php echo e(isset($note) ? 'Edit' : 'Buat'); ?> Catatan Konseling</h2>
    <form method="POST" action="<?php echo e(isset($note) ? url('/catatan_konseling/'.$note->id) : url('/catatan_konseling')); ?>">
      <?php echo csrf_field(); ?>
      <?php if(isset($note)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
      <div class="mb-3">
        <label class="form-label">Jadwal Konseling</label>
        <select id="jadwal_id" name="jadwal_id" class="form-control <?php $__errorArgs = ['jadwal_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" onchange="loadJadwalDetails()" required>
          <option value="">-- Pilih Jadwal Konseling --</option>
          <?php $__currentLoopData = App\Models\JadwalKonseling::with('siswa','guru','catatan')->orderBy('tanggal','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($j->id); ?>" data-siswa="<?php echo e($j->nama_siswa ?? ($j->siswa->name ?? '-')); ?>" data-guru="<?php echo e($j->guru->name ?? '-'); ?>" <?php echo e((old('jadwal_id', $note->jadwal_id ?? '')==$j->id)?'selected':''); ?>>#<?php echo e($j->id); ?> - <?php echo e($j->nama_siswa ?? $j->siswa->name ?? '-'); ?> (<?php echo e($j->tanggal); ?>) <?php echo e($j->jam); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['jadwal_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Siswa</label>
        <input type="text" id="siswa_name" class="form-control" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Guru BK</label>
        <input type="text" id="guru_name" class="form-control" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Hasil</label>
        <textarea name="hasil" class="form-control <?php $__errorArgs = ['hasil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('hasil', $note->hasil ?? '')); ?></textarea>
        <?php $__errorArgs = ['hasil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <button class="btn btn-primary">Simpan</button>
      <a href="/catatan_konseling" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script>
function loadJadwalDetails() {
  const select = document.getElementById('jadwal_id');
  const option = select.options[select.selectedIndex];
  const siswaName = option.getAttribute('data-siswa') || '';
  const guruName = option.getAttribute('data-guru') || '';
  document.getElementById('siswa_name').value = siswaName;
  document.getElementById('guru_name').value = guruName;
}
window.onload = loadJadwalDetails;
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC_\bk_ukk\resources\views/catatan_konseling/form.blade.php ENDPATH**/ ?>