<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mightAlsoLike = Product::mightAlsoLike()->get();
        
        return view('cart', [
            'mightAlsoLike' => $mightAlsoLike,
            'subtotal' => getNumbers()->get('subtotal'),
            'tax' => getNumbers()->get('tax'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'discount' => getNumbers()->get('discount'),
            'discountType' => getNumbers()->get('discountType'),
            'discountPercent' => getNumbers()->get('discountPercent'),
            'total' => getNumbers()->get('total'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->quantity == 0) {
            return back()->with('error-message', 'Item is not available!');
        }

        // Check if item's already in Cart
        if ($product->isInCart()) {
            return back()->with('success-message', 'Item is already in Cart!');
        }

        // If item is in Wishlist
        if ($request->has('row_id') && $product->isInWishlist()) {
            // Remove it from Wishlist
            Cart::instance('wishlist')->remove($request->row_id);
        }

        // Add to Cart
        Cart::instance('default')
            ->add($request->id, $request->name, 1, round($request->price, 2))
            ->associate('App\Product');

        return redirect()->route('cart.index')->with('success-message', 'Item was added to Cart successfully!');
    }

    /**
     * Update a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|between:1,' .$product->quantity
        ]);

        Cart::instance('default')->update($request->row_id, $request->quantity);

        return back()->with('success-message', 'Quantity was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $rowId
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success-message', 'Item was removed from Cart successfully!');
    }
}
