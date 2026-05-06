@extends('app')

@section('content')

<h2>Add Book</h2>

<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="title" placeholder="Title"><br><br>
    <input type="text" name="author" placeholder="Author"><br><br>
    <input type="number" name="price" placeholder="Price"><br><br>

    <input type="file" name="file"><br><br>

    <button type="submit">Save Book</button>
</form>

@endsection