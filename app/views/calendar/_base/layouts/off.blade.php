@include('plataforma/_base/layouts/header')
	@if (isset($dataPage))
		<body data-page="{{ $dataPage }}">
	@else
		<body>
	@endif
		<header>
		@include('plataforma/_base/layouts/barraTopoOff')
		</header>

		@yield('content')

		@include('plataforma/_base/layouts/footer')

		@yield('script')
	</body>
</html>