@extends('layout')

@section('title', $product->name)

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/docs-searchbar.js/dist/cdn/docs-searchbar.min.css" />
@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <div>
                <a href="/">Home</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <a href="{{ route('shop.index') }}">Shop</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <span class="visited">{{ substr($product->name, 0, 20) }}</span>
            </div>
            
            @include('partials.search-form')
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="product-section container">
        <div class="product-section-images">
            <div class="product-section-main-image">
                <img src="{{ $product->imgPath() }}" class="active" id="main_image" alt="product">
            </div>

            @if ($product->images)
                @if (count($images = json_decode($product->images)) > 0)
                    <div class="product-section-thumbnails">
                        <div class="product-section-thumbnail selected">
                            <img src="{{ $product->imgPath() }}" class="thumbnail" alt="product">
                        </div>

                        @foreach ($images as $image)
                            <div class="product-section-thumbnail">
                                <img src="{{ asset('images/' . $image) }}" class="thumbnail" alt="product">
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>

        <div class="product-section-information">
            <div class="product-section-first-row">
                <div class="product-section-title-badges">
                    <h2 class="product-section-title">{{ $product->name }}</h2>

                    <div class="product-badges">
                        {!! $productLevel !!}

                        @if ($product->isNew())
                            <span class="badge product-badge-new">New</span>
                        @endif    
                    </div> <!-- end product badges -->
                </div>
                
                @if ($product->isInWishlist())
                    {{-- Remove from wishlist from --}}
                    <form class="heart-item-form" action="{{ route('wishlist.destroy', $product->getCartRowId('wishlist')) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="button-icon" title="Remove from Wishlist">
                            <span class="remove-from-wishlist">Remove from Wishlist</span>&nbsp;<i class="fas fa-heart solid-heart"></i>
                        </button>
                    </form>
                @else
                    {{-- Add to wishlist form --}}
                    <form class="heart-item-form" action="{{ route('wishlist.store') }}" method="post">
                        @csrf

                        <input type="hidden" name="row_id" value="{{ $product->getCartRowId('wishlist') }}">
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <button type="submit" class="button-icon" title="Add to Wishlist">
                            <span class="add-to-wishlist">Add to Wishlist</span>&nbsp;<i class="far fa-heart"></i>
                        </button>
                    </form>
                @endif
            </div>

            <div class="product-section-subtitle">{{ $product->details }}</div>
            
            <div class="product-section-price">{{ $product->presentPrice() }}</div>

            <p>{!! $product->description !!}</p>

            <p>&nbsp;</p>

            @if ($product->isAvailable())
                @if ($product->isInCart())
                    <div class="alert-success">Item is already in Cart</div>
                @else 
                    <form action="{{ route('cart.store') }}" method="post">
                        @csrf

                        @if ($rowId = $product->getCartRowId('wishlist'))
                            <input type="hidden" name="row_id" value="{{ $rowId }}">
                        @endif
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="name" value="{{ $product->name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <button class="button button-plain add-to-cart-btn" type="submit">Add to Cart <i class="fa fa-cart-plus"></i></button>
                    </form>
                @endif
            @endif
        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')

@endsection

@section('extra-js')
    <script>
        
        (function() {
            let image = document.querySelector('#main_image');
            let thumbnails = document.querySelectorAll('.thumbnail');

            thumbnails.forEach((el) => {
                el.addEventListener('click', thumbnailClick);
            });

            function thumbnailClick(e) {
                document.querySelector('.product-section-thumbnail.selected').classList.remove('selected');
                this.parentElement.classList.add('selected');
                image.classList.remove('active');

                image.addEventListener('transitionend', () => {
                    image.src = this.src;
                    image.classList.add('active');
                });
            }
        }());

    </script>

    @include('partials.js.search-section')
@endsection

