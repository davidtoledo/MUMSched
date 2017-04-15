@if(Session::has('success'))
	<div class="form-sucesso">
		<p>{{ Session::get('success') }}</p>
	</div>
@endif

@if(Session::has('error'))
	<div class="form-errors">
		<p>{{ Session::get('error') }}</p>
	</div>
@endif

@if (count($errors) > 0)
	<div class="form-errors">
		@foreach ($errors->all() as $message)
			<p>{{ $message }}</p>
		@endforeach
	</div>
@endif