@extends('calendar/_base/layouts/default') 

@section('header_elements')
@stop

@section('content') 
<!-- Screen ID: grid -->
<main data-style="color-c" data-page="discussoes">
	<script>
	    window.___gcfg = {
	      lang: 'en-US'
	    };
	</script>	
   <script src="https://apis.google.com/js/platform.js" async defer></script>
   <div class="center">
   	
   	<h3 class="titulo-5"><b>MASTERS in Computer Science Academic Schedule</b></h3><br>
   	<h2 class="titulo-8" style="font-size:20px;">
   		<b>
   			{{ $schedule->entry->name }} Entry
   		</b>
   	</h2>
   	   	
   	@if ( $schedule->status == \Schedule::STATUS_DRAFT )
		<div id="watermark">
			<p>DRAFT</p>
		</div>
	@endif   	
   	
   	<br>
      <p>
      	 <i>Schedule is subject to change</i>
	  </p>
      <div class="grid lista-tabela">
      	<br>
         <div class="linha separate">
            <div class="col-12">
                                 
               <table>
                  <tbody>
	              		<tr style="border: 1px solid #808080;">
	              			<td><p><b>BLOCK</b></p></td>
	              			<td><p><b>DATES</b></p></td>
	              			<td><p><b>MPP Track</b></p></td>
	              			<td><p><b>FPP Track</b></p></td>
	              		</tr>
	              		
	              		<?php $i = 0; ?>
	              		@foreach ($schedule->entry->blocks as $block)
							<tr {{ $i %2 == 0 ? "class='par'" : "" }}>
								<td style="width: 10%;">
								   <a href="#2" style="text-decoration: none; cursor: default; color: black;">
										{{ $block->name }}
								   </a>
								</td>
								<td style="width: 10%;">
									<p>
										{{ date('M d', strtotime($block->start_date) ) }} -
										{{ date('M d', strtotime($block->end_date) ) }} 
									</p>
								</td>
								
								@if ($block->num_mpp_courses == 0 && $block->num_fpp_courses == 0) 
									@for ($i=0; $i < 2; $i++)
										<td style="width: 40%;">
											<p><b>{{ $block->name }}</b></p>
										</td>
									@endfor
								@else
								
									<td style="width: 40%;">
										@foreach ($block->sections as $section)
											@if ($section->track == \Section::TRACK_MPP) 
												<p><b>{{ $section->course->name }} ({{ $section->course->code }})</b></p>
											@endif
										@endforeach
									</td>
									<td style="width: 40%;">
										@foreach ($block->sections as $section)
											@if ($section->track == \Section::TRACK_FPP) 
												<p><b>{{ $section->course->name }} ({{ $section->course->code }})</b></p>
											@endif
										@endforeach
									</td>
								@endif
																
							</tr>
							<?php $i++; ?>
						@endforeach
						
                  </tbody>
               </table>
			   <br>
            </div>
         </div>
      </div>      
   </div>

</main>
@stop

@section('script')
	{{ HTML::script('_plataforma/media/js/plugins/jquery-ui.js') }}
	{{ HTML::script('_temas/admin/media/js/dtsc/colorbox/jquery.mask.js') }}	
@stop