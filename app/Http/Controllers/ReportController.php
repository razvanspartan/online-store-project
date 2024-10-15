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
            ->whereDoesntHave('products', function ($query) {
                $query->where('order_product.price', '>=', 100);
            })
            ->whereHas('products.categories', function ($query) {
                $query->select('categories.id')
                    ->join('category_product as cp', 'categories.id', '=', 'cp.category_id')
                    ->groupBy('categories.id')
                    ->havingRaw('COUNT(cp.product_id) > 3');

            })
            ->selectRaw('
        orders.id,
        orders.created_at,
        orders.name as client_name,
        orders.email as client_email,
        SUM(order_product.quantity) as total_quantity
    ')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy('orders.id', 'orders.created_at', 'orders.name', 'orders.email')
            ->orderBy('total_quantity', 'desc')
            ->get();


        return view('reports.index', compact('orders'));
    }
}
