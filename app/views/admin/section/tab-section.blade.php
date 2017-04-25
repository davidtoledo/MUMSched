<!-- Screen ID: tab-section -->
@if ( isset($section) )
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/section/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.section.edit', $section->id_section) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				Edit Section
			</a>
		</li>		
	</ul>	
@endif