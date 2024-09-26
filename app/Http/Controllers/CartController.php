<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }
    public function index(){
        $cart = $this->cartService->getCart();
        return view('cart.index', compact('cart'));
    }
    public function add(Request $request){
        $cart = $this->cartService->addToCart($request->product_id, $request->quantity);
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }
    public function remove($id){
        $cart = $this->cartService->removeFromCart($id);
        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');

    }
}
