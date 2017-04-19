<!-- Screen ID: tab-entry -->
@if ( isset($course) )
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/course/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.course.edit', $course->id_course) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				Edit course
			</a>
		</li>		
	</ul>	
@endif