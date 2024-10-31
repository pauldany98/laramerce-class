<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(1);
        $cart = $user->cart;

        return view('carts.index')->with('cart', $cart);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // return request();
        $values = request()->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $productId = $values['product_id'];

        $user = User::find(1);
        $cart = $user->cart;
        // return $cart;
        if ($cart == null) {
            $cart = new Cart();
        }

        // check if this product has already been added to this cart
        $isInCartAlready = $cart->products()->get()->pluck('id')->contains($productId);
        if ($isInCartAlready) {
            return back()->with('error', 'Product already in cart');
        }

        $cart->products()->attach(
            $productId,
            ['quantity' => $values['quantity']]
        );
        $cart->save();

        return back()->with('success', 'Product added to cart');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    /**
     * Remove a product from the cart
     */
    public function remove(Cart $cart, Product $product)
    {
        $cart->products()->detach($product->id);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }
}