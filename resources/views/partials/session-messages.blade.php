@if (session()->has('success-message'))
    <div class="success-session-msg">
    	<i class="far fa-check-circle"></i>
    	<p>{{ session()->get('success-message') }}</p>
    </div>
@endif

@if (session()->has('error-message'))
    <div class="error-session-msg">{{ session()->get('error-message') }}</div>
@endif