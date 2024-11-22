<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Record Created Notification</title>
    <style>
        /* Add custom styles for email clients */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            text-align: left;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #4f46e5;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
        }
        .footer {
            padding: 10px 20px;
            font-size: 12px;
            text-align: center;
            color: #888888;
        }
    </style>
</head>
<body>
    <div style="background-color: #f9f9f9; padding: 20px;">
        <div class="container">
            <!-- Logo Section -->
            <div class="logo">
                <img src="https://example.com/logo.png" alt="Logo" width="100" />
            </div>

            <!-- Content Section -->
            <div class="content">
                <h2 style="color: #333333;">Hi {{ $user->name }},</h2>
                <p style="color: #555555;">A new record has been created in your account:</p>
                <ul style="list-style-type: none; padding: 0;">
                    <li><strong>Name:</strong> {{ $package->name }}</li>
                    <li><strong>Tracking Number:</strong> {{ $package->tracking_number }}</li>
                    <li><strong>Purchase Source:</strong> {{ $package->purchase_source }}</li>
                </ul>
                <p style="color: #555555;">Click the button below to view more details:</p>
                <p>
                    <a href="{{ url('/') }}" class="button">View Details</a>
                </p>
                <p style="color: #555555;">Thanks,<br>The {{ config('app.name') }} Team</p>
            </div>

            <!-- Footer Section -->
            <div class="footer">
                <p>This email was sent to {{ $user->email }}. If this was not intended for you, you can ignore it.</p>
                <p>© {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
