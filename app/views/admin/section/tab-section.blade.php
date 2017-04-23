<!-- Screen ID: tab-entry -->
@if ( isset($entry) )
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/entry/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.entry.edit', $entry->id_entry) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				Edit entry
			</a>
		</li>		
	</ul>	
@endif