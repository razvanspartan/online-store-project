@extends('layouts.app')

@section('content')
    <a href="{{route('products.index')}}">Back to products</a>
    <h1>Checkout</h1>

    @if (session('cart') && count(session('cart')) > 0)
        <form  action="{{ route('checkout.order') }}" method="POST">
            @csrf

            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div>
                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>
            </div>

            <h3>Your Order</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px;">Product Name</th>
                    <th style="border: 1px solid #ddd; padding: 8px;">Quantity</th>
                    <th style="border: 1px solid #ddd; padding: 8px;">Price</th>
                    <th style="border: 1px solid #ddd; padding: 8px;">Total</th>
                </tr>
                </thead>
                <tbody>
                @php $total = 0; @endphp
                @foreach (session('cart') as $productId => $item)
                    @php
                        $product = App\Models\Product::find($productId);
                        $price = $product->is_taxable ? $product->price * 1.16 : $product->price;
                        $itemTotal = $price * $item['quantity'];
                        $total += $itemTotal;
                    @endphp
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $product->title }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item['quantity'] }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($price,2) }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $itemTotal }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h3>Order Total: {{number_format($total,2)}}</h3>

            <button type="submit">Submit Order</button>
        </form>
    @else
        <p>Your cart is empty. Please add products before checking out.</p>
    @endif
@endsection
