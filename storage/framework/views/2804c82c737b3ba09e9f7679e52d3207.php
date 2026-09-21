

<?php $__env->startSection('content'); ?>

<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: var(--font-sans); }
  .app { display: flex; height: 100vh; min-height: 600px; background: var(--color-background-tertiary); }
  
  /* Sidebar */
  .sidebar { width: 240px; background: var(--color-background-primary); border-right: 0.5px solid var(--color-border-tertiary); display: flex; flex-direction: column; flex-shrink: 0; }
  .sidebar-logo { padding: 16px; border-bottom: 0.5px solid var(--color-border-tertiary); display: flex; align-items: center; gap: 10px; }
  .logo-icon { width: 32px; height: 32px; background: #1D9E75; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
  .logo-icon i { color: white; font-size: 17px; }
  .logo-text { font-size: 14px; font-weight: 500; color: var(--color-text-primary); }
  .logo-sub { font-size: 11px; color: var(--color-text-secondary); }
  .sidebar-nav { padding: 12px 8px; flex: 1; overflow-y: auto; }
  .nav-section { font-size: 10px; color: var(--color-text-secondary); text-transform: uppercase; letter-spacing: 0.08em; padding: 8px 8px 4px; }
  .nav-item { display: flex; align-items: center; gap: 8px; padding: 7px 10px; border-radius: 6px; cursor: pointer; font-size: 13px; color: var(--color-text-secondary); transition: all 0.15s; margin-bottom: 1px; }
  .nav-item:hover { background: var(--color-background-secondary); color: var(--color-text-primary); }
  .nav-item.active { background: #E1F5EE; color: #0F6E56; font-weight: 500; }
  .nav-item.active i { color: #1D9E75; }
  .nav-item i { font-size: 16px; width: 18px; }
  .sidebar-footer { padding: 12px; border-top: 0.5px solid var(--color-border-tertiary); }
  .user-pill { display: flex; align-items: center; gap: 8px; padding: 6px; border-radius: 8px; }
  .avatar { width: 28px; height: 28px; border-radius: 50%; background: #E1F5EE; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 500; color: #0F6E56; flex-shrink: 0; }
  .user-name { font-size: 12px; font-weight: 500; color: var(--color-text-primary); }
  .user-role { font-size: 11px; color: var(--color-text-secondary); }
  .role-badge { font-size: 10px; padding: 2px 7px; border-radius: 20px; background: #E1F5EE; color: #0F6E56; margin-left: auto; }

  /* Main */
  .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
  .topbar { background: var(--color-background-primary); border-bottom: 0.5px solid var(--color-border-tertiary); padding: 0 20px; height: 52px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
  .topbar-title { font-size: 15px; font-weight: 500; color: var(--color-text-primary); }
  .topbar-actions { display: flex; gap: 8px; align-items: center; }
  .btn { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 6px; font-size: 13px; cursor: pointer; border: 0.5px solid var(--color-border-secondary); background: var(--color-background-primary); color: var(--color-text-primary); transition: all 0.15s; font-family: var(--font-sans); }
  .btn:hover { background: var(--color-background-secondary); }
  .btn-primary { background: #1D9E75; border-color: #1D9E75; color: white; }
  .btn-primary:hover { background: #0F6E56; border-color: #0F6E56; }
  .btn-danger { background: #E24B4A; border-color: #E24B4A; color: white; }
  .btn-danger:hover { background: #A32D2D; border-color: #A32D2D; }
  .btn i { font-size: 14px; }

  .content { flex: 1; overflow-y: auto; padding: 20px; }

  /* Views */
  .view { display: none; }
  .view.active { display: block; }

  /* Course List */
  .course-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
  .course-card { background: var(--color-background-primary); border: 0.5px solid var(--color-border-tertiary); border-radius: 12px; overflow: hidden; cursor: pointer; transition: border-color 0.15s; }
  .course-card:hover { border-color: var(--color-border-primary); }
  .course-header { padding: 16px; border-bottom: 0.5px solid var(--color-border-tertiary); }
  .course-badge { font-size: 10px; padding: 3px 8px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px; }
  .badge-active { background: #E1F5EE; color: #0F6E56; }
  .badge-draft { background: #F1EFE8; color: #5F5E5A; }
  .badge-archived { background: #FAECE7; color: #993C1D; }
  .course-title { font-size: 15px; font-weight: 500; color: var(--color-text-primary); margin-bottom: 4px; }
  .course-desc { font-size: 12px; color: var(--color-text-secondary); line-height: 1.5; }
  .course-meta { padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; }
  .meta-stat { display: flex; align-items: center; gap: 5px; font-size: 12px; color: var(--color-text-secondary); }
  .meta-stat i { font-size: 13px; }
  .progress-bar { height: 3px; background: var(--color-background-secondary); border-radius: 2px; margin: 0 16px 12px; }
  .progress-fill { height: 100%; background: #1D9E75; border-radius: 2px; }

  /* Module Editor */
  .editor-layout { display: grid; grid-template-columns: 300px 1fr; gap: 16px; height: calc(100vh - 120px); }
  .module-list-panel { background: var(--color-background-primary); border: 0.5px solid var(--color-border-tertiary); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; }
  .panel-header { padding: 14px 16px; border-bottom: 0.5px solid var(--color-border-tertiary); display: flex; align-items: center; justify-content: space-between; }
  .panel-title { font-size: 13px; font-weight: 500; color: var(--color-text-primary); }
  .module-items { flex: 1; overflow-y: auto; padding: 8px; }
  .module-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px; border-radius: 8px; cursor: pointer; transition: all 0.15s; margin-bottom: 2px; border: 0.5px solid transparent; }
  .module-item:hover { background: var(--color-background-secondary); }
  .module-item.active { background: #E1F5EE; border-color: #9FE1CB; }
  .module-num { width: 22px; height: 22px; border-radius: 50%; background: var(--color-background-secondary); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 500; color: var(--color-text-secondary); flex-shrink: 0; margin-top: 1px; }
  .module-item.active .module-num { background: #1D9E75; color: white; }
  .module-info { flex: 1; min-width: 0; }
  .module-name { font-size: 13px; font-weight: 500; color: var(--color-text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .module-type { font-size: 11px; color: var(--color-text-secondary); margin-top: 1px; }
  .module-drag { color: var(--color-text-secondary); font-size: 14px; opacity: 0; cursor: grab; }
  .module-item:hover .module-drag { opacity: 1; }

  /* Editor Panel */
  .editor-panel { background: var(--color-background-primary); border: 0.5px solid var(--color-border-tertiary); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; }
  .editor-toolbar { padding: 10px 16px; border-bottom: 0.5px solid var(--color-border-tertiary); display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
  .toolbar-group { display: flex; gap: 2px; }
  .tool-btn { width: 28px; height: 28px; border-radius: 5px; border: 0.5px solid var(--color-border-tertiary); background: var(--color-background-primary); color: var(--color-text-secondary); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: all 0.15s; }
  .tool-btn:hover { background: var(--color-background-secondary); color: var(--color-text-primary); border-color: var(--color-border-secondary); }
  .tool-sep { width: 0.5px; background: var(--color-border-tertiary); height: 24px; margin: 0 4px; }
  .editor-meta { padding: 12px 16px; border-bottom: 0.5px solid var(--color-border-tertiary); display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
  .field-group { display: flex; flex-direction: column; gap: 4px; }
  .field-label { font-size: 11px; color: var(--color-text-secondary); }
  .field-input { padding: 6px 10px; border: 0.5px solid var(--color-border-secondary); border-radius: 6px; font-size: 13px; background: var(--color-background-primary); color: var(--color-text-primary); font-family: var(--font-sans); }
  .field-input:focus { outline: none; border-color: #1D9E75; box-shadow: 0 0 0 2px rgba(29,158,117,0.15); }
  .editor-content { flex: 1; padding: 16px; }
  .content-title-input { width: 100%; font-size: 20px; font-weight: 500; border: none; outline: none; color: var(--color-text-primary); background: transparent; font-family: var(--font-sans); margin-bottom: 12px; border-bottom: 1px solid var(--color-border-tertiary); padding-bottom: 10px; }
  .content-title-input::placeholder { color: var(--color-text-secondary); }
  .content-body { width: 100%; min-height: 280px; border: none; outline: none; font-size: 14px; color: var(--color-text-primary); background: transparent; font-family: var(--font-sans); line-height: 1.7; resize: none; }
  .content-body::placeholder { color: var(--color-text-secondary); }
  .editor-footer { padding: 12px 16px; border-top: 0.5px solid var(--color-border-tertiary); display: flex; align-items: center; justify-content: space-between; }
  .status-pill { font-size: 12px; color: var(--color-text-secondary); display: flex; align-items: center; gap: 6px; }
  .dot-saved { width: 6px; height: 6px; border-radius: 50%; background: #1D9E75; }
  .dot-unsaved { width: 6px; height: 6px; border-radius: 50%; background: #EF9F27; }

  /* Tabs */
  .tab-row { display: flex; gap: 2px; margin-bottom: 16px; background: var(--color-background-secondary); padding: 3px; border-radius: 8px; width: fit-content; }
  .tab { padding: 6px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; color: var(--color-text-secondary); transition: all 0.15s; }
  .tab.active { background: var(--color-background-primary); color: var(--color-text-primary); font-weight: 500; box-shadow: 0 1px 2px rgba(0,0,0,0.06); }

  /* Students */
  .student-table { width: 100%; border-collapse: collapse; }
  .student-table th { text-align: left; font-size: 11px; color: var(--color-text-secondary); padding: 8px 12px; border-bottom: 0.5px solid var(--color-border-tertiary); font-weight: 500; }
  .student-table td { padding: 10px 12px; font-size: 13px; color: var(--color-text-primary); border-bottom: 0.5px solid var(--color-border-tertiary); }
  .student-table tr:last-child td { border-bottom: none; }
  .progress-cell { display: flex; align-items: center; gap: 8px; }
  .mini-bar { height: 4px; width: 80px; background: var(--color-background-secondary); border-radius: 2px; }
  .mini-fill { height: 100%; border-radius: 2px; background: #1D9E75; }
  .status-tag { font-size: 11px; padding: 2px 8px; border-radius: 20px; }

  /* Add Module Modal */
  .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 100; align-items: center; justify-content: center; }
  .modal-overlay.open { display: flex; }
  .modal { background: var(--color-background-primary); border-radius: 12px; width: 460px; border: 0.5px solid var(--color-border-tertiary); overflow: hidden; }
  .modal-header { padding: 16px 20px; border-bottom: 0.5px solid var(--color-border-tertiary); display: flex; align-items: center; justify-content: space-between; }
  .modal-title { font-size: 15px; font-weight: 500; color: var(--color-text-primary); }
  .modal-body { padding: 20px; display: flex; flex-direction: column; gap: 14px; }
  .modal-footer { padding: 14px 20px; border-top: 0.5px solid var(--color-border-tertiary); display: flex; justify-content: flex-end; gap: 8px; }
  .type-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
  .type-card { padding: 12px 8px; border: 0.5px solid var(--color-border-secondary); border-radius: 8px; text-align: center; cursor: pointer; transition: all 0.15s; }
  .type-card:hover { border-color: #1D9E75; background: #E1F5EE; }
  .type-card.selected { border-color: #1D9E75; background: #E1F5EE; }
  .type-card i { font-size: 20px; color: var(--color-text-secondary); margin-bottom: 6px; display: block; }
  .type-card.selected i { color: #0F6E56; }
  .type-card span { font-size: 12px; color: var(--color-text-secondary); }
  .type-card.selected span { color: #0F6E56; font-weight: 500; }

  /* Empty state */
  .empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 20px; text-align: center; }
  .empty-state i { font-size: 40px; color: var(--color-text-secondary); margin-bottom: 16px; opacity: 0.4; }
  .empty-state h3 { font-size: 15px; font-weight: 500; color: var(--color-text-primary); margin-bottom: 6px; }
  .empty-state p { font-size: 13px; color: var(--color-text-secondary); max-width: 260px; line-height: 1.5; }

  .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--color-text-secondary); margin-bottom: 16px; }
  .breadcrumb span { cursor: pointer; }
  .breadcrumb span:hover { color: var(--color-text-primary); }
  .breadcrumb i { font-size: 12px; }

  .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
  .stat-card { background: var(--color-background-secondary); border-radius: 8px; padding: 14px; }
  .stat-label { font-size: 11px; color: var(--color-text-secondary); margin-bottom: 4px; }
  .stat-value { font-size: 22px; font-weight: 500; color: var(--color-text-primary); }
  .stat-delta { font-size: 11px; color: #1D9E75; margin-top: 2px; }

  select.field-input { cursor: pointer; }
</style>

<h2 class="sr-only">Skill upcourse management platform for teachers and staff</h2>

  <div class="main">
    <div class="topbar">
      <span class="topbar-title" id="topbar-title">My Courses</span>
      <div class="topbar-actions" id="topbar-actions">
        <button class="btn btn-primary" onclick="openNewCourseModal()"><i class="ti ti-plus" aria-hidden="true"></i> New Course</button>
      </div>
    </div>

    <div class="content">

      <!-- COURSES VIEW -->
      <div class="view active" id="view-courses">
        <div class="stats-row">
          <div class="stat-card"><div class="stat-label">Total Courses</div><div class="stat-value" id="stat-courses">3</div><div class="stat-delta">↑ 2 this semester</div></div>
          <div class="stat-card"><div class="stat-label">Total Modules</div><div class="stat-value" id="stat-modules">12</div><div class="stat-delta">Across all courses</div></div>
          <div class="stat-card"><div class="stat-label">Enrolled Students</div><div class="stat-value">47</div><div class="stat-delta">↑ 5 this week</div></div>
          <div class="stat-card"><div class="stat-label">Avg. Completion</div><div class="stat-value">68%</div><div class="stat-delta">↑ 12% vs last term</div></div>
        </div>
        <div class="course-grid" id="course-grid"></div>
      </div>

      <!-- EDITOR VIEW -->
      <div class="view" id="view-editor">
... (content trimmed in patch for brevity) ...

    function buildCourseList() {
        const courseMap = new Map();
        modules.forEach(module => {
            if (module.course_id && module.course_title) {
                courseMap.set(module.course_id, module.course_title);
            }
        });
        courses = Array.from(courseMap.entries()).map(([id, title]) => ({ id, title }));
    }

    function getCourseOptions() {
        return `
            <option value="">Select Course</option>
            ${courses.map(course => `<option value="${course.id}">${course.title}</option>`).join('')}
        `;
    }

    function getModuleOptions(courseId) {
        const filtered = modules.filter(module => String(module.course_id) === String(courseId));
        return `
            <option value="">Select Module</option>
            ${filtered.map(module => `<option value="${module.id}">${module.module_title}</option>`).join('')}
        `;
    }

    function filterModuleOptions(prefix) {
        const courseSelect = document.getElementById(`${prefix}Course`);
        const moduleSelect = document.getElementById(`${prefix}Module`);
        if (!courseSelect || !moduleSelect) return;

        moduleSelect.innerHTML = getModuleOptions(courseSelect.value);
        moduleSelect.disabled = moduleSelect.options.length <= 1;
    }

    function filterUploadModuleOptions() {
        const courseSelect = document.getElementById('upload-course');
        const moduleSelect = document.getElementById('upload-module');
        if (!courseSelect || !moduleSelect) return;

        moduleSelect.innerHTML = getModuleOptions(courseSelect.value);
        moduleSelect.disabled = moduleSelect.options.length <= 1;
    }

    function parseJsonResponse(response) {
        return response.text().then(text => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 500));
            }
            try {
                return JSON.parse(text);
            } catch (parseError) {
                throw new Error('Expected JSON response but got HTML: ' + text.substring(0, 500));
            }
        });
    }

    function loadModules() {
        fetch('<?php echo e(route('admin.content.modules')); ?>', {
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(parseJsonResponse)
            .then(data => {
                if (data.success) {
                    modules = data.data;
                    buildCourseList();
                }
            })
            .catch(error => {
                console.error('Module load failed:', error);
                Swal.fire('Error', 'Unable to load modules: ' + error.message, 'error');
            });
    }

    function openCreateModal(type) {
        document.getElementById('create-modal').classList.add('hidden');

        switch (type) {
            case 'assessment':
                createAssessment();
                break;
            case 'video':
                createVideo();
                break;
            case 'presentation':
                createPresentation();
                break;
            case 'quiz':
                createQuiz();
                break;
            case 'ppt':
                createPPT();
                break;
            case 'module':
                createModule();
                break;
            case 'course':
                createCourse();
                break;
            default:
                console.warn('Unknown content type:', type);
        }
    }

    function createModule() {
        window.location.href = '<?php echo e(route('admin.modules.create')); ?>';
    }

    function createCourse() {
        window.location.href = '<?php echo e(route('admin.courses.create')); ?>';
    }

    // File Upload Handler
    function handleFileUpload(event) {
        const files = event.target.files;
        if (files.length > 0) {
            Swal.fire({
                title: 'Upload Files',
                html: `
                    <div class="text-left">
                        <p class="mb-3">${files.length} file(s) selected</p>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                            <select id="upload-course" class="w-full px-3 py-2 border border-gray-300 rounded-lg" onchange="filterUploadModuleOptions()">
                                ${getCourseOptions()}
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                            <select id="upload-module" class="w-full px-3 py-2 border border-gray-300 rounded-lg" disabled>
                                <option value="">Select Module</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Upload',
                confirmButtonColor: '#3b82f6',
                preConfirm: () => {
                    const moduleId = document.getElementById('upload-module').value;
                    if (!moduleId) {
                        Swal.showValidationMessage('Please select a module');
                        return false;
                    }
                    return { moduleId };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    for (let i = 0; i < files.length; i++) {
                        formData.append('images[]', files[i]);
                    }
                    formData.append('module_id', result.value.moduleId);

                    Swal.fire({
                        title: 'Uploading Files',
                        html: 'Please wait while your files are being uploaded...',
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        allowOutsideClick: false
                    });

                    fetch('<?php echo e(route('admin.content.images')); ?>', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(parseJsonResponse)
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: data.message,
                                confirmButtonColor: '#3b82f6'
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Upload failed: ' + error.message, 'error');
                    });
                }
            });
        }
    }

    // Create Assessment
    function createAssessment() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Assessment',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select id="assessmentCourse" onchange="filterModuleOptions('assessment')" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            ${getCourseOptions()}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="assessmentModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" disabled>
                            <option value="">Select Module</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assessment Title</label>
                        <input type="text" id="assessmentTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="assessmentDesc" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Enter description"></textarea>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('assessmentModule').value;
                const title = document.getElementById('assessmentTitle').value;
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                return { moduleId, title };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm('<?php echo e(route('admin.content.assessment')); ?>', {
                    module_id: result.value.moduleId,
                    title: result.value.title,
                    description: document.getElementById('assessmentDesc').value
                });
            }
        });
    }

    // Create Video
    function createVideo() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Video Content',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select id="videoCourse" onchange="filterModuleOptions('video')" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            ${getCourseOptions()}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="videoModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" disabled>
                            <option value="">Select Module</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video Title</label>
                        <input type="text" id="videoTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
                        <input type="url" id="videoUrl" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="https://youtube.com/...">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('videoModule').value;
                const title = document.getElementById('videoTitle').value;
                const url = document.getElementById('videoUrl').value;
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                if (!url) {
                    Swal.showValidationMessage('Please enter a video URL');
                    return false;
                }
                return { moduleId, title, url };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm('<?php echo e(route('admin.content.video')); ?>', {
                    module_id: result.value.moduleId,
                    title: result.value.title,
                    video_url: result.value.url
                });
            }
        });
    }

    // Create Presentation
    function createPresentation() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Presentation',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="presentationModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Module</option>
                            ${modules.map(m => `<option value="${m.id}">${m.title}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Presentation Title</label>
                        <input type="text" id="presentationTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload File (PowerPoint/PDF)</label>
                        <input type="file" id="presentationFile" class="w-full" accept=".ppt,.pptx,.pdf">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('presentationModule').value;
                const title = document.getElementById('presentationTitle').value;
                const file = document.getElementById('presentationFile').files[0];
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                if (!file) {
                    Swal.showValidationMessage('Please select a file');
                    return false;
                }
                return { moduleId, title, file };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('module_id', result.value.moduleId);
                formData.append('title', result.value.title);
                formData.append('file', result.value.file);

                submitFormData('<?php echo e(route('admin.content.presentation')); ?>', formData);
            }
        });
    }

    // Create Quiz
    function createQuiz() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create Quiz',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="quizModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Module</option>
                            ${modules.map(m => `<option value="${m.id}">${m.title}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quiz Title</label>
                        <input type="text" id="quizTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="quizDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Optional quiz overview"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Questions</label>
                        <input type="number" id="quizQuestions" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="5" min="1">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Time Limit (minutes)</label>
                        <input type="number" id="quizTime" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="30" min="5">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Media Type</label>
                        <select id="quizMediaType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">None</option>
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Media URL</label>
                        <input type="url" id="quizMediaUrl" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="https://example.com/video.mp4 or image.jpg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Media File</label>
                        <input type="file" id="quizMediaFile" class="w-full" accept="image/*,video/*">
                        <p class="text-xs text-gray-500 mt-1">Optional file upload instead of URL. Leave blank if using a URL.</p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('quizModule').value;
                const title = document.getElementById('quizTitle').value;
                const description = document.getElementById('quizDescription').value;
                const mediaType = document.getElementById('quizMediaType').value;
                const mediaUrl = document.getElementById('quizMediaUrl').value;
                const mediaFile = document.getElementById('quizMediaFile').files[0];

                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                if (mediaUrl && !mediaType) {
                    Swal.showValidationMessage('Please select a media type for the provided URL');
                    return false;
                }
                if (mediaFile && !mediaType) {
                    Swal.showValidationMessage('Please select a media type for the uploaded file');
                    return false;
                }
                if (mediaUrl && mediaFile) {
                    Swal.showValidationMessage('Use either a media URL or file upload, not both');
                    return false;
                }
                return {
                    moduleId,
                    title,
                    description,
                    questions: document.getElementById('quizQuestions').value,
                    time: document.getElementById('quizTime').value,
                    mediaType,
                    mediaUrl,
                    mediaFile,
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.mediaFile) {
                    const formData = new FormData();
                    formData.append('module_id', result.value.moduleId);
                    formData.append('title', result.value.title);
                    formData.append('description', result.value.description);
                    formData.append('questions_count', result.value.questions);
                    formData.append('time_limit_minutes', result.value.time);
                    formData.append('media_type', result.value.mediaType);
                    formData.append('media_file', result.value.mediaFile);
                    if (result.value.mediaUrl) {
                        formData.append('media_url', result.value.mediaUrl);
                    }
                    submitFormData('<?php echo e(route('admin.content.quiz')); ?>', formData);
                } else {
                    submitForm('<?php echo e(route('admin.content.quiz')); ?>', {
                        module_id: result.value.moduleId,
                        title: result.value.title,
                        description: result.value.description,
                        questions_count: result.value.questions,
                        time_limit_minutes: result.value.time,
                        media_type: result.value.mediaType,
                        media_url: result.value.mediaUrl,
                    });
                }
            }
        });
    }

    // Create PowerPoint
    function createPPT() {
        document.getElementById('create-modal').classList.add('hidden');
        
        Swal.fire({
            title: 'Create PowerPoint Slide',
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                        <select id="pptModule" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Module</option>
                            ${modules.map(m => `<option value="${m.id}">${m.title}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slide Title</label>
                        <input type="text" id="pptTitle" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Enter slide title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Choose Template</label>
                        <select id="pptTemplate" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option>Blank</option>
                            <option>Title Slide</option>
                            <option>Content & Image</option>
                            <option>Two Content</option>
                        </select>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Create',
            confirmButtonColor: '#3b82f6',
            preConfirm: () => {
                const moduleId = document.getElementById('pptModule').value;
                const title = document.getElementById('pptTitle').value;
                if (!moduleId) {
                    Swal.showValidationMessage('Please select a module');
                    return false;
                }
                if (!title) {
                    Swal.showValidationMessage('Please enter a title');
                    return false;
                }
                return { 
                    moduleId, 
                    title,
                    template: document.getElementById('pptTemplate').value
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm('<?php echo e(route('admin.content.powerpoint')); ?>', {
                    module_id: result.value.moduleId,
                    title: result.value.title,
                    template: result.value.template
                });
            }
        });
    }

    // Form submission helpers
    function submitForm(url, data) {
        Swal.fire({
            title: 'Creating...',
            html: 'Please wait while your content is being created...',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text().then(text => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 500));
            }
            try {
                return JSON.parse(text);
            } catch (parseError) {
                throw new Error('Expected JSON response but got HTML: ' + text.substring(0, 500));
            }
        }))
        .then(data => {
            if (data.success) {
                if (data.redirect_url) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6',
                        allowOutsideClick: false,
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6'
                    });
                }
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Request failed: ' + error.message, 'error');
        });
    }

    function submitFormData(url, formData) {
        Swal.fire({
            title: 'Uploading...',
            html: 'Please wait while your file is being uploaded...',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false
        });

        fetch(url, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.text().then(text => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status + ': ' + text.substring(0, 500));
            }
            try {
                return JSON.parse(text);
            } catch (parseError) {
                throw new Error('Expected JSON response but got HTML: ' + text.substring(0, 500));
            }
        }))
        .then(data => {
            if (data.success) {
                if (data.redirect_url) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6',
                        allowOutsideClick: false,
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        confirmButtonColor: '#3b82f6'
                    });
                }
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Upload failed: ' + error.message, 'error');
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadModules();
    });

    // Handle image upload
    function handleImageUpload(event) {
        handleFileUpload(event);
        event.target.value = '';
    }

</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modals'); ?>
<!-- Create Modal (outside main content so fixed positioning and z-index stay correct) -->
<div id="create-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[200] p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full" role="dialog" aria-labelledby="create-modal-title">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h3 id="create-modal-title" class="text-lg font-semibold text-gray-900">Create New Content</h3>
            <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="create-modal-close text-gray-400 hover:text-gray-600 p-1">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 w-full">
                <button type="button" onclick="openCreateModal('assessment')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-file-alt text-xl text-blue-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Assessment</h4>
                    <p class="text-xs text-gray-600 mt-1">Create quizzes &amp; tests</p>
                </button>

                <button type="button" onclick="openCreateModal('video')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-red-50 hover:border-red-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-video text-xl text-red-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Video</h4>
                    <p class="text-xs text-gray-600 mt-1">Add video lessons</p>
                </button>

                <button type="button" onclick="openCreateModal('presentation')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-orange-50 hover:border-orange-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-file-powerpoint text-xl text-orange-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Presentation</h4>
                    <p class="text-xs text-gray-600 mt-1">Upload presentations</p>
                </button>

                <button type="button" onclick="openCreateModal('quiz')" class="create-type-card w-full flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-green-50 hover:border-green-500 transition text-center">
                    <div class="mb-2">
                        <i class="fas fa-question-circle text-xl text-green-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Quiz</h4>
                    <p class="text-xs text-gray-600 mt-1">Build interactive quizzes</p>
                </button>

                <button type="button" onclick="document.getElementById('image-input-modal').click()" class="create-type-card w-full col-span-2 sm:col-span-1 sm:col-start-2 flex flex-col items-center justify-center min-h-[120px] p-4 border border-gray-200 rounded-xl hover:bg-pink-50 hover:border-pink-500 transition text-center">
                    <input type="file" id="image-input-modal" class="hidden" accept="image/*" multiple onchange="handleImageUpload(event)">
                    <div class="mb-2">
                        <i class="fas fa-image text-xl text-pink-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Image</h4>
                    <p class="text-xs text-gray-600 mt-1">Upload images</p>
                </button>
            </div>
        </div>
    </div>
</div>
<style>
    #create-modal .create-type-card {
        min-height: 7.5rem;
    }
    #create-modal .create-modal-close {
        min-height: 0;
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.staff.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\auth\staff\staff-dashboard.blade.php ENDPATH**/ ?>