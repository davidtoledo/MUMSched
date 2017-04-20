<!-- Screen ID: tab-user -->
@if (isset($user))
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/user/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.user.edit', $user->id_user) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				@if (Auth::user()->is_admin)
					Edit user
				@else
					Profile
				@endif
			</a>
		</li>
		
		@if ($user->type == \SystemUser::TYPE_FACULTY)
			<li class="{{ Request::is('admin/user/specialization*') ? ' active ' : '' }}">
				<a href="{{ URL::route('admin.user.specialization.list', $user->id_user) }}">
					<i class="blue ace-icon fa fa-graduation-cap bigger-110"></i>
					Specialization
				</a>
			</li>
			
			<li class="{{ Request::is('admin/user/course*') ? ' active ' : '' }}">
				<a href="{{ URL::route('admin.user.course.list', $user->id_user) }}">
					<i class="blue ace-icon fa fa-book bigger-110"></i>
					Courses
				</a>
			</li>
		@endif
	</ul>	
@endif