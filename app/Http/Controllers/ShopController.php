<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\SearchableProduct;
use Illuminate\Http\Request;
use MeiliSearch\Endpoints\Indexes;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
            
        if (request()->category) {
            $targetCategory = Category::where('slug', request()->category)->firstOrFail();
            $products = $targetCategory->products()->available();
            $categoryName = $targetCategory->name;
        } else {
            $products = Product::available()->Where('featured', TRUE);
            $categoryName = 'Featured';
        }

        if (request()->has('minPrice') && request()->has('maxPrice')) {
            $products->where('price', '>=', request()->minPrice)
                     ->where('price', '<=', request()->maxPrice);
        }

        if (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc');
        } else if (request()->sort == 'low_high') {
            $products = $products->orderBy('price');
        } else {
            $products = $products->inRandomOrder();
        }

        $products = $products->paginate(12);

        return view('shop', compact(['products', 'categories', 'categoryName']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $mightAlsoLike = Product::where('id', '!=', $id)->mightAlsoLike()->get();

        $productLevel = getProductLevel($product->quantity);

        return view('product', compact(['product', 'mightAlsoLike', 'productLevel']));
    }

    public function search(Request $request)
    {
        request()->validate([
            'query' => 'required|min:3'
        ]);
        
        $products = Product::search($request->input('query'))->where('quantity', '>', 0)->paginate(4);

        return view('search-results', compact('products'));
    }
}
