

<?php $__env->startSection('title', 'Create New Qualification'); ?>
<?php $__env->startSection('page_title', 'Create New Qualification'); ?>
<?php $__env->startSection('subtitle', 'Register a TESDA-aligned qualification and its units of competency.'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .qualification-form { display:grid; gap:1rem; }
  .qualification-section { border:1px solid var(--card-border); border-radius:14px; padding:1.25rem; background:var(--card-bg); }
  .qualification-section h3 { margin:0 0 .25rem; font-family:var(--font-display); }
  .qualification-section > p { margin:0 0 1rem; color:var(--text-muted); font-size:.9rem; }
  .qualification-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:1rem; }
  .qualification-field { display:grid; gap:.35rem; }
  .qualification-field.full { grid-column:1 / -1; }
  .qualification-field label { font-weight:600; font-size:.9rem; }
  .qualification-input { width:100%; padding:.72rem .8rem; border:1px solid var(--card-border); border-radius:8px; background:var(--bg); color:var(--text); font:inherit; }
  .qualification-input:focus { border-color:var(--accent); outline:2px solid var(--accent-tint); }
  .competency-row { display:grid; grid-template-columns:150px minmax(0, 1fr) auto; gap:.65rem; align-items:end; margin-top:.65rem; }
  .competency-empty { padding:1rem; border:1px dashed var(--card-border); border-radius:10px; color:var(--text-muted); text-align:center; }
  .remove-competency { width:auto; padding:.7rem .85rem; }
  @media (max-width:650px) { .qualification-grid, .competency-row { grid-template-columns:1fr; } .qualification-field.full { grid-column:auto; } .remove-competency { width:100%; } }
</style>

