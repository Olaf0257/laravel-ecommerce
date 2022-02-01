<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->

        <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    </head>
    <body>
        <header class="with-background">
            <div class="top-nav container large-devices-navbar">
                <div class="logo"><a href="/">Ecommerce</a></div>

                {{-- Main menu --}}
                {{ menu('main', 'partials.menus.main') }}
            </div> <!-- end top-nav -->

            @include('partials/small-nav')

            <div class="hero container">
                <div class="hero-copy">
                    <h1>Laravel Ecommerce Demo</h1>
                    <p>Includes multiple products, categories, a shopping cart, a wishlist and a checkout system with credit card and paypal integration.</p>
                    <div class="hero-buttons">
                        <a href="{{ route('shop.index') }}" class="button button-trans">SHOP NOW</a>
                    </div>
                </div> <!-- end hero-copy -->

                <div class="hero-image">
                    <img src="{{ asset('/images/macbook-pro-laravel.png') }}" alt="hero image">
                </div> <!-- end hero-image -->
            </div> <!-- end hero -->
        </header>

        <div class="home-products-section">

            <div class="container">
                <h1 class="text-center">Laravel Ecommerce</h1>

                <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore vitae nisi, consequuntur illum dolores cumque pariatur quis provident deleniti nesciunt officia est reprehenderit sunt aliquid possimus temporibus enim eum hic.</p>
            </div> <!-- end container -->

            <div class="products-container">
                <div class="cards-container">
                    <h2>New Products</h2>

                    <div class="cards text-center">
                        @foreach ($newProducts as $product)    
                            @include('partials/product-card')
                        @endforeach
                    </div> <!-- end products -->
                </div>

                <div class="cards-container">
                    <h2>Featured Products</h2>
                    
                    <div class="cards text-center">
                        @foreach ($featuredProducts as $product)    
                            <div>
                                @include('partials/product-card')
                            </div>
                        @endforeach
                    </div> <!-- end products -->
                </div>

                <div class="text-center button-container">
                    <a href="{{ route('shop.index') }}" class="button button-white">View more products</a>
                </div>
            </div>
        </div> <!-- end home-products-section -->

        @include('partials.session-messages')

        @include('partials.contact')

        @include('partials.footer')

        <script src="js/app.js"></script>

    </body>
</html>
