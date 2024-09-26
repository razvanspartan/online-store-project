<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    public function getCart()
    {
        return session()->get('cart', []);
    }

    public function addToCart($productId, $quantity)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }
}
