<!-- Screen ID: tab-user -->
@if (isset($user))
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/user/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.user.edit', $user->id_user) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				Edit user
			</a>
		</li>
	</ul>
@endif