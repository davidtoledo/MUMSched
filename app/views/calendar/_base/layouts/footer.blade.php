<footer>
	<div class="center">
		<ul class="links-a">
			<li>
				{{ HTML::link(URL::route('login'), 'MUMSched', array('target' => '_blank')) }}
			</li>
			<li>
				{{ HTML::link(URL::route('admin.schedule.list'), 'Schedule List', array('target' => '_blank')) }}
			</li>
		</ul>		
		<ul class="links-b">
			<li>
				{{ HTML::link('http://www.mum.edu/', 'Maharishi University of Management', array('target' => '_blank')) }}
			</li>
		</ul>		
	</div>
</footer>

<script>
	var base_path = '{{ url('/') }}';
</script>

{{ HTML::script('_plataforma/media/js/plugins/jquery-1.10.1.min.js') }}
@yield('scripts_footer')