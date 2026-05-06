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
        .body h2 { font-size: 1.3rem; margin-bottom: 16px; }
        .body p  { line-height: 1.7; color: #374151; margin-bottom: 16px; }
        .book-card { background: #f9f5ee; border-left: 4px solid #c9a84c;
                     border-radius: 8px; padding: 16px 20px; margin: 20px 0; overflow: hidden; }
        .book-card .title  { font-size: 1.1rem; font-weight: 700; margin: 0 0 4px; }
        .book-card .author { font-size: 0.85rem; color: #6b7280; margin: 0 0 8px; }
        .book-card .price  { font-size: 1.2rem; color: #c9a84c; font-weight: 700; margin: 0; }
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
        <p>Order Confirmation</p>
    </div>
    <div class="body">
        <h2>Thank you, {{ $user->name }}!</h2>
        <p>Your order has been placed successfully. Here are your details:</p>

        <div class="book-card">
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}"
                     alt="{{ $book->title }}"
                     style="width:70px;height:95px;object-fit:cover;border-radius:4px;float:right;margin-left:16px;">
            @endif
            <p class="title">{{ $book->title }}</p>
            <p class="author">by {{ $book->author }}</p>
            <p class="price">${{ number_format($book->price, 2) }}</p>
        </div>

        <p>
            <a href="{{ url('/customer') }}" class="btn">Continue Shopping →</a>
        </p>
    </div>
    <div class="footer">
        © {{ date('Y') }} Online Book Shop · All rights reserved
    </div>
</div>
</body>
</html>