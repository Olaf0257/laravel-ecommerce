<?php

namespace App\Http\Controllers\Checkout;

use App\Paypal\PayPalClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use App\Http\Controllers\Checkout\CheckoutController;

class PaypalCheckoutController extends CheckoutController
{
    protected const PAYMENT_METHOD = 'paypal';
    protected const DEFAULT_ERROR_MESSAGE = 'Something went wrong. Please try again later.';

    private $debug = false;

    public function __construct()
    {
        parent::__construct();
        
        // set_error_handler('checkoutErrorHandler');
    }

    /**
     * Set up the server to receive a call from the client
     */
    public function store()
    {
        try {
            if (! isset($_COOKIE['checkout_details'])) {
                return $this->handlerErrorForFrontEnd('Provided data was expired! You need to enter your data again.', route('checkout.detailsIndex'));
            }
            
            $this->checkRaceCondition();

            $this->addToOrderDetails(json_decode($_COOKIE['checkout_details'], true));

            $response = $this->connectToPayPal();
            
            if ($this->debug)
            {
                echo json_encode($response->result, JSON_PRETTY_PRINT);
            }

            // Return a successful response to the client.
            return json_encode($response->result);
        } catch (\Exception $e) {
            return $this->handlerErrorForFrontEnd(
                // CHECKOUT_ERROR['userMessage'] ?? self::DEFAULT_ERROR_MESSAGE, 
                self::DEFAULT_ERROR_MESSAGE, 
                route('checkout.completeIndex')
            );
        }
    }

    /**
     * Retrieve an order from paypal using order id
     */
    public function captureOrder(Request $request)
    {
        try {
            if (! isset($_COOKIE['checkout_details'])) {
                return $this->handlerErrorForFrontEnd(
                    'Provided data was expired! You need to enter your data again.', 
                    route('checkout.detailsIndex')
                );
            }

            $request = new OrdersCaptureRequest($request->orderID);
            
            // Call PayPal to capture an authorization
            $client = PayPalClient::client();
            $response = $client->execute($request);

            $userInfo = [
                'transaction_id' => $response->result->id,
                'cc_first_name' => $response->result->payer->name->given_name,
                'cc_last_name' => $response->result->payer->name->surname
            ];

            // Get checkout details from cookies and combine it with $orderDetails property
            $this->addToOrderDetails(json_decode($_COOKIE['checkout_details'], true), $userInfo);
            
            DB::transaction(function () {
                // Save the transaction to the database.
                $order = $this->addToOrderTables();

                $this->successfulPayment($order);
            });

            return json_encode(route('thankyou'));
        } catch (\Exception $e) {
            return $this->handlerErrorForFrontEnd(
                // CHECKOUT_ERROR['userMessage'] ?? self::DEFAULT_ERROR_MESSAGE, 
                self::DEFAULT_ERROR_MESSAGE, 
                route('checkout.completeIndex')
            );
        }
    }

    protected function connectToPayPal()
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = self::buildRequestBody();

        // Call PayPal to set up a transaction
        $client = PayPalClient::client();
        return $client->execute($request);
    }

    /**
     * Setting up the JSON request body for creating the order with minimum request body.
     */
    private function buildRequestBody()
    {
        $country_code = $this->orderDetails->country_shipping;

        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
                array(
                    'return_url' => route('thankyou'),
                    'cancel_url' => route('checkout.completeIndex'),
                ),
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => 'USD',
                                    'value' => convertCurrency(getNumbers()->get('total')),
                                ),
                            'shipping' =>
                                array(
                                  'address' =>
                                    array(
                                      'address_line_1' => $this->orderDetails->address_shipping,
                                      'address_line_2' => '',
                                      'admin_area_2' => $this->orderDetails->state_shipping,
                                      'admin_area_1' => $this->orderDetails->city_shipping,
                                      'postal_code' => $this->orderDetails->postal_code_shipping,
                                      'country_code' => substr($country_code, 0, 2),
                                    ),
                                ),
                        )
                )
        );
    }

    protected function handlerErrorForFrontEnd($msg, $route)
    {
        session()->flash('error-msg', $msg);

        return json_encode([
            'error' => true, 
            'redirect_url' => $route,
        ]);
    }
}
