@extends('layouts.app')
@section('content')
    <h1>{{ $product->title }}</h1>
    <p><strong>Price:</strong> {{ $product->price }}</p>
    <p><strong>Description:</strong> {{ $product->description ?? 'No description available' }}</p>
    <p><strong>Categories:</strong>
        @foreach ($product->categories as $category)
            {{ $category->name }}@if (!$loop->last), @endif
        @endforeach
    </p>
    <form action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1">

        <button type="submit">Add to Cart</button>
    </form>
    <a href="{{ route('products.index') }}">Back to Products</a>
@endsection
