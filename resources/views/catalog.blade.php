<!DOCTYPE html>
<html>
<head>
    <title>Catalog</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .book {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        .book h3 {
            margin: 0;
        }

        .price {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>📚 Book Catalog</h1>

<!-- SEARCH -->
<form method="GET" action="/catalog" class="search-box">
    <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>

<!-- BOOK LIST -->
@if($books->isEmpty())
    <p>No books found.</p>
@else
    @foreach($books as $book)
        <div class="book">
            <h3>{{ $book->title }}</h3>
            <p><strong>Author:</strong> {{ $book->author }}</p>
            <p class="price">${{ $book->price }}</p>
            <p>{{ $book->description }}</p>
        </div>
    @endforeach
@endif

</body>
</html>