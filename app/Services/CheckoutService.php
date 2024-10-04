<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class CheckoutService
{
   public function addOrder($name, $email, $phone, $address){
      $order= Order::create([
           'name' => $name,
           'email' => $email,
           'phone' => $phone,
           'address' => $address,
       ]);
      $cart=session()->get('cart', []);
       foreach ($cart as $productId => $item) {
           $order->products()->attach($productId,
               [
                   'quantity' => $item['quantity'],
                   'price' => $item['price']
               ]);
       }
       session()->forget('cart');
   }
}
