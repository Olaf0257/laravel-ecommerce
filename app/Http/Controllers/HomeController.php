<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\CustomerMessage;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featuredProducts = Product::available()
                            ->where('featured', TRUE)
                            ->where('quantity', '>', 0)
                            ->inRandomOrder()
                            ->take(8)
                            ->get();

        $newProducts = Product::available()
                            // ->whereRaw("DATEDIFF(CURDATE(), created_at) <= ". Product::NEW_PRODUCT_DURATION)
                            ->inRandomOrder()
                            ->take(4)
                            ->get();
                            

        return view('home', compact(['featuredProducts', 'newProducts']));
    }

    public function contact(Request $request)
    {
        \Mail::send(new CustomerMessage($request));

        return back()->with('success-message', 'Thanks! for your message. We will contact you shortly');
    }
}
