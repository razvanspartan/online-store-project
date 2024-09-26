@extends('layouts.app')

@section('content')
    <a href="{{Route('cart.index')}}">Cart</a>
    <a href="{{Route('reports.index')}}">Report</a>
    <h1>Products</h1>

    @if($products->isEmpty())
        <p>No products available.</p>
    @else
        <ul>
            @foreach ($products as $product)
                <li>
                    <strong>Title:</strong> {{ $product->title }}<br>
                    <strong>Price:</strong> {{ $product->is_Taxable ? $product->price*1.19 : $product->price }}<br>
                    <strong>Categories:</strong>
                    @if ($product->categories->isNotEmpty())
                        @foreach ($product->categories as $category)
                            {{ $category->name }}@if (!$loop->last), @endif
                        @endforeach
                    @else
                        None
                    @endif
                    <br>
                    <a href="{{ route('products.show', $product->id) }}">See Details</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
