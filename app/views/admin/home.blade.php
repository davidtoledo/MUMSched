@extends( ( (Auth::user()->is_admin ) ? 'admin/base' : 'platform/base') )

@section('page_title') MUM Schedule @endsection

@section('css_header')
	<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/jqueryui-blue/jquery-ui.min.css') }}" />	
@endsection

@section('breadcrumb')
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#2">MUMSched</a>
		</li>
		<li>
			Home
		</li>
	</ul>
@endsection

@section('content')
	<!-- Screen ID: home -->	    
	<div class="page-header">
		<center>
			<img src="{{ URL::to('_plataforma/media/img/lgo/MUMSchedLogo.png') }}">
	   </center>
	</div>
	
	<br><br><br>
	<div>
		<center>
			<font size=4>
			<b>Welcome to MUMSched v1.0.0</b><br>
			By Team Fantastic Five<br>
			<br>Software Engineering<br>
			Professor Steve Nolle
			</font>
		</center>
	</div>
@stop

@section('scripts_footer')
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery-ui.js') }}"></script>
@stop