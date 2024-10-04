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
            $query->where('order_product.price', '<', 100);
        }])
            ->whereHas('products.categories', function ($query) {
                $query->has('products', '>', 3);
            })
            ->selectRaw('
                orders.id,
                orders.created_at,
                orders.name as client_name,
                orders.email as client_email,
                SUM(order_product.quantity) as product_count,
                SUM(order_product.price * order_product.quantity) as total_price'  // Calculate total price based on new_price
            )
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy('orders.id', 'orders.created_at', 'orders.name', 'orders.email')
            ->orderBy('product_count', 'desc')
            ->get();

        return view('reports.index', compact('orders'));
    }
}
