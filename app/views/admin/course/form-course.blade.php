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
			<a href="{{ URL::route('admin.course.list') }}">
				Courses
			</a>
		</li>
		<li>
			{{ isset ($course) ? 'Edit' : 'Create' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: form-course -->
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
		<div class="tabbable ">
			@include('admin/course/tab-course')
			<div class="tab-content">
				{{ Form::open([
					'route' => isset($course) ?
							['admin.course.edit', $course->id_course]
					 	:
					 		['admin.course.create'],
					'class' => 'form-horizontal'
				]) }}
					
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue"> Course Specialization</label>
						<div class="col-sm-8">
							{{ Form::text('id_specialization',
								isset ($course) ? $course->id_specialization : Input::old('id_specialization'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the specialization of the course." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Course Code</label>
						<div class="col-sm-3">
							{{ Form::text('code',
								isset ($course) ? $course->code : Input::old('code'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the code of the course." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Course Name</label>
						<div class="col-sm-3">
							{{ Form::text('name',
								isset ($course) ? $course->name : Input::old('name'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the name of the course." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

				
					<button type="submit" class='btn btn-blue btn-info'>
						<span class="ace-icon fa fa-calendar icon-on-right bigger-110"></span>
						Save
					</button>
				{{ Form::close() }}
				
			</div>
		</div>
	</div>	
@stop

@section('ace_scripts')
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery-ui.js') }}"></script>
	<script src="{{ URL::to('_temas/_base/media/js/select2.js') }}"></script>
	<script src="{{ URL::to('_temas/admin/media/js/dtsc/mumsched.js') }}"></script>
@endsection

@section('scripts_footer')
	<script>
		$('[data-rel=popover]').popover({html:true});
		var base_path = '{{ URL::to("/") }}';
		
		function changePass() {
			$("#change_password").val("true");
			$("#password").val("");
			$("#password").focus();
			$("#password").attr("readonly", false);
		}		
	</script>
@stop