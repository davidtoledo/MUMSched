@extends('admin/base')

@section('page_title') MUM Schedule @endsection

@section('css_header')
	<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/jqueryui-blue/jquery-ui.min.css') }}" />	
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
			List
		</li>
	</ul>
@endsection

@section('content')
	<!-- Screen ID: list-user -->	    
	<h4 class="pink">
   		<i class="ace-icon fa fa-plus-square green"></i>
   		<a href="{{ URL::route('admin.user.create') }}" class="blue">Create new user</a>
   	</h4>

	<div class="page-header">
	   <h1>
	      User
	      <small>
		      <i class="ace-icon fa fa-angle-double-right"></i>
		      List
	      </small>
	   </h1>
	</div>
	
	{{ Form::open
		([
			'id' => 'frm',
			'autocomplete' => 'off',
			'action' => ['admin.user.list'],
			'files'  => 'true'
		]) 
	}}
	
	<!-- Navigation Controls -->
	{{ Form::hidden('page', isset( $_GET['page'] ) ? $_GET['page'] : "", ['id' => 'page'] ) }}
	{{ Form::hidden('id_user', '', ['id' => 'id_user']) }}
		
	<table class="table table-striped table-bordered table-hover">
	   <thead>
	      <tr>
			<th width="10">
				<center>
					<input type="checkbox" onchange="checkAll(this);"></input>
				</center>
			</th>							
	      	
	         <th style="width:150px;">
	         	First Name
	         </th>

	         <th style="width:150px;">
	         	Last Name
	         </th>
	         
	         <th style="width:120px;">
	         	Username
	         </th>
	         
	         <th style="width:120px;">
	         	Type
	         </th>

	         <th style="width:50px;">
	         	Is Admin
	         </th>
	         	         
	         <th style="width: 40px;">Actions</th>
	      </tr>
	   </thead>
	   <tbody>
	      @foreach ($users as $user)
	      <tr>
	      	<td align="center">
	      		<input type="checkbox" name="chk_usuarios[]" value="{{ $user->id_user }}" class="chkSelecionado"></input>
	      	</td>
	         <td>
	         	<a href="{{ URL::route('admin.user.edit', $user->id_user) }}">
	            	{{ $user->first_name }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.user.edit', $user->id_user) }}">
	            	{{ $user->last_name }}
	           </a>
	         </td>
	         
	         <td>
	            {{ $user->username }}
	         </td>
	         
	         <td align="center">
	         	
	         		@if ($user->type == SystemUser::TYPE_FACULTY)
	         			<div class="box-status-confirmado" style="width: 150px;">
	         				Faculty
	         			</div>
	         		@else
	         			<div class="box-status-convidado" style="width: 150px;">
	         				Student
	         			</div>	
	         		@endif
	         </td>
	         
	         <td align="center">
	         	
	            	@if ($user->is_admin)
	            		<div class="box-status-convidado" style="width: 60%;">
	            			Yes
	            		</div>
	            	@else
	            		<div class="box-status-declinado" style="width: 60%;">
	            			No
	            		</div>
	            	@endif
	           </div>
	         </td>
	         		      
	         <td align="center">
	            <!-- Multiple-action button -->
	            <div class="btn-group">
	               
		               <a class="btn btn-glow" href="{{ URL::route('admin.user.edit', $user->id_user) }}">
			               <i class="fa fa-pencil"></i>
			               <span>Edit</span>
		               </a>
		               <a class="btn btn-glow dropdown-toggle" href="" data-toggle="dropdown"><span class="caret"></span></a>
		           
		           	  <!-- Sub options -->
	               	  <ul class="dropdown-menu pull-right">
		                  <li>
		                     <a href="#2" title="delete" onclick="deletar('{{ URL::route('admin.user.delete', [$user->id_user]) }}');">
			                     <i class="fa fa-trash-o"></i>
			                     <span>Delete</span>
		                     </a>
		                  </li>
		              </ul>
	            </div>
	         </td>
	      </tr>
	      @endforeach
	   </tbody>
	</table>
	
	<br>
	<i>Displaying {{ sizeof ($users) }} {{ sizeof ($users) == 1 ? "item" : "items" }}</i>
	<br><br>			
	
	{{ Form::close() }}
@stop

@section('scripts_footer')
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery-ui.js') }}"></script>
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery.ui.datepicker-pt-BR.js') }}"></script>
	<script src="{{ URL::to('_temas/admin/media/js/dtsc/shift-check.js') }}"></script>
	<script src="{{ URL::to('_temas/admin/media/js/dtsc/mumsched.js') }}"></script>
	<script src="{{ URL::to('_temas/admin/media/js/dtsc/progress_bar.js') }}"></script>
	
	<script>	
		$('[data-rel=popover]').popover({html:true});
		admin.confirmarExclusao();
	</script>
@stop