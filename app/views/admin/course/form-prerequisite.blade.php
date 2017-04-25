@extends('admin/base')

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
		<li>
			<i class="ace-icon fa fa-lock"></i>
			<a href="{{ URL::route('admin.user.list') }}">
				Users
			</a>
		</li>
		<li>
			{{ isset ($course) ? 'Edit' : 'Create' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: form-prerequisite -->
	<h4 class="pink">
		<i class="ace-icon fa fa-newspaper-o green"></i>
		<a href="{{ URL::route('admin.course.list') }}" class="blue">Course List</a>
		&nbsp; &nbsp;
	</h4>
	<div class="page-header">
		<h1>
			Course
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				{{ isset ($course) ? 'Edit' : 'Create' }}
			</small>
		</h1>
	</div>

	<div class="col-xs-12 col-sm-12">
		<div class="tabbable">
			@include('admin/course/tab-course')
			<div class="tab-content">

				<a href="{{ URL::route('admin.course.prerequisite.list', $course->id_course) }}">
					Back to prerequisite list
				</a>
				<br><br>

				{{ Form::open([
					'files' => TRUE,
					'class' => 'form-horizontal'
				]) }}

					{{ Form::hidden('id_course', $course->id_course) }}

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Prerequisite</label>
						<div class="col-sm-10">
							{{ Form::select('id_prerequisite',
								$prerequisite_list,
								null,
								array('id' => 'specialization_list', 'style' => 'width:60%;'))
							}}
							<span 
								data-content="Select a Prerequisite to this course." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<button type="submit" class='btn btn-blue btn-info'>
						<span class="ace-icon fa fa-save icon-on-right bigger-110"></span>
						Save
					</button>
				{{ Form::close() }}
			</div>
		</div>
	</div>

@stop

@section('ace_scripts')
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery-ui.js') }}"></script>
@endsection

@section('scripts_footer')
	<script>
	    $('[data-rel=popover]').popover({html:true});
		var base_path = '{{ URL::to("/") }}';
	</script>
@stop