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
			<a href="{{ URL::route('admin.entry.list') }}">
				Entries
			</a>
		</li>
		<li>
			List
		</li>
	</ul>
@endsection

@section('content')
	<!-- Screen ID: list-entry -->	    
	<h4 class="pink">
   		<i class="ace-icon fa fa-plus-square green"></i>
   		<a href="{{ URL::route('admin.entry.create') }}" class="blue">Create a new Entry</a>
   	</h4>

	<div class="page-header">
	   <h1>
	      Entry
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
			'action' => ['admin.entry.list'],
			'files'  => 'true'
		]) 
	}}
	
	<!-- Navigation Controls -->
	{{ Form::hidden('page', isset( $_GET['page'] ) ? $_GET['page'] : "", ['id' => 'page'] ) }}
	{{ Form::hidden('id_entry', '', ['id' => 'id_entry']) }}
		
	<table class="table table-striped table-bordered table-hover">
	   <thead>
	      <tr>
			<th style="width:4%;">
				<center>
					<input type="checkbox" onchange="checkAll(this);"></input>
				</center>
			</th>							
	      	
	         <th style="width:25%;">
	         	Entry
	         </th>

	         <th style="width:15%;">
	         	FPP total
	         </th>
	         
	         <th style="width:15%;">
	         	MPP Total
	         </th>
	         
			<th style="width:10%;">
	         	OPT percent
	        </th>
	         
	         <th style="width:10%;">
	         	Start Date
	         </th>
	         
	         <th style="width:10%;">
	         	End Date
	         </th>
	         
	         <th style="width:15%;">Actions</th>
	      </tr>
	   </thead>
	   <tbody>
	      @foreach ($entries as $entry)
	      <tr>
	      	<td align="center">
	      		<input type="checkbox" name="chk_usuarios[]" value="{{ $entry->id_entry }}" class="chkSelecionado"></input>
	      	</td>
	         <td>
	         	<a href="{{ URL::route('admin.entry.edit', $entry->id_entry) }}">
	            	{{ $entry->name }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.entry.edit', $entry->id_entry) }}">
	            	{{ $entry->fpp_total }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.entry.edit', $entry->id_entry) }}">
	            	{{ $entry->mpp_total }}
	           </a>
	         </td>
			
			
			<td>
	         	<a href="{{ URL::route('admin.entry.edit', $entry->id_entry) }}">
	            	{{ $entry->opt_percent }}
	           </a>
	         </td>
	         
	         
	         <td>
	         	<a href="{{ URL::route('admin.entry.edit', $entry->id_entry) }}">
	            	{{ date("m/d/Y", strtotime($entry->start_date)) }}
	           </a>
	         </td>
	         
	         <td>
	         	<a href="{{ URL::route('admin.entry.edit', $entry->id_entry) }}">
	            	{{ date("m/d/Y", strtotime($entry->end_date)) }}
	           </a>
	         </td>
	         
	         <td align="center">
	            <!-- Multiple-action button -->
	            <div class="btn-group">
		               <a class="btn btn-glow" href="{{ URL::route('admin.entry.edit', $entry->id_entry) }}">
			               <i class="fa fa-pencil"></i>
			               <span>Edit</span>
		               </a>
		               <a class="btn btn-glow dropdown-toggle" href="" data-toggle="dropdown"><span class="caret"></span></a>
		           
		           	  <!-- Sub options -->
	               	  <ul class="dropdown-menu pull-right">
		                  <li>
		                     <a href="#2" title="delete" onclick="deletar('{{ URL::route('admin.entry.delete', [$entry->id_entry]) }}');">
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
	<i>Displaying {{ sizeof ($entries) }} {{ sizeof ($entries) == 1 ? "item" : "items" }}</i>
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