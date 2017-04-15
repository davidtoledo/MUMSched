<!-- Screen ID: tab-schedule -->
@if ( isset($schedule) )
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/schedule/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.schedule.edit', $schedule->id_schedule) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				Edit schedule
			</a>
		</li>		
	</ul>	
@endif