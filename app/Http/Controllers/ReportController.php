<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        $orders = Order::with(['products' => function ($query) {
            $query->where('price', '<', 100);
        }])
            ->whereHas('products.categories', function ($query) {
                $query->has('products', '>', 3);
            })
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'created_at' => $order->created_at,
                    'client_name' => $order->name,
                    'client_email' => $order->email,
                    'product_count' => $order->products->sum('pivot.quantity'),
                ];
            })
            ->sortBy('product_count');

        return view('reports.index', compact('orders'));
    }
}
