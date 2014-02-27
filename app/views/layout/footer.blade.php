
<footer>
	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/about">About</a></li>
		<li><a href="/contact">Contact</a></li>
	</ul>
	<span class="version">
		@if(file_exists(base_path() . "/version"))
			{{ file_get_contents(base_path() . "/version") }}
		@endif
	</span>
</footer>
