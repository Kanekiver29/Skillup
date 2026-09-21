<p>Hello <?php echo e($user->name); ?>,</p>
<p>Your password has been reset by a staff member. Your new temporary password is:</p>
<ul>
    <li><strong>Password:</strong> <?php echo e($password); ?></li>
</ul>
<p>Please change your password after login.</p>
<p>Regards,<br/>Training Portal</p>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\emails\password_reset.blade.php ENDPATH**/ ?>