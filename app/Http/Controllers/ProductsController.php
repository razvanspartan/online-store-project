<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        $products = Product::with('categories')->get();

        return view('products.index', compact('products'));
    }
    public function show($id) {
        $product = Product::with('categories')->findOrFail($id);
        return view('products.show', compact('product'));
    }
}
