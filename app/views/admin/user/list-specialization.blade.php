@extends('admin/base')

@section('page_title') MUM Schedule @endsection

@section('css_header')
	<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/select2.css') }}" />
@endsection

@section('breadcrumb')
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#2">MUMSched</a>
		</li>
		<li>
			<i class="ace-icon fa fa-lock"></i>
			<a href="{{ URL::route('admin.user.list') }}">
				Users
			</a>
		</li>
		<li>
			<i class="ace-icon fa fa-lock"></i>
			<a href="{{ URL::route('admin.user.specialization.list', $user->id_user) }}">Specialization</a>
		</li>				
		<li>
			{{ isset ($user) ? 'Edit' : 'Add' }}
		</li>
	</ul>
@endsection

@section('content')
    <!-- Screen ID: lista-specialization -->
	<h4 class="pink">
	@if ( isset ($user) ) 
		<i class="ace-icon fa fa-newspaper-o green"></i>
		<a href="{{ URL::route('admin.user.list') }}" class="blue">User List</a>
		&nbsp; &nbsp;
	@endif
	</h4>
	<div class="page-header">
		<h1>
			{{ $title }}
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				{{ isset ($user) ? 'Edit' : 'Add' }}
			</small>
		</h1>
	</div>

	<div class="col-xs-12 col-sm-12">
		<div class="tabbable">
			
			@include('admin/user/tab-user')
			
			<div class="tab-content">
				{{ Form::open([
					'class' => 'form-horizontal'
				]) }}

					{{ Form::hidden('id_user', $user->id_user) }}

					@if ( isset ($user->specializations) )
						<h3>Specialization(s) for {{ $user->first_name }} {{ $user->last_name }}</h3>
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Specialization</th>
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