<?php

namespace App\Http\Controllers\Checkout;

use App\Order;
use App\Paytabs\Paytabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Controllers\Checkout\CheckoutController;

class CreditCardCheckoutController extends CheckoutController
{
	protected const PAYMENT_METHOD = 'paytabs';

    /**
     * Send customer's info to PayTabs
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! isset($_COOKIE['checkout_details'])) {
            return redirect(route('checkout.detailsIndex'))->withErrors(['Provided data was expired! You need to enter your data again.']);
        }

        $this->checkRaceCondition();

        $request->validate($this->cardRules(), $this->messages());

        // Get checkout details from cookies and request and combine it with $orderDetails property
        $this->addToOrderDetails(json_decode($_COOKIE['checkout_details'], true), $request->except('_token'));

        $result = $this->createPayPageForPaytbas();

        // If there is an error while creating the pay page
        if (!isset($result->response_code) || $result->response_code != 4012) {
            // Insert into orders tables with error
            $this->addToOrderTables($result->result ?? $result->details ?? $result->error);

            return back()->withErrors('Something went wrong. Please try again!');
        }

        // Add "order_details" to cookie, so we can store the order into DB after payment is verified
        setcookie('order_details', json_encode($this->orderDetails), time()+600, '/');

        // Add cart to cookie becuase after the redirect, session is gonna be destroyed
        // We r gonna get it back to session in the "verify" method
        $cart = Cart::instance('default');
        if ($cart->count()) {
            setcookie('cart', $cart->content()->toJson(), time()+600, '/');
        }

        // Add wishlist to cookie
        $wishlist = Cart::instance('wishlist');
        if ($wishlist->count()) {
            setcookie('wishlist', $wishlist->content()->toJson(), time()+600, '/');
        }

        // Add coupon to cookie
        if (session()->has('coupon')) {
            setcookie('coupon', json_encode(session()->get('coupon'), true), time()+600, '/');
        }

        // Same as wishlist, we r gonna add the "user_id" to cookie, if not a guest
        // And use it later to authenticate them again
        if (auth()->user()) {
            setcookie('user_id', auth()->id(), time()+600, '/');
        }

        return redirect($result->payment_url);
    }

    /**
     * Verify that payment is successful
     *
     * @param \Illuminate\Http\Request $request
     */
    public function verify(Request $request)
    {
        $pt = new Paytabs(config('services.paytabs.merchant_email'), config('services.paytabs.secret_key'));

        $result = $pt->verify_payment($request->payment_reference);

        // Get cart & wishlist from cookie back to session
        $this->getFromCookieToSession('wishlist');
        $this->getFromCookieToSession('cart');

        deleteCookie('wishlist');
        deleteCookie('cart');

        // Get coupon from cookie to session
        if (isset($_COOKIE['coupon'])) {
	        session()->put('coupon', json_decode($_COOKIE['coupon'], true));

	        deleteCookie('coupon');
	    }

        // Authenticate user if they were logged in
        if (! empty($id = $_COOKIE['user_id'] ?? null)) {
            \Auth::loginUsingId($id);

            deleteCookie('user_id');
        }

        $cardDetails = [
            'transaction_id' => $result->transaction_id,
            'card_brand' => $result->card_brand,
            'card_first_six_digits' => $result->card_first_six_digits,
            'card_last_four_digits' => $result->card_last_four_digits,
        ];
        
        $this->addToOrderDetails(json_decode($_COOKIE['order_details'], true), $cardDetails);

        $order = $this->addToOrderTables();

        // successful payment
        if ($result->response_code == 100) {
	        deleteCookie('checkout_details');
	        deleteCookie('order_details');

            $this->successfulPayment($order);

            return redirect(route('thankyou'));
        }

        // Add error to the order in DB if payment failed
        $order->update([
            'error' => $result->result,
        ]);

        // Get coupon from cookie to session
        if (! empty($coupon = $_COOKIE['coupon'] ?? null)) {
            session()->put('coupon', json_decode($coupon, true));
        }

        return redirect(route('checkout.completeIndex'))->withErrors($result->result);
    }

