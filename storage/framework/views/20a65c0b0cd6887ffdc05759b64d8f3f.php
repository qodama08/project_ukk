<?php $__env->startSection('title', isset($jadwal) ? (request()->routeIs('jadwal_konseling.show') ? 'Detail' : 'Edit') : 'Buat Jadwal Konseling'); ?>

<?php $__env->startSection('content'); ?>
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/jadwal_konseling">Jadwal Konseling</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e(isset($jadwal) ? (request()->routeIs('jadwal_konseling.show') ? 'Detail' : 'Edit') : 'Buat'); ?> Jadwal Konseling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4"><?php echo e(isset($jadwal) ? (request()->routeIs('jadwal_konseling.show') ? 'Detail' : 'Edit') : 'Buat'); ?> Jadwal Konseling</h2>

    <?php if($errors->has('data_incomplete')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>❌ Gagal!</strong> <?php echo e($errors->first('data_incomplete')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php
      $isReadOnly = isset($jadwal) && request()->routeIs('jadwal_konseling.show');
      $isAdmin = auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->roles()->where('nama_role','admin')->exists());
      $isSiswa = auth()->check() && !$isAdmin;
      $showForm = !$isReadOnly || $isAdmin;
    ?>

    <?php if($isReadOnly && !$isAdmin): ?>
      <!-- Display-only mode for non-admin users viewing detail -->
      <div class="alert alert-info mb-4">Detail Jadwal Konseling</div>
      <form>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Nama Siswa</label>
              <input type="text" class="form-control" value="<?php echo e($jadwal->nama_siswa ?? '-'); ?>" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Kelas</label>
              <input type="text" class="form-control" value="<?php echo e($jadwal->kelas ?? '-'); ?>" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Absen</label>
              <input type="text" class="form-control" value="<?php echo e($jadwal->absen ?? '-'); ?>" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" class="form-control" value="<?php echo e($jadwal->tanggal ?? ''); ?>" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Jam</label>
              <input type="time" class="form-control" value="<?php echo e($jadwal->jam ?? ''); ?>" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Guru BK</label>
              <input type="text" class="form-control" value="<?php echo e($jadwal->guru->name ?? '-'); ?>" readonly>
            </div>
            <!-- Kolom tempat dihapus -->
            <div class="mb-3">
              <label class="form-label">Status</label>
              <span class="badge bg-warning" style="padding: 8px 12px; font-size: 14px;"><?php echo e(ucfirst($jadwal->status)); ?></span>
            </div>
            <?php if($jadwal->status == 'batal' && $jadwal->alasan_batal): ?>
            <div class="mb-3">
              <label class="form-label">Alasan Pembatalan</label>
              <textarea class="form-control" readonly rows="3"><?php echo e($jadwal->alasan_batal); ?></textarea>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <a href="<?php echo e(route('jadwal_konseling.index')); ?>" class="btn btn-secondary">Kembali</a>
      </form>
    <?php else: ?>
      <!-- Editable form for admin or create/edit mode -->
      <form method="POST" action="<?php echo e(isset($jadwal) && !request()->routeIs('jadwal_konseling.show') ? url('/jadwal_konseling/'.$jadwal->id) : (isset($jadwal) && request()->routeIs('jadwal_konseling.show') && $isAdmin ? url('/jadwal_konseling/'.$jadwal->id) : url('/jadwal_konseling'))); ?>">
        <?php echo csrf_field(); ?>
        <?php if(isset($jadwal)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div class="row">
          <div class="col-md-6">
            <!-- Siswa hanya input manual, Admin bisa pilih dropdown -->
            <?php if($isSiswa): ?>
              <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" value="<?php echo e(auth()->user()->name); ?>" readonly style="background-color: #e9ecef;">
                <input type="hidden" name="nama_siswa" value="<?php echo e(auth()->user()->name); ?>">
                <small class="text-muted">Auto-fill dari data login Anda</small>
              </div>
              <div class="mb-3">
                <label class="form-label">Kelas & Jurusan</label>
                <input type="text" class="form-control" value="<?php echo e(auth()->user()->kelas->nama_kelas ?? '-'); ?>" readonly style="background-color: #e9ecef;">
                <input type="hidden" name="kelas" value="<?php echo e(auth()->user()->kelas->nama_kelas ?? ''); ?>">
                <small class="text-muted">Auto-fill dari data login Anda</small>
              </div>
              <div class="mb-3">
                <label class="form-label">Nomor Absen</label>
                <input type="text" class="form-control" value="<?php echo e(auth()->user()->absen ?? '-'); ?>" readonly style="background-color: #e9ecef;">
                <input type="hidden" name="absen" value="<?php echo e(auth()->user()->absen ?? ''); ?>">
                <small class="text-muted">Auto-fill dari data login Anda</small>
              </div>
            <?php else: ?>
              <!-- Admin: dropdown pilih siswa -->
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
            <?php endif; ?>

            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" name="tanggal" class="form-control <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('tanggal', $jadwal->tanggal ?? '')); ?>" min="<?php echo e(now()->format('Y-m-d')); ?>" required>
              <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Jam</label>
              <input type="time" name="jam" class="form-control <?php $__errorArgs = ['jam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('jam', $jadwal->jam ?? '')); ?>" min="07:00" max="15:00" required>
              <?php $__errorArgs = ['jam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-3">
              <label class="form-label">Guru BK</label>
              <select name="guru_bk_id" class="form-control <?php $__errorArgs = ['guru_bk_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <option value="">-- Pilih Guru BK --</option>
                <?php $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($g->id); ?>" <?php echo e((old('guru_bk_id', $jadwal->guru_bk_id ?? '')==$g->id)?'selected':''); ?>><?php echo e(ucwords(strtolower($g->name))); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <?php $__errorArgs = ['guru_bk_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Kolom tempat dihapus -->

            <?php if($isAdmin && isset($jadwal)): ?>
              <div class="mb-3">
                <label class="form-label">Status (Admin Only)</label>
                <select name="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                  <option value="pending" <?php echo e((old('status', $jadwal->status ?? '')=='pending')?'selected':''); ?>>Menunggu</option>
                  <option value="terjadwal" <?php echo e((old('status', $jadwal->status ?? '')=='terjadwal')?'selected':''); ?>>Terjadwal</option>
                  <option value="selesai" <?php echo e((old('status', $jadwal->status ?? '')=='selesai')?'selected':''); ?>>Selesai</option>
                  <option value="batal" <?php echo e((old('status', $jadwal->status ?? '')=='batal')?'selected':''); ?>>Batal</option>
                </select>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
              <?php if(isset($jadwal) && $jadwal->status == 'batal' && $jadwal->alasan_batal): ?>
              <div class="mb-3">
                <label class="form-label">Alasan Pembatalan</label>
                <textarea class="form-control" readonly rows="3"><?php echo e($jadwal->alasan_batal); ?></textarea>
              </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="<?php echo e(route('jadwal_konseling.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\ukk2526\resources\views/jadwal_konseling/form.blade.php ENDPATH**/ ?>