<!-- Screen ID: tab-block -->
@if ( isset($block) )
	<ul class="nav nav-tabs" id="myTab3">
		<li class="{{ Request::is('admin/block/edit*') ? ' active ' : '' }}">
			<a href="{{{ URL::route('admin.block.edit', $block->id_block) }}}">
				<i class="blue ace-icon fa fa-pencil bigger-110"></i>
				Edit Block
			</a>
		</li>		
	</ul>	
@endif