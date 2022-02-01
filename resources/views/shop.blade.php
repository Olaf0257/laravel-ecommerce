@extends('layout')

@section('title', 'Shop')

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/docs-searchbar.js/dist/cdn/docs-searchbar.min.css" />
    <link rel="stylesheet" href="css/plugins/jquery.range.css">
@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <div>
                <a href="{{ route('home') }}">Home</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                @if (request()->has('category'))
                    <a href="{{ route('shop.index') }}">Shop</a>
                    <i class="fa fa-chevron-right breadcrumb-separator"></i>
                    <span class="visited">{{ ucfirst(request()->category) }}</span>
                @else
                    <span class="visited">Shop</span>
                @endif
            </div>

            @include('partials.search-form')
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="products-section container">
        <div class="sidebar">
            <div class="inner-sidebar">
                <h3>Filter By Category</h3>
                <ul class="categories-list">
                    @foreach ($categories as $category)
                        @if (request()->category == $category->slug)
                            <li class="active">{{ $category->name }}</li>
                        @else
                            <li>
                                <a href="{{ route('shop.index', ['category' => $category->slug, 'sort' => request()->sort]) }}">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul> <!-- end categories list -->

                <h3>Sort by Price</h3>
                <ul class="sort-by-price-list">
                    <li class="{{ request()->sort == 'high_low' ? 'active' : ''}}">
                        @if (request()->sort == 'high_low')
                            <span>High to Low</span>
                        @else
                            <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'high_low']) }}">High to Low</a>
                        @endif
                    </li>
                    <li class="{{ request()->sort == 'low_high' ? 'active' : ''}}">
                        @if (request()->sort == 'low_high')
                            <span>Low to High</span>
                        @else
                            <a href="{{ route('shop.index', ['category' => request()->category, 'sort' => 'low_high']) }}">Low to High</a>
                        @endif
                    </li>
                </ul> <!-- end sort by price list -->

                <h3>Filter by Price</h3>
                <ul class="filter-by-price">
                    <input class="range-slider" type="hidden" value="25,75"/>
                </ul> <!-- end filter by price -->
            </div>
        </div> <!-- end sidebar -->

        <div class="products-section-all">
            <h1 class="stylish-heading">{{ $categoryName }}</h1>

            <div class="products text-center">
                @forelse ($products as $product)
                    <div>
                        @include('partials/product-card')
                    </div>
                @empty
                    <div class="empty">No items found</div>
                @endforelse
            </div> <!-- end products -->

            {{ $products->appends(request()->input())->links() }}
        </div>
    </div>

@endsection

@section('extra-js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    {{-- Price Range --}}
    <script src="/js/plugins/jquery.range.js"></script>
    <script>
        $(document).ready(function(){
            $('.range-slider').jRange({
                from: 0,
                to: 20000,
                step: 100,
                scale: [0,10000,20000],
                format: '%s',
                width: 200,
                showLabels: true,
                isRange: true,
                theme: 'theme-blue',
                ondragend: (e) => {
                    priceRangeChanged(e);
                },
                onbarclicked: (e) => {
                    priceRangeChanged(e);
                }
            });

            let rangeValue = '{{ request()->minPrice }}' + ',' + '{{ request()->maxPrice }}';
            let re = new RegExp('[0-9]+,[0-9]+');

            $('.range-slider').jRange('setValue', rangeValue.search(re) !== -1 ? rangeValue : '0,30000');

            function priceRangeChanged(e) {
                let [min, max] = [...e.split(',')];
                let uri = window.location.search;

                uri = updateQueryStringParameter(uri, 'minPrice', min);
                uri = updateQueryStringParameter(uri, 'maxPrice', max);
                window.location = uri;
            }
        });

        function updateQueryStringParameter(uri, key, value) {
            if (uri) {
                if (uri.search(key) !== -1) {
                    // Key exists -> update uri
                    let re = new RegExp('(?<=' +key+ '\=).*?(?=(&|$))', 'i');
                    let oldKeyValuePairs = uri.substring(1).split('&');
                    let newURI = oldKeyValuePairs.reduce((uri, pair, index, arr) => {
                        if (pair.search(key) !== -1) {
                            uri += pair.replace(re, value);
                        } else {
                            uri += pair;
                        }
                        
                        return index < arr.length - 1 ? uri + '&' : uri;
                    }, '?');

                    return newURI;
                } else {
                    // Add key to uri
                    return uri + '&' + key + '=' + value;
                }
            } else {
                return '?' + key + '=' + value;
            }
        }
    </script>


    @include('partials.js.search-section')
@endsection

