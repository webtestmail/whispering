<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 600; letter-spacing: -0.5px;">
                                📧 New Contact Message
                            </h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
                                Someone filled out your contact form
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <!-- Contact Details -->
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 15px 0; font-weight: 600; color: #495057; border-bottom: 2px solid #e9ecef; font-size: 16px;">
                                        👤 Name
                                    </td>
                                    <td style="padding: 15px 0; color: #333333; font-size: 16px; word-break: break-word;">
                                        {{ $data['name'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px 0; font-weight: 600; color: #495057; border-bottom: 2px solid #e9ecef; font-size: 16px;">
                                        ✉️ Email
                                    </td>
                                    <td style="padding: 15px 0; color: #333333; font-size: 16px;">
                                        <a href="mailto:{{ $data['email'] ?? '' }}" style="color: #007bff; text-decoration: none; font-weight: 500;">
                                            {{ $data['email'] ?? 'N/A' }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 15px 0; font-weight: 600; color: #495057; border-bottom: 2px solid #e9ecef; font-size: 16px;">
                                        📋 Subject
                                    </td>
                                    <td style="padding: 15px 0; color: #333333; font-size: 16px;">
                                        {{ $data['subject'] ?? 'No subject' }}
                                    </td>
                                </tr>
                            </table>

                            <!-- Message -->
                            <div style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 10px; padding: 25px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 20px 0; color: #333333; font-size: 20px; font-weight: 600; display: flex; align-items: center;">
                                    💬 Message
                                </h3>
                                <div style="background: #ffffff; border-radius: 8px; padding: 20px; border-left: 4px solid #667eea; line-height: 1.7;">
                                    {!! nl2br(e($data['message'] ?? 'No message provided')) !!}
                                </div>
                            </div>

                            <!-- Timestamp -->
                            <div style="text-align: center; padding: 20px; background-color: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                                <p style="margin: 0; color: #6c757d; font-size: 14px;">
                                    <strong>Received:</strong> {{ now()->format('F j, Y \a\t g:i A') }}<br>
                                    Submitted via website contact form
                                </p>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px; background-color: #f8f9fa; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0 0 10px 0; color: #6c757d; font-size: 14px;">
                                This is an automated message from your website.
                            </p>
                            <p style="margin: 0; color: #adb5bd; font-size: 12px;">
                                © {{ now()->year }} Your Website. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>