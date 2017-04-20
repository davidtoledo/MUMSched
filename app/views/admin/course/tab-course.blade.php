<!-- Screen ID: tab-course -->
@if ( isset($course) )
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/course/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.course.edit', $course->id_course) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				Edit course
			</a>
		</li>
		<li class="{{ Request::is('admin/course/prerequisite*') ? ' active ' : '' }}">
			<a href="{{ URL::route('admin.course.prerequisite.list', $course->id_course) }}">
				<i class="blue ace-icon fa fa-sitemap bigger-110" aria-hidden="true"></i>
				Prerequisite
			</a>
		</li>		
	</ul>	
@endif
