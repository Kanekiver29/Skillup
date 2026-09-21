<?php $__env->startSection('title', 'Student Management'); ?>
<?php $__env->startSection('page_title', 'Student Management'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .student-records { overflow:hidden; }
  .student-toolbar { display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; }
  .student-add { display:inline-flex; align-items:center; gap:.5rem; width:auto; padding:.72rem 1rem; }
  .student-add svg, .student-action svg { width:16px; height:16px; flex:none; }
  .student-table-wrap { overflow-x:auto; }
  .student-table { width:100%; border-collapse:collapse; min-width:680px; }
  .student-table th { padding:.8rem .75rem; color:var(--text-muted); font-size:.74rem; text-transform:uppercase; letter-spacing:.06em; white-space:nowrap; }
  .student-table td { padding:.8rem .75rem; }
  .student-table tbody tr { border-top:1px solid var(--card-border); transition:background var(--dur-fast) var(--ease); }
  .student-table tbody tr:hover { background:var(--accent-tint); }
  .student-actions { display:flex; justify-content:flex-end; gap:.4rem; }
  .student-action { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:8px; text-decoration:none; border:1px solid transparent; transition:transform var(--dur-fast) var(--ease), border-color var(--dur-fast) var(--ease), background var(--dur-fast) var(--ease); }
  .student-action:hover { transform:translateY(-2px); border-color:currentColor; }
  .student-action.view { background:rgba(59,130,246,.1); color:#2563eb; }
  .student-action.edit { background:rgba(234,179,8,.12); color:#a16207; }
  .student-action.delete { background:rgba(239,68,68,.1); color:#dc2626; cursor:pointer; }
  @media (max-width:600px) { .student-add { width:100%; justify-content:center; } }
</style>
<div class="admin-card">
  <div class="student-toolbar">
    <div>
      <h2 style="margin:0;font-size:1.5rem;">Student Records</h2>
      <p style="margin:.25rem 0 0;color:var(--text-muted);">Add, edit, view, and delete student records.</p>
    </div>
    <div>
      <a href="<?php echo e(route('sias.admin.students.create')); ?>" class="btn student-add">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M15 20a6 6 0 0 0-12 0"></path><circle cx="9" cy="7" r="4"></circle><path d="M19 8v6M16 11h6"></path></svg>
        Add Student
      </a>
    </div>
  </div>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div style="padding:.75rem 1rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#16a34a;border-radius:8px;margin-bottom:1rem;">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <div class="student-table-wrap">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($students->count()): ?>
      <table class="student-table">
        <thead>
          <tr style="text-align:left;border-bottom:2px solid var(--card-border)">
            <th>Student ID</th><th>Name</th><th>Email</th><th>Age</th><th style="text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
          <tr>
            <td style="font-weight:600;"><?php echo e($s->lrn ?? $s->id); ?></td><td><?php echo e($s->name); ?></td><td><?php echo e($s->email); ?></td><td><?php echo e($s->age ?? 'N/A'); ?></td>
            <td><div class="student-actions">
              <a class="student-action view" href="<?php echo e(route('sias.admin.students.show', $s->id)); ?>" title="View student" aria-label="View student">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>
              </a>
              <a class="student-action edit" href="<?php echo e(route('sias.admin.students.edit', $s->id)); ?>" title="Edit student" aria-label="Edit student">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m4 16-.8 4.8L8 20l11-11-4-4L4 16Z"></path><path d="m13.5 6.5 4 4"></path></svg>
              </a>
              <form method="POST" action="<?php echo e(route('sias.admin.students.destroy', $s->id)); ?>" style="display:inline" onsubmit="return confirm('Delete this student?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="student-action delete" type="submit" title="Delete student" aria-label="Delete student"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"></path></svg></button>
              </form>
            </div></td>
          </tr>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
      </table>

      <div style="margin-top:1rem"><?php echo e($students->links()); ?></div>
    <?php else: ?>
      <div style="text-align:center;padding:2rem;color:var(--text-muted);">
        <p>No students found.</p>
      </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\students\index.blade.php ENDPATH**/ ?>