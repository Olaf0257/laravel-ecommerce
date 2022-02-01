<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mightAlsoLike = Product::mightAlsoLike()->get();

        return view('wishlist', compact('mightAlsoLike'));
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

        // Check if it's already in Wishlist
        if ($product->isInWishlist()) {
            return redirect()->back()->with('success-message', 'Item is already in Wishlist!');
        }

        // If item is in Cart
        if ($request->filled('row_id') && $product->isInCart()) {
            // Remove item from Cart
            Cart::instance('default')->remove($request->row_id);
        }

        // Add to Wishlist
        Cart::instance('wishlist')
            ->add($request->id, $request->name, 1, $request->price)
            ->associate('App\Product');

        return back()->with('success-message', 'Item was added to Wishlist!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);

        return redirect()->back()->with('success-message', 'Item was removed from Wishlist!');
    }
}
