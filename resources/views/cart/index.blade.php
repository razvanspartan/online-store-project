@extends('layouts.app')

@section('content')
    <a href="{{route('products.index')}}">Back to products</a>

    <h1>Your Cart</h1>

    @if (count($cart) > 0)
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">#</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Product Name</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Quantity</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Old price</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Price</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Discount</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Total</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            @php $total = 0; $oldTotal = 0; $index = 1; $discountTotal = 0; @endphp
            @foreach ($cart as $productId => $item)
                @php
                    $product = App\Models\Product::find($productId);
                    $price = $item['price'];
                    $oldPrice = $item['old_price'] ?? 0;
                    $discount = $item['discount'] ?? 0
                @endphp

                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $index++ }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $product->title }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $item['quantity'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{is_string($oldPrice) ? $oldPrice : number_format($oldPrice,2)}}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($price, 2)}}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{is_string($discount) ? $discount : number_format($discount,2)}}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($price * $item['quantity'], 2)}}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">

                        <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>


                    </td>
                </tr>
                @php $total += $price * $item['quantity']; @endphp
                @php if(!is_string($oldTotal)) $oldTotal += $oldPrice * $item['quantity'];@endphp
                @php if(!is_string($discount)) $discountTotal += $discount *$item['quantity'];@endphp
            @endforeach
            </tbody>
        </table>

        <h3>Old Total: {{number_format($oldTotal,2)}}</h3>
        <h3>Total: {{number_format($total,2)}}</h3>
        <h3>Discount Total: {{number_format($discountTotal,2)}}</h3>
        <form method="POST" action="{{ route('cart.apply_coupon') }}">
            @csrf
            <div>
                <label for="coupon">Coupon Code:</label>
                <input type="text" id="coupon" name="coupon" placeholder="Enter your coupon code">
                <button type="submit">Apply Coupon</button>
            </div>
        </form>
        <a href="{{ route('checkout.index') }}">Proceed to Checkout</a>

    @else
        <p>Your cart is empty.</p>
    @endif
@endsection
