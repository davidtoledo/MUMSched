@include('calendar/_base/layouts/header')
		<body>
			<div id="global">
				<header>
					@include('calendar/_base/layouts/barraTopo')
				</header>
				@yield('content')

				@include('calendar/_base/layouts/footer')
			</div>
			
			<!--[if !IE]> -->
			<script type="text/javascript">
				window.jQuery || document.write("<script src='{{ URL::to('_temas/_base/media/js/jquery.js') }}'>"+"<"+"/script>");
			</script>
			<!-- <![endif]-->
	
			<!--[if IE]>
			<script type="text/javascript">
			 window.jQuery || document.write("<script src='{{ URL::to('_temas/_base/media/js/jquery1x.js') }}'>"+"<"+"/script>");
			</script>
			<![endif]-->
			<script type="text/javascript">
				if('ontouchstart' in document.documentElement) document.write("<script src='{{ URL::to('_temas/_base/media/js/jquery.mobile.custom.js') }}'>"+"<"+"/script>");
			</script>
			<script src="{{ URL::to('_temas/_base/media/js/bootstrap.js') }}"></script>			

		@yield('script')
	</body>
</html>