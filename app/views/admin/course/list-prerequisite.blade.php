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
			Specialization
		</li>
		<li>
			{{ isset ($course) ? 'Edit' : 'Create' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: list-prerequisite -->
	<h4 class="pink">
		<i class="ace-icon fa fa-newspaper-o green"></i>
		<a href="{{ URL::route('admin.user.list') }}" class="blue">User List</a>
		&nbsp; &nbsp;
	</h4>
	<div class="page-header">
		<h1>
			User
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
				{{ Form::open([
					'class' => 'form-horizontal'
				]) }}

					{{ Form::hidden('id_course', $course->id_course) }}

					@if ( isset ($course) )
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>{{ $course->name }}'s Prerequisites</th>
									<th width="11%">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($course->prerequisites as $pre)
								<tr>
									<td>
										{{ $pre->prerequisite->name }}
									</td>
									<td>
							            <!-- Multi-action button -->
							            <div class="btn-group">
							               <a class="btn btn-glow delete_confirmation"  href="{{ URL::route('admin.course.prerequisite.delete', [$course->id_course, $pre->id]) }}">
								               <i class="fa fa-ban red"></i>
								               <span>Remove</span>
							               </a>
							            </div>
									</td>
								</tr>	
								@endforeach
							</tbody>
						</table>
						<a href="{{ URL::route('admin.course.prerequisite.create', [$course->id_course]) }}" class="btn btn-blue btn-info" >
							<span class="ace-icon fa fa-plus icon-on-right bigger-110"></span>
							Add
						</a>
					@endif

				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop

@section('scripts_footer')

	<script>
		admin.confirmarExclusao();
	    $('[data-rel=popover]').popover({html:true});
		var base_path = '{{ URL::to("/") }}';
	</script>
@stop