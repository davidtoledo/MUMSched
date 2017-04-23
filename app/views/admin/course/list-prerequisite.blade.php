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
				Specialization
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
		<div class="tabbable">
			
			@include('admin/user/tab-user')
			
			<div class="tab-content">
				{{ Form::open([
					'class' => 'form-horizontal'
				]) }}

					{{ Form::hidden('id_user', $user->id_user) }}

					@if ( isset ($user->specializations) )
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>{{ $user->first_name }} {{ $user->last_name }}'s Specialization</th>
									<th width="11%">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($user->specializations as $us)
								<tr>
									<td>
										{{ $us->specialization->specialization }}
									</td>
									<td>
							            <!-- Multi-action button -->
							            <div class="btn-group">
							               <a class="btn btn-glow delete_confirmation"  href="{{ URL::route('admin.user.specialization.delete', [$us->id_fs]) }}">
								               <i class="fa fa-ban red"></i>
								               <span>Remove</span>
							               </a>
							            </div>
									</td>
								</tr>	
								@endforeach
							</tbody>
						</table>
						<a href="{{ URL::route('admin.user.specialization.create', [$user->id_user]) }}" class="btn btn-blue btn-info" >
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