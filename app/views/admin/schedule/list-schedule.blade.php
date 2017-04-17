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
   		<a href="{{ URL::route('admin.schedule.create') }}" class="blue">Create schedule</a>
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

	         <th style="width:25%;">
	         	Schedule Generated At
	         </th>
	         
	         <th style="width:10%;">
	         	Status
	         </th>
	         
	         <th style="width:20%;">Actions</th>
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
	         	@if ($schd->generated_date)
		         	<a href="{{ URL::route('admin.schedule.edit', $schd->id_schedule) }}">
		            	{{ $schd->generated_date }}
		            </a>
	           @else
					Not automatically generated
	           @endif
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
	               
		          	  @if ($schd->generated_date)
			          	  <a class="btn btn-glow" href="{{ URL::route('calendar.view', [$schd->id_schedule]) }}" target="_new">
						  	  <i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;&nbsp; <span>View Schedule</span>&nbsp;&nbsp;&nbsp;&nbsp;
						  </a>
					  @else
			          	  <a class="btn btn-glow" href="#2" onclick="scheduleConfiguration('{{ URL::route('admin.schedule.generate', $schd->id_schedule) }}', '{{ URL::route('admin.schedule.list') }}');">
							  <i class="fa fa-calendar"></i>
								  <span>Generate Schedule</span>
						  </a>
					  @endif
				 	  <a class="btn btn-glow dropdown-toggle" href="" data-toggle="dropdown"><span class="caret"></span></a>
						  			          
	               		           
		           	  <!-- Sub options -->
	               	  <ul class="dropdown-menu pull-right">
	               	  	  @if ($schd->generated_date == null)
			                  <li>
					          	  <a href="{{ URL::route('calendar.view', [$schd->id_schedule]) }}" target="_new">
								  	  <i class="fa fa-calendar"></i> <span>View Schedule</span>
								  </a>
			                  </li>
			              @endif
		                  <li>
		                     <a href="{{ URL::route('admin.schedule.edit', $schd->id_schedule) }}">
			                     <i class="fa fa-pencil"></i>
			                     <span>Edit</span>
		                     </a>
		                  </li>
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
	
	<!-- MODAL FOR "SCHEDULE CONFIGURATION" -->
	<div class="modal fade" id="modal-schedule-configuration">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title">SCHEDULE GENERATOR CONFIGURATION</h4>
	            </div>
	            
	            <div class="modal-body">
	            	
	            	<div class="form-group">
	            		<label class="col-sm-3 control-label no-padding-right blue">Algorithm Type</label>
	            		<div class="col-sm-9">
							{{ Form::select('algorithm_type', 
		        				[\Schedule::ALGORITHM_MUM_DEFAULT => 'Maharishi University Default', 
		        				 \Schedule::ALGORITHM_ONLY_COMPUTER_SCIENCE => 'Only Computer Science Courses'],
		        				null,
		            				[
		            					'id' => 'cbo-algorithm-type',
		            					'class' => 'multiple-selected-big'
		            				]
								)
		        			}}
							<span 
							    data-content="<font color='black'><b>MUM Default Algorithm</b></font> will generate a schedule with SCI course in the 1st block and MPP/FPP in the 2nd block." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>														
		        			
			            </div>
			       	</div>
			       	<br><br>

	            	<div class="form-group">
	            		<label class="col-sm-3 control-label no-padding-right blue">Block Order</label>
	            		<div class="col-sm-9">
							{{ Form::select('order', 
		        				[
		        					\Schedule::BLOCK_ORDER_DEFAULT => 'Same order as registered in the system',
		        					\Schedule::BLOCK_ORDER_RANDOM  => 'Random order', 
		        				],
		        				null,
		            				[
		            					'id' => 'cbo-order',
		            					'class' => 'multiple-selected-big'
		            				]
								)
		        			}}
		        			
							<span 
							    data-content="<font color='black'><b>Select the Same order option</b></font> if you want to generate a regular schedule." 
								data-placement="right"
								data-rel="popover" 
								data-trigger="hover"
								class="btn btn-blue btn-sm popover-success popover-notitle btn-ajuda">
								<i class="ace-icon fa fa-question-circle bigger-150 white"></i>
							</span>														
		        			
			            </div>
			       	</div>
			       	
			       	<br><br><br>
			       	
			       	<button id="btnGenerate" onclick="btnGenerateSchedule();" class="btn btn-default primary"><i class="fa fa-check"></i> Generate Schedule</button>
	        	</div>
	    	</div>
		</div>
	</div>
	
	<!-- MODAL FOR "GENERATE SCHEDULE" -->
	<div class="modal fade" id="modal-generate-schedule">
	    <div class="modal-dialog" style="min-width: 60%;">
	        <div class="modal-content">
	            <div class="modal-header">
	            	<center>
	            		<h3 class="modal-title"><i class="fa fa-cogs"></i>&nbsp;&nbsp;&nbsp;GENERATING SCHEDULE</h3>
	                </center>
	            </div>
	            <div class="modal-body">
	            	<br>
	            	<center>
	            		<img src="{{ URL::to('_plataforma/media/img/dtsc/mentoria.gif') }}" style="width: 80%; height: auto;">
	            	</center>
	            	
					<div class="loader">
						<div class="progress-bar"><div class="progress-stripes"></div><div class="percentage">0%</div></div>
					</div>
					
	            	<div align="right"><img src="{{ URL::to('_plataforma/media/img/dtsc/logo_dtsc.png') }}" width="30"></div>
	            	
	            </div>
	        </div>
	    </div>
	</div>
	
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