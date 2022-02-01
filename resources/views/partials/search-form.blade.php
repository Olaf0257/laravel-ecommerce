<form class="search-form" id="search-form" action="{{ route('search') }}">
    <input type="search" name="query" id="search-bar-input" class="@error('query') is-invalid @enderror"  value="{{ request()->input('query') }}" placeholder="what are you looking for?" required="" minlength="3">

    <button type="submit"><i class="fa fa-search"></i></button>

    @error('query')
        <p class="invalid-feedback text-center" role="alert">{{ $message }}</p>
    @enderror
</form>