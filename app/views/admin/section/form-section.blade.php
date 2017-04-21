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
			<a href="{{ URL::route('admin.section.list') }}">
				Sections
			</a>
		</li>
		<li>
			{{ isset ($section) ? 'Edit' : 'Create' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: form-section -->
	<h4 class="pink">
		<i class="ace-icon fa fa-newspaper-o green"></i>
		<a href="{{ URL::route('admin.section.list') }}" class="blue">Section List</a>
		&nbsp; &nbsp;
	</h4>
	<div class="page-header">
		<h1>
			Section
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				{{ isset ($section) ? 'Edit' : 'Create' }}
			</small>
		</h1>
	</div>

	<div class="col-xs-12 col-sm-12">
		<div class="tabbable ">
			@include('admin/section/tab-section')
			<div class="tab-content">
				{{ Form::open([
					'route' => isset($section) ?
							['admin.section.edit', $section->id_section]
					 	:
					 		['admin.section.create'],
					'class' => 'form-horizontal'
				]) }}
					
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Select the Block</label>
						<div class="col-sm-10">
							@if ( isset ($section) )
							
								{{ Form::hidden('id_block', $section->id_block) }}
								
								{{ Form::text('block',
									isset ($section) ? $section->block->name : Input::old('block'),
									[
										'class' => 'col-xs-7 limited',
										'readonly' => 'readonly'
									]
								) }}
								
							@else
							
								{{ Form::select('id_block',
									$block_list,
									isset ($section) ? $section->id_block : Input::old('id_block'),
										[
											'id'       => 'block_list', 
											'style'    => 'width:58%;',
										]
									)
								}}
								
								

								
								
							@endif
							<span 
								data-content="Please select a Block." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>																						
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Capacity of this Section</label>
						<div class="col-sm-3">
							{{ Form::text('capacity',
								isset ($section) ? $section->capacity : Input::old('capacity'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the capacity of this section." 
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