@extends('layout')

@section('title', 'Login')

@section('content')

    <div class="container">
        <div class="auth-pages login-checkout">
            <div class="auth-left">
                @include('partials.errors')

                <h2>Returning Customer</h2>
                <div class="spacer"></div>

                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}

                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Password" required>

                    <div class="login-container">
                        <button type="submit" class="button button-black">Login</button>
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>

                    <div class="spacer"></div>

                    <a href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>

                </form>
            </div>

            <div class="auth-right">
                <h2>New Customer</h2>
                <div class="spacer"></div>
                <p><strong>Save time now.</strong></p>
                <p>You don't need an account to checkout.</p>
                <div class="spacer"></div>
                <a href="{{ route('checkout.detailsIndex') }}" class="button button-white">Continue as Guest</a>
                <div class="spacer"></div>
                &nbsp;
                <div class="spacer"></div>
                <p><strong>Save time later.</strong></p>
                <p>Create an account for fast checkout and easy access to order history.</p>
                <div class="spacer"></div>
                <a href="{{ route('register') }}" class="button button-white">Create Account</a>
            </div>
        </div>
    </div>

@endsection
