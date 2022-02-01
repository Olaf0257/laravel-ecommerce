@extends('layout')

@section('title', 'Login')

@section('content')

    <div class="container">
        <div class="auth-pages login">
            <div class="auth-left">
                @include('partials.errors')
                
                <h2>{{ __('Login') }}</h2>
                
                <div class="spacer"></div>

                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}

                    <div>
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>

                    <div>
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

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
        </div>
    </div>

@endsection
