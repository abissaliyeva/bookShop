<h2>New Book Uploaded</h2>

<p><b>Title:</b> {{ $book->title }}</p>
<p><b>Author:</b> {{ $book->author }}</p>
<p><b>Price:</b> {{ $book->price }}</p>

<p>
    <a href="{{ asset('storage/' . $book->file_path) }}">
        Download File
    </a>
</p>