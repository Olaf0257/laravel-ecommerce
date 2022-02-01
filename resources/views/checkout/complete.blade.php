@extends('layout')

@section('title', 'Checkout')

@section('extra-css')

@endsection

@section('content')

    <div class="container">

        <h1 class="checkout-heading stylish-heading">Checkout</h1>

        {{-- Validation Errors --}}
        @include('partials.errors')

        @if ($productsAreNoLongerAvailable)
            <div class="validation-error-msg">{{ $productsAreNoLongerAvailable }}</div>
        @endif

        <div class="checkout-section">
            <div class="checkout-section-left">
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    <h2>Card Details</h2>

                    @csrf

                    <div class="half-form">
                        <div class="form-group">
                            <label for="cc_first_name">First Name on Card</label>
                            <input type="text" class="form-control" id="cc_first_name" name="cc_first_name" value="{{ old('cc_first_name') }}" required="">
                        </div>
                        <div class="form-group">
                            <label for="cc_last_name">Last Name on Card</label>
                            <input type="text" class="form-control" id="cc_last_name" name="cc_last_name" value="{{ old('cc_last_name') }}" required="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="form-group">
                        <label for="cc_phone_number">Card Phone Number</label>
                        <input type="text" class="form-control" id="cc_phone_number" name="cc_phone_number" value="{{ old('cc_phone_number') }}" required="">
                    </div>
                    
                    <div class="spacer"></div>

                    <div>
                        <button type="submit" class="button button-blue can-be-disabled checkout-with-credit-card-button" id="checkout-submit-btn">Checkout with Credit Card</button>
                    </div>

                </form><!-- end form -->

                <div class="separator">
                    <span class="line"></span>
                    <span class="or">or</span>
                    <span class="line"></span>
                </div>

                {{-- Paypal Button --}}
                <div id="smart-button-container">
                    @csrf
                    <div style="text-align: center;">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>

            <div class="checkout-section-right">
                <h2>Your Order</h2>

                <div class="checkout-table">
                    @foreach (Cart::content() as $item)
                        <div class="checkout-table-row">
                            <div class="checkout-table-row-left">
                                <img src="{{ $item->model->imgPath() }}" alt="{{ $item->model->name }}" class="checkout-table-img">
                                <div class="checkout-item-details">
                                    <div class="checkout-table-item">{{ $item->model->name }}</div>
                                    <div class="checkout-table-description">{{ $item->model->details }}</div>
                                    <div class="checkout-table-price">{{ $item->model->presentPrice() }}</div>
                                </div>
                            </div> <!-- end checkout-table -->

                            <div class="checkout-table-row-right">
                                <div class="checkout-table-quantity">{{ $item->qty }}</div>
                            </div>
                        </div> <!-- end checkout-table-row -->
                    @endforeach

                </div> <!-- end checkout-table -->

                @include('checkout.partials.checkout-totals')
            </div>
        </div> <!-- end checkout-section -->
    </div>

@endsection


@section('extra-js')

    {{-- Script for paypal button --}}
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&disable-funding=card" data-sdk-integration-source="button-factory"></script>
    <script>
        var csrfToken = document.querySelector('#smart-button-container input[name="_token"]').value;

        function initPayPalButton() {
          paypal.Buttons({
            style: {
              shape: 'pill',
              color: 'white',
              layout: 'vertical',
              label: 'checkout',
              
            },

            createOrder: function() {
              return fetch("{{ route('paypal-checkout.store') }}", {
                method: 'post',
                headers: {
                  'content-type': 'application/json'
                },
                body: JSON.stringify({
                  _token: csrfToken
                })
              }).then(function(res) {
                return res.json();
              }).then(function(data) {
                if (data.error) {
                    window.location = data.redirect_url;

                    return;
                }

                return data.id;
              });
            },

            onApprove: function(data) {
              return fetch("{{ route('paypal-checkout.captureOrder') }}" + "?orderID=" + data.orderID, {
                headers: {
                  'content-type': 'application/json'
                },
              }).then(function(res) {
                return res.json();
              }).then(function(data) {
                if (data.error) {
                    window.location = data.redirect_url;

                    return;
                }

                window.location = data;
              });
            },

            // onError: function(err) {
            //   console.log(err.json());
            // }
          }).render('#paypal-button-container');
        }
        initPayPalButton();
    </script>

@endsection


