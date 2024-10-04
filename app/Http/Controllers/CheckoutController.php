<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService){
        $this->checkoutService = $checkoutService;
    }

    public function index(){
        $cart=session()->get('cart',[]);
        return view('checkout.index', compact('cart'));
    }
    public function checkout(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
        ]);

        $this->checkoutService->addOrder($validatedData['name'], $validatedData['email'], $validatedData['phone'], $validatedData['address']);
        return redirect()->route('checkout.index')->with('success', 'Order placed successfully!');
    }
}
