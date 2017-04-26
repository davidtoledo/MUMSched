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
					Users
				</a>
			</li>
			<li>
				{{ isset ($user) ? 'Edit' : 'Create' }}
			</li>
		@else
			<li>
				{{ $user->type == \SystemUser::TYPE_FACULTY ? "Faculty" : "Student "}} Profile
			</li>
		@endif
	</ul>
@endsection

@section('content')
    <!-- Screen ID: form-user -->
    @if (Auth::user()->is_admin)
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
					{{ isset ($user) ? 'Edit' : 'Create' }}
				</small>
			</h1>
		</div>
	@else
		<!-- Header-->
		@include('admin/user/user-header')
	
	@endif

	<div class="col-xs-12 col-sm-12">
		<div class="tabbable ">
			@include('admin/user/tab-user')
			<div class="tab-content">
				{{ Form::open([
					'route' => isset($user) ?
							['admin.user.edit', $user->id_user]
					 	:
					 		['admin.user.create'],
					'class' => 'form-horizontal'
				]) }}
				
					{{ Form::hidden('change_password', 'false', array('id' => 'change_password')) }}

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">First Name</label>
						<div class="col-sm-8">
							{{ Form::text('first_name',
								isset ($user) ? $user->first_name : Input::old('first_name'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the first name of the user." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Last Name</label>
						<div class="col-sm-8">
							{{ Form::text('last_name',
								isset ($user) ? $user->last_name : Input::old('last_name'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the last name of the user." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Username</label>
						<div class="col-sm-8">
							{{ Form::text('username',
								isset ($user) ? $user->username : Input::old('username'),
								[
									'class' => 'col-xs-9 limited'
								]
							) }}
							<span 
								data-content="Please inform the username." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>							
						</div>
					</div>					

					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right blue">Password</label>
						<div class="col-sm-3">
							{{ Form::input('password', 'password',
								isset ($user) ? $user->password : '',
								[
									'id' => 'password',
									'class' => 'col-xs-9 limited',
									 isset ($user) ? 'readonly' : ''
								]
							) }}
							<br><br><a href="#2" onclick="changePass();">Change password</a>
						</div>
					</div>
					
					@if ( Auth::user()->type == \SystemUser::TYPE_STUDENT && !Auth::user()->is_admin )
						{{ Form::hidden('student_entry', Auth::user()->student_entry ) }}
						{{ Form::hidden('student_track', Auth::user()->student_track ) }}
					@endif
					
					@if (Auth::user()->is_admin)
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right blue">Type</label>
							<div class="col-sm-10">
								{{ Form::select('type', 
									$user_type_list, 
									isset ($user) ? $user->type : Input::old('type'))
								}}
								<span 
									data-content="Please inform the user type." 
									data-placement="right"
									data-rel="popover" 
									data-trigger="hover"
									class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
									<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
								</span>							
							</div>
						</div>
	
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right blue">Is Admin</label>
							<div class="col-sm-10">
								{{ Form::select('is_admin', 
									[0 => "No", 1 => "Yes"], 
									isset ($user) ? $user->is_admin : Input::old('is_admin'))
								}}
								<span 
									data-content="Please inform if this user is a system administrator." 
									data-placement="right"
									data-rel="popover" 
									data-trigger="hover"
									class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
									<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
								</span>							
							</div>
						</div>
						<div id="studentData">
														
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right blue">Student Track</label>
							<div class="col-sm-10">
								{{ Form::select('student_track', 
									["FFP" => "FPP", "MPP" => "MPP","US"=>"US"], 
									isset ($user) ? $user->student_track : Input::old('student_track'))
								}}
								<span 
									data-content="Please inform the track of student" 
									data-placement="right"
									data-rel="popover" 
									data-trigger="hover"
									class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
									<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
								</span>							
							</div>
						</div>
												
						<div class="form-group">
							<label class="col-sm-2 control-label no-padding-right blue">Student Entry</label>
							<div class="col-sm-10">
								{{ Form::select('student_entry', 
									$entry_list, 
									isset ($user) ? $user->student_entry : Input::old('student_entry'))
								}}
								<span 
									data-content="Please inform the track of student" 
									data-placement="right"
									data-rel="popover" 
									data-trigger="hover"
									class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
									<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
								</span>							
							</div>
						</div>

						</div>
						
					@else
						{{ Form::hidden('type', $user->type, array('id' => 'type')) }}
						{{ Form::hidden('is_admin', '0', array('id' => 'is_admin')) }}
					@endif

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
		
		if($("select[name='type']").val() == "S")
		  $("#studentData").show();
		else
		  $("#studentData").hide();
		  
		$("select[name='type']").change(function(){
			if($(this).val() == "S")
		  		$("#studentData").show();
			else
		  		$("#studentData").hide();
		  
		});
	</script>
@stop