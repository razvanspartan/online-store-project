@extends('layouts.app')

@section('content')

    <a href="{{route('products.index')}}">Back to products</a>

    <h1>Report</h1>

    @if ($orders->isNotEmpty())
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Order ID</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Order Date</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Customer Name</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Email</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Number of Products</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($orders as $order)
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $order['id'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $order['created_at'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $order['client_name'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $order['client_email'] }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $order['total_quantity'] }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>

    @else
        <p>No orders found matching the criteria.</p>
    @endif
@endsection
