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
			<a href="{{ URL::route('admin.schedule.list') }}">
				Schedules
			</a>
		</li>
		<li>
			List
		</li>
	</ul>
@endsection

@section('content')
	<!-- Screen ID: list-schedule -->	    
	<h4 class="pink">
   		<i class="ace-icon fa fa-plus-square green"></i>
   		<a href="{{ URL::route('admin.schedule.generate') }}" class="blue">Generate Schedule</a>
   	</h4>

	<div class="page-header">
	   <h1>
	      Schedule
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
			'action' => ['admin.schedule.list'],
			'files'  => 'true'
		]) 
	}}
	
	<!-- Navigation Controls -->
	{{ Form::hidden('page', isset( $_GET['page'] ) ? $_GET['page'] : "", ['id' => 'page'] ) }}
	{{ Form::hidden('id_schedule', '', ['id' => 'id_schedule']) }}
		
	<table class="table table-striped table-bordered table-hover">
	   <thead>
	      <tr>
			<th style="width:4%;">
				<center>
					<input type="checkbox" onchange="checkAll(this);"></input>
				</center>
			</th>							
	      	
	         <th style="width:40%;">
	         	Entry
	         </th>

	         <th style="width:35%;">
	         	Schedule Generated At
	         </th>
	         
	         <th style="width:10%;">
	         	Status
	         </th>
	         
	         <th style="width:11%;">Actions</th>
	      </tr>
	   </thead>
	   <tbody>
	      @foreach ($schedules as $schd)
	      <tr>
	      	<td align="center">
	      		<input type="checkbox" name="chk_usuarios[]" value="{{ $schd->id_schedule }}" class="chkSelecionado"></input>
	      	</td>
	         <td>
	         	<a href="{{ URL::route('admin.schedule.edit', $schd->id_schedule) }}">
	            	{{ $schd->entry->name }}
	           </a>
	         </td>

	         <td>
	         	<a href="{{ URL::route('admin.schedule.edit', $schd->id_schedule) }}">
	            	{{ $schd->generated_date }}
	           </a>
	         </td>
	         
	         <td align="center">
	            @if ( $schd->status == \Schedule::STATUS_DRAFT )
	            	<div class="box-status-declinado" style="width: 60%;">
	            		DRAFT
	            	</div>
	            @else
	            	<div class="box-status-confirmado" style="width: 60%;">
	            		OK
	            	</a>
	            @endif
	         </td>
	         	         		      
	         <td align="center">
	            <!-- Multiple-action button -->
	            <div class="btn-group">
	               
		               <a class="btn btn-glow" href="{{ URL::route('admin.schedule.edit', $schd->id_schedule) }}">
			               <i class="fa fa-pencil"></i>
			               <span>Edit</span>
		               </a>
		               <a class="btn btn-glow dropdown-toggle" href="" data-toggle="dropdown"><span class="caret"></span></a>
		           
		           	  <!-- Sub options -->
	               	  <ul class="dropdown-menu pull-right">
		                  <li>
		                     <a href="#2" title="delete" onclick="deletar('{{ URL::route('admin.schedule.delete', [$schd->id_schedule]) }}');">
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
	<i>Displaying {{ sizeof ($schedules) }} {{ sizeof ($schedules) == 1 ? "item" : "items" }}</i>
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