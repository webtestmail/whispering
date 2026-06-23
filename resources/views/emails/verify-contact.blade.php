<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Contact Form</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px; 
            background: #f4f4f4;
        }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .button { 
            background: #007bff; 
            color: white; 
            padding: 15px 30px; 
            text-decoration: none; 
            border-radius: 5px; 
            display: inline-block; 
            font-weight: bold;
            transition: background 0.3s;
        }
        .button:hover { background: #0056b3; }
        .header { background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 25px; border-radius: 10px 10px 0 0; margin: -30px -30px 20px -30px; text-align: center; }
        .footer { text-align: center; font-size: 12px; color: #666; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Verify Contact Form</h1>
            <p>Complete your message submission</p>
        </div>
        
        <p>Hi,</p>
        <p>Thank you for contacting us! Please click the button below to verify your email and submit your message:</p>
        
        <!-- ✅ FIXED: Generate URL using $token (passed from Mailable) -->
        <a href="{{ route('contact.verify.token', $token) }}" class="button" style="display: inline-block;">
            ✅ Verify & Submit Message
        </a>
        
        <p style="margin-top: 25px; font-size: 14px; color: #666;">
            <strong>Or copy this link:</strong><br>
            <code style="background: #f8f9fa; padding: 5px 10px; border-radius: 3px; word-break: break-all; font-family: monospace;">
                {{ route('contact.verify.token', $token) }}
            </code><br><br>
            <small style="color: #999;">This link expires in 30 minutes for security.</small>
        </p>
        
        <div class="footer">
            <p>Thanks,<br><strong>Your Website Team</strong></p>
            <p>If you didn't submit this form, please ignore this email.</p>
        </div>
    </div>
</body>
</html>