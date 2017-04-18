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
			<a href="{{ URL::route('admin.entry.list') }}">
				Entries
			</a>
		</li>
		<li>
			{{ isset ($entry) ? 'Edit' : 'Create' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: form-entry -->
	<h4 class="pink">
		<i class="ace-icon fa fa-newspaper-o green"></i>
		<a href="{{ URL::route('admin.entry.list') }}" class="blue">Entry List</a>
		&nbsp; &nbsp;
	</h4>
	<div class="page-header">
		<h1>
			Entry
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				{{ isset ($entry) ? 'Edit' : 'Create' }}
			</small>
		</h1>
	</div>

	<div class="col-xs-12 col-sm-12">
		<div class="tabbable ">
			@include('admin/entry/tab-entry')
			<div class="tab-content">
				{{ Form::open([
					'route' => isset($entry) ?
							['admin.entry.edit', $entry->id_entry]
					 	:
					 		['admin.entry.create'],
					'class' => 'form-horizontal'
				]) }}
					
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Name</label>
						<div class="col-sm-8">
							{{ Form::text('name',
								isset ($entry) ? $entry->name : Input::old('name'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the name of the entry." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">FPP Total</label>
						<div class="col-sm-3">
							{{ Form::text('fpp_total',
								isset ($entry) ? $entry->fpp_total : Input::old('fpp_total'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the FPP total of the entry." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">MPP Total</label>
						<div class="col-sm-3">
							{{ Form::text('mpp_total',
								isset ($entry) ? $entry->mpp_total : Input::old('mpp_total'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the MPP total of the entry." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">OPT Percent</label>
						<div class="col-sm-3">
							{{ Form::text('opt_percent',
								isset ($entry) ? $entry->opt_percent : Input::old('opt_percent'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the OPT percentage of the entry." 
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
								data-content="Please inform the Start date of the entry." 
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
								data-content="Please inform the End date of the entry." 
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