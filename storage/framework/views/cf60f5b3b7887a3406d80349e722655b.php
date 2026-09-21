<p>Hello <?php echo e($user->name); ?>,</p>
<p>Your account has been created. You can log in using the credentials below:</p>
<ul>
    <li><strong>Email:</strong> <?php echo e($user->email); ?></li>
    <li><strong>Password:</strong> <?php echo e($password); ?></li>
</ul>
<p>Please change your password after first login.</p>
<p>Regards,<br/>Training Portal</p>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\emails\account_created.blade.php ENDPATH**/ ?>