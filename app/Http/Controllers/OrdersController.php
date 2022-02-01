<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()
                    ->orders()
                    ->errorFree()
                    ->with('products')
                    ->where('error', null)
                    ->get();

        return view('my-orders', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Order   $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        abort_if(auth()->id() !== $order->user_id, 404);
        
        $products = $order->products;

        return view('my-order', compact(['order', 'products']));
    }
}