    protected function cardRules()
    {
        return [
            'cc_first_name' => 'required',
            'cc_last_name' => 'required',
            'cc_phone_number' => 'required',
        ];
    }

    protected function createPayPageForPaytbas()
    {
        $pt = new Paytabs(config('services.paytabs.merchant_email'), config('services.paytabs.secret_key'));

        return $pt->create_pay_page($this->getPaymentInfo());
    }

    protected function getPaymentInfo()
    {
        // Payment details
        $cartProducts = Cart::instance('default')->content();
        $productsPerTitle = implode(' || ', $cartProducts->pluck('name')->toArray());
        $productsPerQuantity = implode(' || ', $cartProducts->pluck('qty')->toArray());
        $unitPrice = implode(' || ', $cartProducts->pluck('price')->toArray());

        return array(
            //Customer's Personal Information
            'cc_first_name' => $this->orderDetails->cc_first_name,
            'cc_last_name' => $this->orderDetails->cc_last_name,  
            'cc_phone_number' => $this->orderDetails->cc_phone_number,
            'phone_number' => $this->orderDetails->phone_number,
            'email' => $this->orderDetails->email,
            
            //Customer's Billing Address (All fields are mandatory)
            //When the country is selected as USA or CANADA, the state field should contain a String of 2 characters containing the ISO state code otherwise the payments may be rejected. 
            //For other countries, the state can be a string of up to 32 characters.
            'billing_address' => $this->orderDetails->billing_address,
            'city' => $this->orderDetails->city,
            'state' => $this->orderDetails->state,
            'postal_code' => $this->orderDetails->postal_code,
            'country' => $this->orderDetails->country,
            
            //Customer's Shipping Address (All fields are mandatory)
            'address_shipping' => $this->orderDetails->address_shipping,
            'city_shipping' => $this->orderDetails->city_shipping,
            'state_shipping' => $this->orderDetails->state_shipping,
            'postal_code_shipping' => $this->orderDetails->postal_code_shipping,
            'country_shipping' => $this->orderDetails->country_shipping,
           
            //Product Information
            "products_per_title" => $productsPerTitle,   				 //Product title of the product. If multiple products then add “||” separator  ex: "Product1 || Product 2 || Product 4"
            'quantity' => $productsPerQuantity,                          //Quantity of products. If multiple products then add “||” separator  ex: "1 || 1 || 1"
            'unit_price' => $unitPrice,                                  //Unit price of the product. If multiple products then add “||” separator.
            "other_charges" => getNumbers()->get('tax'),                 //Additional charges. e.g.: shipping charges, taxes, VAT, etc.         
            'amount' => getNumbers()->get('newSubtotal'),                      //Amount of the products and other charges, it should be equal to: amount = (sum of all products’ (unit_price * quantity)) + other_charges
            'discount'=> getNumbers()->get('discount'),                  //Discount of the transaction. The Total amount of the invoice will be= amount - discount
            'currency' => config('payment.currency'),                    //Currency of the amount stated. 3 character ISO currency code 
            
            //Invoice Information
            'title' => $this->orderDetails->cc_first_name . ' ' . $this->orderDetails->cc_last_name,          // Customer's Name on the invoice
            "msg_lang" => config('app.locale'),                 //Language of the PayPage to be created. Invalid or blank entries will default to English.(Englsh/Arabic)
            "reference_no" => "1231231",        //Invoice reference number in your system
           
            //Website Information
            "site_url" => config('services.paytabs.site_url'),      //The requesting website be exactly the same as the website/URL associated with your PayTabs Merchant Account
            'return_url' => route('checkout.verify'),
            "cms_with_version" => "API USING PHP",

            "paypage_info" => "1"
        );
    }

    protected function getFromCookieToSession($index)
    {
        if (! empty($items = $_COOKIE[$index] ?? null)) {
            foreach (json_decode($items) as $itemId => $item) {
                Cart::instance($index == 'wishlist' ? 'wishlist' : 'default')
                    ->add($item->id, $item->name, $item->qty, $item->price)
                    ->associate('App\Product');
            }
        }
    }

}
