<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	
		
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navi">
				<i class="fa fa-bars fa-2x"></i>
	        </button>
		
		<a class="navbar-brand navbar-left" href="/"><img src="/img/logo.png" alt="SMG" /></a>


		<div class="collapse navbar-collapse navbar-left" id="navi">
			<ul class="nav navbar-nav">
				
				<li><a href="/browse">Browse</a></li>	
				<li><a href="/help">Help</a></li>	
				<li class="last"><form class="navbar-form" role="search" method="post" action="/search"><i class="fa fa-search"></i> <input placeholder="search..." type="text" name="query"/></form></li>			
			</ul>
		</div>

		@if(Auth::check())
			
			<div class="navbar-right border-left signout visible-lg visible-md">
				<a href="/logout"><i data-toggle="tooltip" data-placement="bottom" title="Sign out" class="fa fa-sign-out fa-2x"></i></a>
			</div>
			<div class="navbar-right border-left upload visible-lg visible-md">
				<a href="/my-uploads/create"><i data-toggle="tooltip" data-placement="bottom" title="Upload" class="fa fa-cloud-upload fa-2x"></i></a>
			</div>
			<div class="navbar-right dropdown">
		
			<a href="#" data-toggle="dropdown" class="dropdown-toggle">
				<span class="media margin-none">
				@if(!Auth::user()->getProfilePic())
					<img src="/img/avatar/1.png" class="img-circle" alt=""/>
				@else
					<img src="{{Auth::user()->getProfilePic('40x40')}}" class="img-circle" alt=""/>
				@endif
				</span>
				<span class="media-body">{{{ Auth::user()->username }}} <span class="caret"></span></span>
			</a>
				<ul class="dropdown-menu user-dropdown pull-right">
					<li>{{HTML::link('/dashboard','Dashboard')}}</li>
					<li>{{HTML::link('/users/' . Auth::user()->username, 'My Profile')}}</li>
					<li class="divider"></li>
					<li>{{ HTML::link('/my-uploads', 'My Uploads') }}</li>
					<li>{{ HTML::link('/my-collections', 'My Collections') }}</li>
					<li>{{ HTML::link('/my-uploads/create', 'Upload Photos') }}</li>
					<li class="divider"></li>
					@if(!Auth::user()->confirmed)
						<li>{{HTML::link('/resend-activation','Resend Activation')}}</li>
					@endif					
					<li>{{HTML::link('/logout','Sign out')}}</li>
				</ul>	
			</div>
			@else
				<div class="navbar-right nav-btns">
					<a href="/register">Sign up <i class="fa fa-pencil-square-o"></i></a>
					<a href="/login" class="border-left">Sign in <i class="fa fa-sign-in"></i></a>
				</div>
			@endif			
	
</nav>