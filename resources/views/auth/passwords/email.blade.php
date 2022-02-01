@extends('layout')

@section('title', 'Reset Password')

@section('content')
    
    <div class="container">
        <div class="auth-pages login">
            <div class="auth-left">
                <h2>{{ __('Reset Password') }}</h2>

                <div class="spacer"></div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div>
                        <label for="email">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="button button-black">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
