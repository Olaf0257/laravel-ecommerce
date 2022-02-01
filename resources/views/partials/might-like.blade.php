<div class="might-like-section">
    <div class="cards-container">
        <h2>You might also like...</h2>
        <div class="cards">
            @foreach ($mightAlsoLike as $product)
                @include('partials/product-card')
            @endforeach
        </div>
    </div>
</div>
