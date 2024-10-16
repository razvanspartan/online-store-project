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
        $this->cartService->addToCart($request->product_id, $request->quantity);
        $couponApplied = false;
        $cart=session()->get('cart', []);
        foreach($cart as $cartItem) {
            echo(isset($cartItem['appliedCoupon']));
            if(isset($cartItem['appliedCoupon'])){
                $couponApplied = true;
                break;
            }
        }
        echo($couponApplied);
        if($couponApplied){
            $this->cartService->apply_coupon();
        }
        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }
    public function remove($id){
        $cart = $this->cartService->removeFromCart($id);
        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');

    }
    public function apply_coupon(Request $request){
        $request->validate([
            'coupon' => 'required|string'
        ]);

        $coupon = $request->input('coupon');

        if ($coupon === 'PROMO7352'){
            $cart = $this->cartService->apply_coupon();
            return redirect()->route('cart.index');
        }
        else{
            return redirect()->route('cart.index')->with('error', 'Invalid coupon code.');
        }
    }
}
