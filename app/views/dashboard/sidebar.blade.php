		<div class="panel panel-default">
			<div class="panel-body text-center">
				@if(!Auth::user()->getProfilePic())
					<img src="/img/avatar/1.png" class="img-circle" alt=""/>
				@else
					<img src="{{Auth::user()->getProfilePic('150x150')}}" class="img-circle" alt=""/>
				@endif
				<h2 class="profile-panel">{{{ Auth::user()->username }}}</h2>

			</div>
			<div class="panel-footer panel-footer-success">
				<div class="row">
					<div class="profile-details col-xs-4 text-center"><i class="fa fa-picture-o"></i> {{ number_format(count(Auth::user()->photos)) }}</div>
					<div class="profile-details col-xs-4 text-center"><span class="glyphicon glyphicon-compressed"></span> {{ number_format(count(Auth::user()->collections)) }}</div>
					<div class="profile-details col-xs-4 text-center"><span class="glyphicon glyphicon-ok-sign"></span> {{ number_format(count(Auth::user()->photos)) }}</div>
				</div>
			</div>
			
		</div>
		<div class="list-group visible-lg visible-md">
			<a class="list-group-item {{ Request::is( 'my-uploads/create') ? 'active' : '' }}" href="/my-uploads/create"><i class="fa fa-cloud-upload"></i> Upload Photos</a>
			<a class="list-group-item {{ Request::is( 'my-collections/create') ? 'active' : '' }}" href="/my-collections/create"><i class="glyphicon glyphicon-folder-close"></i> Create a Collection</a>
			<a class="list-group-item {{ Request::is( 'edit-profile') ? 'active' : '' }}" href="/edit-profile"><i class="fa fa-pencil"></i> Edit profile</a>
			<a class="list-group-item {{ Request::is( 'edit-email-pass') ? 'active' : '' }}" href="/edit-email-pass"><i class="fa fa-lock"></i> Email &amp; password</a>
			<a class="list-group-item {{ Request::is( 'profile-picture') ? 'active' : '' }}" href="/profile-picture"><i class="fa fa-picture-o"></i> Your Profile Picture</a>
			<a class="list-group-item {{ Request::is( 'my-uploads') ? 'active' : '' }}" href="/my-uploads"><i class="glyphicon glyphicon-picture"></i> My Photos</a>	
			<a class="list-group-item {{ Request::is( 'my-collections') ? 'active' : '' }}" href="/my-collections"><i class="fa fa-folder-open"></i> My Collections</a>
			@if(!Auth::user()->confirmed)
			<a class="list-group-item {{ Request::is( 'resend-activation') ? 'active' : '' }}" href="resend-activation"><i class="fa fa-mail-forward"></i> Resend Activation Mail</a>
			@endif
		</div>
