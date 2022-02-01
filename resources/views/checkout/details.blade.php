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
                <form action="{{ route('checkout.validateDetails') }}" method="POST" id="checkout-form">
                    <h2>Billing Details</h2>

                    @csrf

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required="">
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required="">
                    </div>

                    <div class="form-group">
                        <label for="billing_address">Address</label>
                        <input type="text" class="form-control" id="billing_address" name="billing_address" value="{{ old('billing_address') }}" required="">
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="form-control" id="country" name="country" required="">
                                <option value="">Select Country...</option>
                                @foreach (countries() as $country)
                                    <option value="{{ $country['val2'] }}" {{ old('country') == $country['val2'] ? 'selected' : '' }}>{{ $country['val0'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="half-form">
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required="">
                        </div>
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="number" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="spacer"></div>

                    <div class="address-checkbox-container">
                        <label id="address-checkbox" class="checkbox" for="same_shipping_address"><span class="check-mark">&#10003;</span></label> 
                        <input type="checkbox" name="same_shipping_address" id="same_shipping_address" class="hidden">
                        Check if Shipping Address is the same as Billing Address
                    </div>

                    <div id="shipping-details-container" class="shipping-details-container">
                        <h2>Shipping Details</h2>

                        <div class="form-group">
                            <label for="address_shipping">Address</label>
                            <input type="text" class="form-control" id="address_shipping" name="address_shipping" value="{{ old('address_shipping') }}" required="">
                        </div>

                        <div class="half-form">
                            <div class="form-group">
                                <label for="country_shipping">Country</label>
                                <select class="form-control" id="country_shipping" name="country_shipping" required="">
                                    <option value="">Select Country...</option>
                                    @foreach (countries() as $country)
                                        <option value="{{ $country['val2'] }}" {{ old('country_shipping') == $country['val2'] ? 'selected' : '' }}>{{ $country['val0'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city_shipping">City</label>
                                <input type="text" class="form-control" id="city_shipping" name="city_shipping" value="{{ old('city_shipping') }}" required="">
                            </div>
                        </div> <!-- end half-form -->

                        <div class="half-form">
                            <div class="form-group">
                                <label for="state_shipping">State</label>
                                <input type="text" class="form-control" id="state_shipping" name="state_shipping" value="{{ old('state_shipping') }}" required="">
                            </div>
                            <div class="form-group">
                                <label for="postal_code_shipping">Postal Code</label>
                                <input type="number" class="form-control" id="postal_code_shipping" name="postal_code_shipping" value="{{ old('postal_code_shipping') }}" required="">
                            </div>
                        </div> <!-- end half-form -->
                    </div><!-- end shipping details container -->
                    
                    <div class="spacer"></div>

                    <div>
                        <button type="submit" class="button button-blue can-be-disabled" id="checkout-submit-btn">Continue</button>
                    </div>
                </form><!-- end form -->
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

                                    @if (! $item->model->isAvailable())
                                        <span class="badge badge-danger">Not Available</span>
                                    @endif
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
    <script>
        const shippingDetailsContainer = document.querySelector('#shipping-details-container');
        const shippingAddressElementIDs = ['address_shipping', 'country_shipping', 'city_shipping', 'state_shipping', 'postal_code_shipping'];
        const customAddressCheckbox = document.querySelector('#address-checkbox');

        document.querySelector('#same_shipping_address').addEventListener('change', e => {
            if (e.target.checked) {
                shippingDetailsContainer.style.maxHeight = '0';

                shippingAddressElementIDs.forEach(id => {
                    document.querySelector('#' + id).required = false;
                })
            } else {
                shippingDetailsContainer.style.maxHeight = '1000px';

                shippingAddressElementIDs.forEach(id => {
                    document.querySelector('#' + id).required = true;
                })
            }
        });
    </script>
@endsection


