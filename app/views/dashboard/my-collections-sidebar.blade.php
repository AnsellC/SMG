<div class="span3">
	<div class="navaside">
		<ul class="nav">
			<li class="{{ Request::is( 'dashboard') ? 'active' : '' }}"><a href="/dashboard"><i class="icon-home"></i> Back to Dashboard</a></li>
			<li class="{{ Request::is( 'my-uploads') ? 'active' : '' }}"><a href="/my-uploads"><i class="icon-picture"></i> My Uploads</a></li>	
			<li class="{{ Request::is( 'my-uploads/create') ? 'active' : '' }}"><a href="/my-uploads/create"><i class="icon-cloud-upload"></i> Upload Photos</a></li>	
			<li class="{{ Request::is( 'my-collections') ? 'active' : '' }}"><a href="/my-collections"><i class="icon-folder-open"></i> My Collection</a></li>			
			<li class="{{ Request::is( 'my-collections/create') ? 'active' : '' }}"><a href="/my-collections/create"><i class="icon-folder-open"></i> Create a Collection</a></li>	
		</ul>
	</div>
</div>