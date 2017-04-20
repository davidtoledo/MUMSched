@extends('admin/base')

@section('page_title') MUM Section @endsection

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
			<a href="{{ URL::route('admin.block.list') }}">
				Blocks
			</a>
		</li>
		<li>
			List
		</li>
	</ul>
@endsection

@section('content')
	<!-- Screen ID: list-block -->	    
	<h4 class="pink">
   		<i class="ace-icon fa fa-plus-square green"></i>
   		<a href="{{ URL::route('admin.block.create') }}" class="blue">Create block</a>
   	</h4>

	<div class="page-header">
	   <h1>
	      Block
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
			'action' => ['admin.block.list'],
			'files'  => 'true'
		]) 
	}}
	
	<!-- Navigation Controls -->
	{{ Form::hidden('page', isset( $_GET['page'] ) ? $_GET['page'] : "", ['id' => 'page'] ) }}
	{{ Form::hidden('id_block', '', ['id' => 'id_block']) }}
		
	<table class="table table-striped table-bordered table-hover">
	   <thead>
	      <tr>
			<th style="width:4%;">
				<center>
					<input type="checkbox" onchange="checkAll(this);"></input>
				</center>
			</th>							
	      	
	         <th style="width:20%;">
	         	Block
	         </th>
	         
	         <th style="width:10%;">
	         	Entry
	         </th>

	         <th style="width:15%;">
	         	Start date
	         </th>
	         
	         <th style="width:15%;">
	         	End Date
	         </th>

	         <th style="width:10%;">
	         	Number of MPP courses
	         </th>
	         
	         <th style="width:10%;">
	         	Number of FPP courses
	         </th>
	         
	         <th style="width:10%;">Actions</th>
	      </tr>
	   </thead>
	   <tbody>
	      @foreach ($blocks as $block)
	      <tr>
	      	<td align="center">
	      		<input type="checkbox" name="chk_usuarios[]" value="{{ $block->id_block }}" class="chkSelecionado"></input>
	      	</td>
	         <td>
	         	<a href="{{ URL::route('admin.block.edit', $block->id_block) }}">
	            	{{ $block->name }}
	           </a>
	         </td>
				
			<td>
	         	<a href="{{ URL::route('admin.block.edit', $block->id_block) }}">
	            	{{ $block->entry->name }}
	           </a>
	        </td>
	         
	         <td>
	         	<a href="{{ URL::route('admin.block.edit', $block->id_block) }}">
	            	{{ date("m/d/Y", strtotime($block->start_date)) }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.block.edit', $block->id_block) }}">
	            	{{ date("m/d/Y", strtotime($block->end_date)) }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.block.edit', $block->id_block) }}">
	            	{{ $block->num_mpp_courses }}
	           </a>
	         </td>
	         
	         <td>
	         	<a href="{{ URL::route('admin.block.edit', $block->id_block) }}">
	            	{{ $block->num_fpp_courses }}
	           </a>
	         </td>
	         
	         <td align="center">
	            <!-- Multiple-action button -->
	            <div class="btn-group">
		               <a class="btn btn-glow" href="{{ URL::route('admin.block.edit', $block->id_block) }}">
			               <i class="fa fa-pencil"></i>
			               <span>Edit</span>
		               </a>
		               <a class="btn btn-glow dropdown-toggle" href="" data-toggle="dropdown"><span class="caret"></span></a>
		           
		           	  <!-- Sub options -->
	               	  <ul class="dropdown-menu pull-right">
		                  <li>
		                     <a href="#2" title="delete" onclick="deletar('{{ URL::route('admin.block.delete', [$block->id_block]) }}');">
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
	<i>Displaying {{ sizeof ($blocks) }} {{ sizeof ($blocks) == 1 ? "item" : "items" }}</i>
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