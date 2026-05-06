<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Georgia, serif; background: #faf7f2; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #fff;
                   border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: #1a1a2e; padding: 32px 40px; text-align: center; }
        .header h1 { color: #c9a84c; font-size: 1.6rem; margin: 0; }
        .header p  { color: #9ca3af; font-size: 0.85rem; margin: 6px 0 0; }
        .body   { padding: 36px 40px; color: #1a1a2e; }
        .body h2 { font-size: 1.3rem; margin-bottom: 12px; }
        .body p  { line-height: 1.7; color: #374151; margin-bottom: 16px; }
        .btn { display: inline-block; background: #1a1a2e; color: #c9a84c !important;
               border: 2px solid #c9a84c; padding: 12px 28px; border-radius: 8px;
               text-decoration: none; font-weight: 600; }
        .footer { background: #f3f4f6; padding: 20px 40px; text-align: center;
                  font-size: 0.78rem; color: #9ca3af; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>📚 BookShop</h1>
        <p>Your literary journey starts here</p>
    </div>
    <div class="body">
        <h2>Welcome, {{ $user->name }}! 🎉</h2>
        <p>
            Thank you for joining <strong>BookShop</strong>. Your account is ready —
            explore our catalog, find your next great read, and start today.
        </p>
        <p>
            <a href="{{ url('/customer') }}" class="btn">Browse the Catalog →</a>
        </p>
        <p style="font-size:0.85rem;color:#6b7280;">
            If you did not create this account, you can safely ignore this email.
        </p>
    </div>
    <div class="footer">
        © {{ date('Y') }} Online Book Shop · All rights reserved
    </div>
</div>
</body>
</html>