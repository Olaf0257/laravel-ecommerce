<div class="product-card">
    <div class="product-badges">
        @if ($product->isNew())
            <span class="badge product-badge-new">New</span>
        @endif    
    </div>

    <div class="product-image">
        <a href="{{ route('shop.show', $product->id) }}"><img src="{{ $product->imgPath() }}" alt="product"></a>
    </div>

    <div class="product-details">
        <div class="product-details-top">
            <div class="product-name">
                <a href="{{ route('shop.show', $product->id) }}">{{ strlen($product->name) > 40 ? substr($product->name, 0, 40) . '...' : $product->name }}</a>
            </div>

            <div class="product-price">{{ $product->presentPrice() }}</div>
        </div>

        <div class="product-actions">
            @if ($product->isInCart())
                <div class="badge badge-success">Already in Cart</div>
            @else 
                {{-- Add to Cart Form --}}
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

            @if ($product->isInWishlist())
                {{-- Remove from wishlist from --}}
                <form class="heart-item-form" action="{{ route('wishlist.destroy', $product->getCartRowId('wishlist')) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="button-icon" title="Remove from Wishlist">
                        <i class="fas fa-heart solid-heart"></i>
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
                        <i class="far fa-heart"></i>
                    </button>
                </form>
            @endif
        </div>
    </div> <!-- end product details -->
</div> <!-- end product card -->