<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = session()->get('url.intended');

        $this->middleware('guest')->except('logout');
    }

    public function loginToCheckout()
    {
        if (Cart::content()->isEmpty())
            return redirect(route('login'));

        session(['login_to_checkout' => 'login_to_checkout']);
        session(['url.intended' => route('checkout.detailsIndex')]);

        return redirect(route('login'));
    }

    public function showLoginForm()
    {
        if (! session()->has('login_to_checkout')) {
            session(['url.intended' => url()->previous()]);

            return view('auth.login');
        }

        session()->forget('login_to_checkout');

        return view('auth.loginToCheckout');
    }
}
