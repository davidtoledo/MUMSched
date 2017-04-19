@extends('admin/base')

@section('page_title') MUM Schedule @endsection

@section('css_header')
	<link rel="stylesheet" href="{{ URL::to('_temas/_base/media/css/jqueryui-blue/jquery-ui.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::to('_temas/admin/media/css/progress_bar.css') }}" />	
@endsection

@section('breadcrumb')
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#2">MUMSched</a>
		</li>
		<li>
			<i class="ace-icon fa fa-lock"></i>
			<a href="{{ URL::route('admin.course.list') }}">
				Course
			</a>
		</li>
		<li>
			List
		</li>
	</ul>
@endsection

@section('content')
	<!-- Screen ID: list-course -->	    
	<h4 class="pink">
   		<i class="ace-icon fa fa-plus-square green"></i>
   		<a href="{{ URL::route('admin.course.create') }}" class="blue">Create course</a>
   	</h4>

	<div class="page-header">
	   <h1>
	      Course
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
			'action' => ['admin.course.list'],
			'files'  => 'true'
		]) 
	}}
	
	<!-- Navigation Controls -->
	{{ Form::hidden('page', isset( $_GET['page'] ) ? $_GET['page'] : "", ['id' => 'page'] ) }}
	{{ Form::hidden('id_course', '', ['id' => 'id_course']) }}
		
	<table class="table table-striped table-bordered table-hover">
	   <thead>
	      <tr>
			<th style="width:4%;">
				<center>
					<input type="checkbox" onchange="checkAll(this);"></input>
				</center>
			</th>							
	         
	         <th style="width:20%;">
	         	Course Code
	         </th>

	         <th style="width:40%;">
	         	Course Name
	         </th>
	         
	         <th style="width:20%;">
	         	Course Area
	         </th>	         
	         
	         <th style="width:12%;">Actions</th>
	      </tr>
	   </thead>
	   <tbody>
	      @foreach ($courses as $course)
	      <tr>
	      	<td align="center">
	      		<input type="checkbox" name="chk_usuarios[]" value="{{ $course->id_course }}" class="chkSelecionado"></input>
	      	</td>
	      	
	         <td>
	         	<a href="{{ URL::route('admin.course.edit', $course->id_course) }}">
	            	{{ $course->code }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.course.edit', $course->id_course) }}">
	            	{{ $course->name }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.course.edit', $course->id_course) }}">
	            	{{ $course->specialization->specialization }}
	           </a>
	         </td>	        
	         
	         <td align="center">
	            <!-- Multiple-action button -->
	            <div class="btn-group">
		               <a class="btn btn-glow" href="{{ URL::route('admin.course.edit', $course->id_course) }}">
			               <i class="fa fa-pencil"></i>
			               <span>Edit</span>
		               </a>
		               <a class="btn btn-glow dropdown-toggle" href="" data-toggle="dropdown"><span class="caret"></span></a>
		           
		           	  <!-- Sub options -->
	               	  <ul class="dropdown-menu pull-right">
		                  <li>
		                     <a href="#2" title="delete" onclick="deletar('{{ URL::route('admin.course.delete', [$course->id_course]) }}');">
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
	<i>Displaying {{ sizeof ($courses) }} {{ sizeof ($courses) == 1 ? "item" : "items" }}</i>
	<br><br>			
		
	{{ Form::close() }}
@stop

@section('scripts_footer')
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery-ui.js') }}"></script>
	<script src="{{ URL::to('_plataforma/media/js/plugins/jquery.ui.datepicker-pt-BR.js') }}"></script>
	<script src="{{ URL::to('_temas/admin/media/js/dtsc/shift-check.js') }}"></script>
	<script src="{{ URL::to('_temas/admin/media/js/dtsc/mumsched.js') }}"></script>
	
	<script>	
		$('[data-rel=popover]').popover({html:true});
		admin.confirmarExclusao();
	</script>
@stop