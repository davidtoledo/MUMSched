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
			<a href="{{ URL::route('admin.schedule.list') }}">
				Schedules
			</a>
		</li>
		<li>
			{{ isset ($schedule) ? 'Edit' : 'Create' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: form-schedule -->
	<h4 class="pink">
		<i class="ace-icon fa fa-newspaper-o green"></i>
		<a href="{{ URL::route('admin.schedule.list') }}" class="blue">Schedule List</a>
		&nbsp; &nbsp;
	</h4>
	<div class="page-header">
		<h1>
			Schedule
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				{{ isset ($schedule) ? 'Edit' : 'Create' }}
			</small>
		</h1>
	</div>

	<div class="col-xs-12 col-sm-12">
		<div class="tabbable ">
			@include('admin/schedule/tab-schedule')
			<div class="tab-content">
				{{ Form::open([
					'route' => isset($schedule) ?
							['admin.schedule.edit', $schedule->id_schedule]
					 	:
					 		['admin.schedule.create'],
					'class' => 'form-horizontal'
				]) }}


					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Select the Entry</label>
						<div class="col-sm-10">
							
							@if ( isset ($schedule) )
							
								{{ Form::hidden('id_entry', $schedule->id_entry) }}
								
								{{ Form::text('entry',
									isset ($schedule) ? $schedule->entry->name : Input::old('entry'),
									[
										'class' => 'col-xs-7 limited',
										'readonly' => 'readonly'
									]
								) }}
								
							@else
							
								{{ Form::select('id_entry',
									$entry_list,
									isset ($schedule) ? $schedule->id_entry : Input::old('id_entry'),
										[
											'id'       => 'entry_list', 
											'style'    => 'width:58%;',
										]
									)
								}}
								
							@endif
							<span 
								data-content="Please select an Entry." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>																						
						</div>
					</div>

					@if ( isset($schedule) )
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right blue">Status</label>
							<div class="col-sm-10">
								{{ Form::select('status',
									$status_list,
									isset ($schedule) ? $schedule->status : Input::old('status'),
									array('id' => 'status_list', 'style' => 'width:60%;'))
								}}
								<span 
									data-content="Please select a status." 
									data-placement="right"
									data-rel="popover" 
									data-trigger="hover"
									class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
									<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
								</span>							
							</div>
						</div>
					@endif

					<button type="submit" class='btn btn-blue btn-info'>
						<span class="ace-icon fa fa-calendar icon-on-right bigger-110"></span>
						@if (!$schedule)
							Create Schedule
						@else
							Update Schedule
						@endif
					</button>
				{{ Form::close() }}
				
			</div>
		</div>
	</div>	
@stop

@section('ace_scripts')
	<script src="{{ URL::to('media/editor/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery-ui.js') }}"></script>
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery.ui.datepicker-pt-BR.js') }}"></script>
	<script src="{{ URL::to('_temas/_base/media/js/select2.js') }}"></script>
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