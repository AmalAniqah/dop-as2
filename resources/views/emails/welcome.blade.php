<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 150px;
            height: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2d3748;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            background-color: #3182ce;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #2c5aa0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #718096;
            font-size: 14px;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/pblogo.png') }}" alt="{{ config('app.name') }} Logo">
        </div>

        <!-- Header -->
        <div class="header">
            <h1>Welcome to {{ config('app.name') }}!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            
            <p>Thank you for joining {{ config('app.name') }}! We're excited to have you as part of our community.</p>
            
            @if (!$user->hasVerifiedEmail())
                <p>To get started, please verify your email address by clicking the button below:</p>
                
                <div class="button-container">
                    <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
                </div>
                
                <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
                <p style="word-break: break-all; color: #3182ce;">{{ $verificationUrl }}</p>
            @else
                <p>Your email has already been verified. You can start exploring our platform right away!</p>
                
                <div class="button-container">
                    <a href="{{ route('home') }}" class="button">Visit Our Website</a>
                </div>
            @endif
            
            <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
            
            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This email was sent to {{ $user->email }}.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>