@if ($message = Session::get('success'))
<div class="success-message hidden">
	{{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div class="error-message hidden">
	{{ $message }}
</div>
@endif