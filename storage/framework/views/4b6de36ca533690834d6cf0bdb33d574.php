<li class="announcement-item">
    <a href="<?php echo e(url('/sias/student/announcements')); ?>" style="color:inherit;text-decoration:none;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:.5rem;">
            <div style="flex:1"><?php echo e(\Illuminate\Support\Str::limit($announcement->title ?? ($announcement->message ?? 'Announcement'), 120)); ?></div>
            <div style="color:#64748b;font-size:.85rem;margin-left:.5rem"><?php echo e(\Carbon\Carbon::parse($announcement->created_at)->toDateString()); ?></div>
        </div>
    </a>
</li>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\dashboard\_announcement.blade.php ENDPATH**/ ?>