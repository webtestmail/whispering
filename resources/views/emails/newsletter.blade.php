<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Newsletter</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; line-height: 1.6; color: #333; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 40px 30px; text-align: center; }
        .content { padding: 40px 30px; }
        .button { background: #007bff; color: white; padding: 12px 30px; text-decoration: none; border-radius: 25px; display: inline-block; font-weight: bold; }
        .footer { background: #f8f9fa; padding: 20px 30px; text-align: center; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Welcome Aboard!</h1>
            <p>You're now subscribed to our newsletter</p>
        </div>
        
        <div class="content">
            <h2>Hello!</h2>
            <p>Thank you for joining our newsletter community!</p>
            
            <p><strong>Your email:</strong> <code style="background: #e9ecef; padding: 4px 8px; border-radius: 4px;">{{ $email }}</code></p>
            
            <p>Expect exciting updates, offers, and news straight to your inbox.</p>
            
            <p style="text-align: center;">
                <a href="{{ route('home') }}" class="button">Explore Our Site</a>
            </p>
        </div>
        
        <div class="footer">
            <p>Happy subscribing!<br><small>Esma </small></p>
        </div>
    </div>
</body>
</html>