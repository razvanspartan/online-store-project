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
                'price' => $product->is_taxable ? $product->price*1.19 : $product->price,
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
    public function apply_coupon(){
        $cart = session()->get('cart', []);
        foreach($cart as $productId => $item){
            $product = Product::findOrFail($productId);
            $oldPrice = $item['price'];
            $discount = 0;

            foreach($product->categories as $category) {
                if (in_array($category->id, [1, 3])) {
                    $discount = 100;
                }
            }
            if(!$discount) {
                if ($item['quantity'] > 5) {
                    $discount = $oldPrice * 0.20;
                } elseif ($item['quantity'] > 3) {
                    $discount = $oldPrice * 0.10;
                }
            }
            $newPrice = max(0,$oldPrice - $discount);
            $cart[$productId]['old_price'] = $oldPrice;
            $cart[$productId]['price'] = $newPrice;
            $cart[$productId]['discount'] = $discount;

        }
        session()->put('cart', $cart);



}
}
