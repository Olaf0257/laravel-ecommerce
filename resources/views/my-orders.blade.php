@extends('layout')

@section('title', 'My Orders')

@section('extra-css')
@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <div>
                <a href="/">Home</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <span class="visited">My Orders</span>
            </div>
            
            @include('partials.search-form')
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="products-section container profile-section">
        @include('partials.profile-sidebar')

        <div class="products-section-all">
            <h1 class="stylish-heading">My Orders</h1>

            @foreach ($orders as $order)
                <table class="orders-table">
                    <thead>
                        <tr class="head-tr">
                            <th class="first-th">
                                <div>
                                    <h4>Order Placed</h4>
                                    <div>{{ $order->created_at->toFormattedDateString() }}</div>
                                </div>

                                <div>
                                    <h4>Order ID</h4>
                                    <div>{{ $order->id }}</div>
                                </div>

                                <div>
                                    <h4>Total</h4>
                                    <div>{{ presentPrice($order->total) }}</div>
                                </div>
                            </th>

                            <th class="last-th">
                                <a href="{{ route('orders.show', $order->id) }}">Order Details</a>
                                <a href="">Invoice</a>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="products-box">
                        <tr class="order-products">
                            @foreach ($order->products as $product)
                                <td class="product-details">
                                    <img src="{{ $product->imgPath() }}" alt="{{ $product->name }}">

                                    <div>
                                        <div><a class="product-name" href="{{ route('shop.show', $product) }}">{{ $product->name }}</a></div>
                                        <div class="product-price">{{ $product->presentPrice() }}</div>
                                        <div>Quantity:  {{ $product->pivot->quantity }}</div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table> <!-- end table -->
            @endforeach
        </div>
    </div> <!-- end product-section -->

@endsection

@section('extra-js')
@endsection

