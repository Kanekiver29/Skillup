<p>Hello {{ $user->name }},</p>
<p>Your account has been created. You can log in using the credentials below:</p>
<ul>
    <li><strong>Email:</strong> {{ $user->email }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
</ul>
<p>Please change your password after first login.</p>
<p>Regards,<br/>Training Portal</p>
