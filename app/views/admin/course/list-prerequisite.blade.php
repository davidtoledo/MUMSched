@extends( ( (Auth::user()->is_admin ) ? 'admin/base' : 'platform/base') )

@section('page_title') MUM Schedule @endsection

@section('css_header')
	<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/jqueryui-blue/jquery-ui.min.css') }}" />	
@endsection

@section('breadcrumb')
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="{{ Config::get('app.plataforma.url') }}">MUMSched</a>
		</li>
		@if (Auth::user()->is_admin)
			<li>
				<i class="ace-icon fa fa-lock"></i>
				<a href="{{ URL::route('admin.user.list') }}">
					Courses
				</a>
			</li>
			<li>
				Prerequisite
			</li>
			<li>
				{{ isset ($course) ? 'Edit' : 'Create' }}
			</li>
		@else
			<li>
				{{ $user->type == \SystemUser::TYPE_FACULTY ? "Faculty" : "Student "}} Profile
			</li>
		@endif
	</ul>
@endsection



@section('scripts_footer')

	<script>
		admin.confirmarExclusao();
	    $('[data-rel=popover]').popover({html:true});
		var base_path = '{{ URL::to("/") }}';
	</script>
@stop