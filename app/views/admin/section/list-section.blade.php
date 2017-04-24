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
			<a href="{{ URL::route('admin.section.list') }}">
				Sections
			</a>
		</li>
		<li>
			List
		</li>
	</ul>
@endsection

@section('content')
	<!-- Screen ID: list-section -->	    
	<h4 class="pink">
   		<i class="ace-icon fa fa-plus-square green"></i>
   		<a href="{{ URL::route('admin.section.create') }}" class="blue">Create a new Section</a>
   	</h4>

	<div class="page-header">
	   <h1>
	      Section
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
			'action' => ['admin.section.list'],
			'files'  => 'true'
		]) 
	}}
	
	<!-- Navigation Controls -->
	{{ Form::hidden('page', isset( $_GET['page'] ) ? $_GET['page'] : "", ['id' => 'page'] ) }}
	{{ Form::hidden('id_section', '', ['id' => 'id_section']) }}
		
	<table class="table table-striped table-bordered table-hover">
	   <thead>
	      <tr>
			<th style="width:4%;">
				<center>
					<input type="checkbox" onchange="checkAll(this);"></input>
				</center>
			</th>							
	      	

	         <th style="width:10%;">
	         	Entry
	         </th>
	         
	         
	         <th style="width:10%;">
	         	Block
	         </th>
	         
	         <th style="width:5%;">
	         	Track
	         </th>

	         <th style="width:25%;">
	         	Course
	         </th>
	         
	         <th style="width:20%;">
	         	Faculty
	         </th>
	         
	         <th style="width:5%;">
	         	Capacity
	         </th>
	         <th style="width:10%;">Actions</th>
	      </tr>
	   </thead>
	   <tbody>
	      @foreach ($sections as $section)
	      <tr>
	      	<td align="center">
	      		<input type="checkbox" name="chk_usuarios[]" value="{{ $section->id_section }}" class="chkSelecionado"></input>
	      	</td>
	         
	         <td>
	         	<a href="{{ URL::route('admin.section.edit', $section->id_section) }}">
	            	{{ $section->block->entry->name }}
	           </a>
	         </td>
	         
	         <td>
	         	<a href="{{ URL::route('admin.section.edit', $section->id_section) }}">
	            	{{ $section->block->name }}
	           </a>
	         </td>
	         
	         
	         <td>
	         	<a href="{{ URL::route('admin.section.edit', $section->id_section) }}">
	            	{{ $section->track }}
	           </a>
	         </td>

	         

	         <td>
	         	<a href="{{ URL::route('admin.section.edit', $section->id_section) }}">
	            	{{ $section->course->name }}
	           </a>
	         </td>

 			<td>
	         	<a href="{{ URL::route('admin.section.edit', $section->id_section) }}">
	            	{{ $section->faculty->first_name}} {{ $section->faculty->last_name}}
	           </a>
	        </td>
	        
	        <td>
	         	<a href="{{ URL::route('admin.section.edit', $section->id_section) }}">
	            	{{ $section->capacity}}
	           </a>
	        </td>
	        

	         
	         <td align="center">
	            <!-- Multiple-action button -->
	            <div class="btn-group">
		               <a class="btn btn-glow" href="{{ URL::route('admin.section.edit', $section->id_section) }}">
			               <i class="fa fa-pencil"></i>
			               <span>Edit</span>
		               </a>
		               <a class="btn btn-glow dropdown-toggle" href="" data-toggle="dropdown"><span class="caret"></span></a>
		           
		           	  <!-- Sub options -->
	               	  <ul class="dropdown-menu pull-right">
		                  <li>
		                     <a href="#2" title="delete" onclick="deletar('{{ URL::route('admin.section.delete', [$section->id_section]) }}');">
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
	<i>Displaying {{ sizeof ($sections) }} {{ sizeof ($sections) == 1 ? "item" : "items" }}</i>
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