<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>@yield('page_title')</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/bootstrap.css') }}" />
		<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/font-awesome.css') }}" />
		<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/bootstrap-multiselect.css') }}" />

		<link rel="shortcut icon" href="{{ URL::to('_plataforma/media/img/ico/favicon.ico') }}" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/ace-fonts.css') }}" />

		<!-- ace styles -->
		<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/ace.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

		@yield('css_header')
		<link rel="stylesheet" href="{{ URL::to('_temas/admin/media/css/base.css') }}" />
		<link rel="stylesheet" href="{{ URL::to('_temas/admin/media/css/sub_base.css') }}" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/ace-part2.css') }}" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/ace-ie.css') }}" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="{{ URL::to('_temas/_base/media/js/ace-extra.js') }}"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="{{ URL::to('_temas/_base/media/js/html5shiv.js') }}"></script>
		<script src="{{ URL::to('_temas/_base/media/js/respond.js') }}"></script>
		<![endif]-->
	</head>

	<body class="no-skin">
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<!-- #section:basics/sidebar.mobile.toggle -->
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="{{ route('admin.user.list') }}" class="navbar-brand">
						<small>
							<i class="fa fa-calendar"></i>
							&nbsp;MUM Schedule
						</small>
					</a>

					<!-- /section:basics/navbar.layout.brand -->
					<!-- #section:basics/navbar.toggle -->
					<!-- /section:basics/navbar.toggle -->
				</div>

				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="min-width: 200px;">
								<span class="user-info">
									<small>Welcome,</small>
									{{ Auth::user()->first_name }}
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								
								<!--
								<li>
									<a href="#2">
										<i class="ace-icon fa fa-cog"></i>
										Configurações
									</a>
								</li>

								<li class="divider"></li>
								-->

								<li>
									<a href="{{ URL::to('/logout') }}">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>

						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>
		
		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive">
				<ul class="nav nav-list">
					
					@if (Auth::user()->is_admin)
					
						<li class="{{ Request::is('admin/home/*') ? 'active open' : '' }}">
							<a href="{{ URL::to('/admin/home/home') }}">
								<i class="menu-icon fa fa-home"></i>
								<span class="menu-text">
									Home
								</span>
							</a>
						</li>					
												
						<li class="{{ Request::is('admin/user/*') ? 'active open' : '' }}">
							<a href="{{ URL::to('/admin/user/list') }}">
								<i class="menu-icon fa fa-user"></i>
								<span class="menu-text">
									System User
								</span>
							</a>
						</li>
						
						<li class="{{ Request::is('admin/schedule/*') ? 'active open' : '' }}">
							<a href="{{ URL::to('/admin/schedule/list') }}">
								<i class="menu-icon fa fa-calendar"></i>
								<span class="menu-text">
									Schedule
								</span>
							</a>
						</li>
						
												
					@endif

					<li class="{{ Request::is('admin/logout/*') ? 'active open' : '' }}">
						<a href="{{ URL::to('/logout') }}">
							<i class="menu-icon fa fa-power-off"></i>
							<span class="menu-text">
								Logout
							</span>
						</a>
					</li>
					
				</ul><!-- /.nav-list -->
			</div>

			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<div class="main-content-inner">
					<!-- #section:basics/content.breadcrumbs -->
					<div class="breadcrumbs" id="breadcrumbs">
						@yield('breadcrumb')
					</div>

					<!-- /section:basics/content.breadcrumbs -->
					<div class="page-content">
						<!-- /section:settings.box -->
						<div class="row">
							<div class="col-xs-12">
								@if(Session::has('success'))
									<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-check green"></i>

										{{ Session::get('success') }}
									</div>
								@endif

								@if(Session::has('error'))
									<div class="alert alert-block alert-danger">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-exclamation-triangle red"></i>

										{{ Session::get('error') }}
									</div>
								@endif

								@if(Session::has('warning'))
									<div class="alert alert-block alert-warning">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-exclamation-triangle red"></i>

										{{ Session::get('warning') }}
									</div>
								@endif

								@if (count($errors) > 0)
									<div class="alert alert-block alert-danger">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-exclamation-triangle red"></i>

										@foreach ($errors->all() as $message)
											{{ $message }} <br />
										@endforeach
									</div>
								@endif

								<!-- PAGE CONTENT BEGINS -->
									@yield('content')
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

		<!-- basic scripts -->

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

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="{{ URL::to('_temas/_base/media/js/ace/ace.js') }}"></script>
		<script src="{{ URL::to('_temas/_base/media/js/ace/ace.sidebar.js') }}"></script>
		<script src="{{ URL::to('_temas/admin/media/js/plugins/bootstrap-multiselect.js') }}"></script>
		@yield('ace_scripts')
		@yield('scripts_footer')
	</body>
</html>