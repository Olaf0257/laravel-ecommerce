<?php

namespace App\Http\Controllers\Checkout;

use App\Order;
use App\Product;
use App\OrderProduct;
use App\Mail\OrderPlaced;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public $orderDetails;

    public function __construct()
    {
        $this->orderDetails = new \StdClass;
    }

    public function detailsIndex()
    {
        return $this->handleView('checkout.details');
    }

    public function validateDetails(Request $request)
    {
        $this->checkRaceCondition();

        if ($request->same_shipping_address) {
            $request->merge([
                'address_shipping' => $request->billing_address,
                'country_shipping' => $request->country,
                'city_shipping' => $request->city,
                'state_shipping' => $request->state,
                'postal_code_shipping' => $request->postal_code
            ]);
        }
        
        $request->validate($this->detailsRules(), $this->messages());

        setcookie('checkout_details', json_encode($request->except('_token'), true), time()+600, '/');

        return redirect(route('checkout.completeIndex'));
    }

    public function completeIndex()
    {
        if (! isset($_COOKIE['checkout_details'])) {
            return redirect(route('checkout.detailsIndex'));
        }

        return $this->handleView('checkout.complete');
    }

    protected function handleView($route)
    {
        if (Cart::content()->isEmpty()) {
            return redirect(route('cart.index'));
        }

        $productsAreNoLongerAvailable = $this->productsAreNoLongerAvailable();

        return view($route)->with([
            'subtotal' => getNumbers()->get('subtotal'),
            'tax' => getNumbers()->get('tax'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'discount' => getNumbers()->get('discount'),
            'discountType' => getNumbers()->get('discountType'),
            'discountPercent' => getNumbers()->get('discountPercent'),
            'total' => getNumbers()->get('total'),
            'productsAreNoLongerAvailable' => $productsAreNoLongerAvailable
        ]);
    }

    protected function productsAreNoLongerAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            if ($product->quantity < $item->qty) {
                return 'Sorry! One of the items in your cart is no longer available.';
            }
        }

        return false;
    }

    protected function reduceProductsQuantity(Order $order)
    {
        foreach ($order->products as $product) {
            $product->update([
                'quantity' => $product->quantity - $product->pivot->quantity
            ]);
        }

        // We use it so we can skip updating the searchable product which requires using meilisearch master key
        setcookie('dontUpdateSearchable', 'dontUpdateSearchable', time()+600, '/');
    }

    protected function detailsRules()
    {
        $emailRule = auth()->user() ? 'required|email' : 'required|email|unique:users';

        return [
            'email' => $emailRule,
            'phone_number' => 'required',
            'billing_address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required|numeric',
            'address_shipping' => 'required',
            'country_shipping' => 'required',
            'city_shipping' => 'required',
            'state_shipping' => 'required',
            'postal_code_shipping' => 'required|numeric',
        ];
    }

    protected function messages()
    {
        return [
            'email.unique' => 'You already have an account with this email address. Please <a href="'.route('login').'">login</a> to continue.'
        ];
    }

    protected function addToOrderTables($error = null)
    {
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->id() : null,
            'billing_email' => $this->orderDetails->email,
            'billing_phone' => $this->orderDetails->phone_number,
            'billing_address' => $this->orderDetails->billing_address,
            'billing_country' => $this->orderDetails->country,
            'billing_city' => $this->orderDetails->city,
            'billing_state' => $this->orderDetails->state,
            'billing_postal_code' => $this->orderDetails->postal_code,
            'shipping_address' => $this->orderDetails->address_shipping,
            'shipping_country' => $this->orderDetails->country_shipping,
            'shipping_city' => $this->orderDetails->city_shipping,
            'shipping_state' => $this->orderDetails->state_shipping,
            'shipping_postal_code' => $this->orderDetails->postal_code_shipping,
            'cc_first_name' => $this->orderDetails->cc_first_name,
            'cc_last_name' => $this->orderDetails->cc_last_name,  
            'cc_phone' => $this->orderDetails->cc_phone_number ?? null,
            'subtotal' => getNumbers()->get('subtotal'),
            'tax' => getNumbers()->get('tax'),
            'discount' => getNumbers()->get('discount'),
            'discount_code' => getNumbers()->get('discountCode'),
            'total' => getNumbers()->get('total'),
            'payment_gateway' => static::PAYMENT_METHOD,
            'transaction_id' => $this->orderDetails->transaction_id ?? null,
            'card_brand' => $this->orderDetails->card_brand ?? null,
            'card_first_six_digits' => $this->orderDetails->card_first_six_digits ?? null,
            'card_last_four_digits' => $this->orderDetails->card_last_four_digits ?? null,
            'error' => $error
        ]);

        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty
            ]);
        }

        return $order;
    }

    protected function addToOrderDetails(...$details)
    {
        foreach ($details as $arr) {
            foreach ($arr as $index => $value) {
                $this->orderDetails->{$index} = $value;
            }
        }
    }

    /**
     * Check race condition when there are less items available to purchase
     */
    protected function checkRaceCondition()
    {
        if ($this->productsAreNoLongerAvailable()) {
            header('Location: ' . url()->previous());
            exit();
        }
    }

    protected function successfulPayment(Order $order)
    {
        $this->reduceProductsQuantity($order);

        //Mail::send(new OrderPlaced($order));

        Cart::instance('default')->destroy();

        if (session()->has('coupon')) {
            session()->forget('coupon');
        }
    }
}