<form method="POST" action="<?php echo e(route('sias.admin.course.store')); ?>" class="qualification-form">
  <?php echo csrf_field(); ?>
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
    <div class="admin-panel" style="border-color:var(--danger); color:var(--danger);">
      <strong>Please review the qualification fields.</strong>
      <ul style="margin:.5rem 0 0 1.25rem;"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><li><?php echo e($error); ?></li><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></ul>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <section class="qualification-section">
    <h3>Qualification Information</h3><p>Identify the TESDA qualification and describe the program.</p>
    <div class="qualification-grid">
      <div class="qualification-field"><label for="qualification_title">Qualification Title *</label><input class="qualification-input" id="qualification_title" name="qualification_title" value="<?php echo e(old('qualification_title')); ?>" placeholder="Computer Systems Servicing NC II" required></div>
      <div class="qualification-field"><label for="qualification_code">Qualification Code *</label><input class="qualification-input" id="qualification_code" name="qualification_code" value="<?php echo e(old('qualification_code')); ?>" placeholder="CSS NC II" required></div>
      <div class="qualification-field"><label for="qualification_level">Qualification Level *</label><select class="qualification-input" id="qualification_level" name="qualification_level" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['NC I','NC II','NC III','NC IV','Diploma']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('qualification_level', 'NC II') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="qualification-field"><label for="sector_industry">Sector / Industry *</label><select class="qualification-input" id="sector_industry" name="sector_industry" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Information and Communication Technology','Construction','Agriculture','Automotive','Health, Social and Other Community Development Services','Tourism','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('sector_industry') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="qualification-field full"><label for="qualification_description">Description</label><textarea class="qualification-input" id="qualification_description" name="qualification_description" rows="4" placeholder="Description of the qualification..."><?php echo e(old('qualification_description')); ?></textarea></div>
    </div>
  </section>

  <section class="qualification-section">
    <h3>TESDA Registration</h3><p>Record the qualification registration and training regulations reference.</p>
    <div class="qualification-grid">
      <div class="qualification-field"><label for="program_registration_no">Program Registration No. / CoPR No.</label><input class="qualification-input" id="program_registration_no" name="program_registration_no" value="<?php echo e(old('program_registration_no')); ?>"></div>
      <div class="qualification-field"><label for="registration_status">Registration Status *</label><select class="qualification-input" id="registration_status" name="registration_status" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Registered','Pending','Expired','Suspended']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('registration_status', 'Registered') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="qualification-field"><label for="registration_date">Registration Date</label><input class="qualification-input" id="registration_date" name="registration_date" type="date" value="<?php echo e(old('registration_date')); ?>"></div>
      <div class="qualification-field"><label for="training_regulations_version">Training Regulations Version</label><input class="qualification-input" id="training_regulations_version" name="training_regulations_version" value="<?php echo e(old('training_regulations_version')); ?>" placeholder="TR Version / Year"></div>
    </div>
  </section>

  <section class="qualification-section">
    <h3>Training Information</h3><p>Define the nominal duration, delivery mode, and batch capacity.</p>
    <div class="qualification-grid">
      <div class="qualification-field"><label for="nominal_training_duration">Training Duration (Hours) *</label><input class="qualification-input" id="nominal_training_duration" name="nominal_training_duration" type="number" min="0.01" step="0.01" value="<?php echo e(old('nominal_training_duration', 436)); ?>" required></div>
      <div class="qualification-field"><label for="delivery_mode">Delivery Mode *</label><select class="qualification-input" id="delivery_mode" name="delivery_mode" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Face-to-Face','Online','Blended']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('delivery_mode', 'Face-to-Face') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="qualification-field"><label for="maximum_batch_capacity">Maximum Batch Capacity (Learners) *</label><input class="qualification-input" id="maximum_batch_capacity" name="maximum_batch_capacity" type="number" min="1" value="<?php echo e(old('maximum_batch_capacity', 25)); ?>" required></div>
      <div class="qualification-field"><label for="category">Category *</label><select class="qualification-input" id="category" name="category" required><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Certificate','Diploma','Short Course','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($option); ?>" <?php if(old('category', 'Certificate') === $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
      <div class="qualification-field full"><label for="curriculum">Training Regulations / Curriculum Version</label><input class="qualification-input" id="curriculum" name="curriculum" value="<?php echo e(old('curriculum')); ?>" placeholder="TR Version / Curriculum 2024"></div>
    </div>
  </section>

  <section class="qualification-section">
    <h3>Qualification Competencies</h3><p>Connect the qualification to its basic, common, and core units of competency.</p>
    <div id="competencies">
      <?php ($oldCompetencies = old('competencies', [['type' => 'Basic', 'name' => 'Manage Your Own Performance'], ['type' => 'Common', 'name' => 'Apply Quality Standards'], ['type' => 'Core', 'name' => 'Install and Configure Computer Systems']])); ?>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $oldCompetencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $competency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="competency-row">
          <div class="qualification-field"><label>Competency Type</label><select class="qualification-input" name="competencies[<?php echo e($index); ?>][type]"><option value="Basic" <?php if(($competency['type'] ?? '') === 'Basic'): echo 'selected'; endif; ?>>Basic</option><option value="Common" <?php if(($competency['type'] ?? '') === 'Common'): echo 'selected'; endif; ?>>Common</option><option value="Core" <?php if(($competency['type'] ?? '') === 'Core'): echo 'selected'; endif; ?>>Core</option></select></div>
          <div class="qualification-field"><label>Unit of Competency</label><input class="qualification-input" name="competencies[<?php echo e($index); ?>][name]" value="<?php echo e($competency['name'] ?? ''); ?>" placeholder="Unit of competency"></div>
          <button type="button" class="btn btn-secondary remove-competency">Remove</button>
        </div>
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
    <button type="button" id="addCompetency" class="btn btn-secondary" style="width:auto; margin-top:1rem;">+ Add Unit of Competency</button>
  </section>

  <section class="qualification-section">
    <h3>Program Status</h3>
    <input type="hidden" name="program_status" value="Inactive">
    <label style="display:flex;align-items:center;gap:.5rem;font-weight:600;"><input type="checkbox" name="program_status" value="Active" <?php if(old('program_status', 'Active') === 'Active'): echo 'checked'; endif; ?>> Active</label>
  </section>

  <section class="admin-card" style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
    <a href="<?php echo e(route('sias.admin.course')); ?>" class="btn btn-secondary" style="width:auto;">Cancel</a>
    <button type="submit" class="btn" style="width:auto;">Create Qualification</button>
  </section>
</form>

<template id="competencyTemplate">
  <div class="competency-row">
    <div class="qualification-field"><label>Competency Type</label><select class="qualification-input" data-name="type"><option value="Basic">Basic</option><option value="Common">Common</option><option value="Core" selected>Core</option></select></div>
    <div class="qualification-field"><label>Unit of Competency</label><input class="qualification-input" data-name="name" placeholder="Unit of competency"></div>
    <button type="button" class="btn btn-secondary remove-competency">Remove</button>
  </div>
</template>
<script>
(function () {
  var list = document.getElementById('competencies');
  var template = document.getElementById('competencyTemplate');
  var add = document.getElementById('addCompetency');
  function reindex() {
    Array.from(list.querySelectorAll('.competency-row')).forEach(function (row, index) {
      row.querySelectorAll('[data-name], select[name], input[name]').forEach(function (field) {
        var name = field.dataset.name || (field.name || '').split(']').pop().replace('[', '');
        if (field.dataset.name) field.name = 'competencies[' + index + '][' + field.dataset.name + ']';
      });
    });
  }
  add.addEventListener('click', function () { list.appendChild(template.content.cloneNode(true)); reindex(); });
  list.addEventListener('click', function (event) { if (event.target.classList.contains('remove-competency')) { event.target.closest('.competency-row').remove(); reindex(); } });
  reindex();
}());
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\course\course\add.blade.php ENDPATH**/ ?>