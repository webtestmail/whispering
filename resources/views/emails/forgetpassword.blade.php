<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:20px;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">



<!-- Body -->
<tr>
    <td style="padding:30px;color:#333;">
        <p>Hi {{ $data['name'] ?? 'N/A' }},</p>

        <p>We received a request to reset your password.</p>

        <p>Click the button below to reset your password:</p>

        <p style="text-align:center;margin:30px 0;">
            <a href="{{ $data['link'] ?? 'N/A' }}" 
               style="background:#007bff;color:#fff;padding:12px 25px;text-decoration:none;border-radius:5px;font-size:16px;">
                Reset Password
            </a>
        </p>

        <p>If the button doesn’t work, copy and paste this link into your browser:</p>

        <p style="word-break:break-all;">
            {{ $data['link'] ?? 'N/A' }}
        </p>

        <!--<p><strong>This link will expire in 60 minutes.</strong></p>-->

        <p>If you did not request a password reset, you can safely ignore this email.</p>

        <p>Thanks,<br>Esma Team</p>
    </td>
</tr>

<!-- Footer -->
<tr>
    <td style="background:#f1f1f1;padding:15px;text-align:center;font-size:12px;color:#777;">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </td>
</tr>
```

</table>

</td>
</tr>
</table>

</body>
</html>
