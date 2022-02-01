@if (count($errors->all()))
	@foreach ($errors->all() as $error)
		<div class="validation-error-msg">{!! $error !!}</div>
	@endforeach
@endif

@if (session()->has('error-msg'))
	<div class="validation-error-msg">{{ session()->get('error-msg') }}</div>
@endif
