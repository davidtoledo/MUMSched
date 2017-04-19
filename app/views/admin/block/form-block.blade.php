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
			<a href="{{ URL::route('admin.block.list') }}">
				Blocks
			</a>
		</li>
		<li>
			{{ isset ($block) ? 'Edit' : 'Create' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: form-block -->
	<h4 class="pink">
		<i class="ace-icon fa fa-newspaper-o green"></i>
		<a href="{{ URL::route('admin.block.list') }}" class="blue">Block List</a>
		&nbsp; &nbsp;
	</h4>
	<div class="page-header">
		<h1>
			Block
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				{{ isset ($block) ? 'Edit' : 'Create' }}
			</small>
		</h1>
	</div>

	<div class="col-xs-12 col-sm-12">
		<div class="tabbable ">
			@include('admin/block/tab-block')
			<div class="tab-content">
				{{ Form::open([
					'route' => isset($block) ?
							['admin.block.edit', $block->id_block]
					 	:
					 		['admin.block.create'],
					'class' => 'form-horizontal'
				]) }}
					
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Name</label>
						<div class="col-sm-8">
							{{ Form::text('name',
								isset ($block) ? $block->name : Input::old('name'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the name of the block." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

				
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Select the Entry</label>
						<div class="col-sm-10">
							{{ Form::select('id_entry',
								$entry_list,
								isset ($block) ? $block->id_entry : Input::old('id_entry'),
									[
										'id'       => 'entry_list', 
										'style'    => 'width:58%;',
									]
								)
							}}
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
					
					

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Start Date</label>
						<div class="col-sm-3">
							{{ Form::text('dt_start_date',
								isset ($entry) ? date("m/d/Y", strtotime($entry->start_date)) : Input::old('dt_start_date'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the Start date of the block." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">End Date</label>
						<div class="col-sm-3">
							{{ Form::text('dt_end_date',
								isset ($entry) ? date("m/d/Y", strtotime($entry->end_date)) : Input::old('dt_end_date'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the End date of the Block." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Number of MPP courses</label>
						<div class="col-sm-3">
							{{ Form::text('num_mpp_courses',
								isset ($block) ? $block->num_mpp_courses : Input::old('num_mpp_courses'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the number of MPP courses " 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Number of FPP courses</label>
						<div class="col-sm-3">
							{{ Form::text('num_fpp_courses',
								isset ($block) ? $block->num_fpp_courses : Input::old('num_fpp_courses'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the number of FPP courses" 
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