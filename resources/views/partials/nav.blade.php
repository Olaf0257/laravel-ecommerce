<header>
    <div class="top-nav container large-devices-navbar">
        @if (request()->is('checkout') || request()->is('checkout/complete'))
	        <div class="logo logo-checkout"><a href="/">Ecommerce</a></div>
	    @else
	        <div class="logo"><a href="/">Ecommerce</a></div>
        @endif
        
        @if (! request()->is('checkout') && ! request()->is('checkout/complete'))
	        {{-- Main menu --}}
	        {{ menu('main', 'partials.menus.main') }}
	    @endif
    </div> <!-- end top-nav -->

    @include('partials/small-nav')
    
</header>