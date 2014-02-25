
		<div class="navbar navbar-inverse navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>	

					<!-- Start nav-collapse -->
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li>{{HTML::link('browse','Browse Photos')}}</li>	
							<li>{{HTML::link('modelers','Browse Modellers')}}</li>	
							<li>{{HTML::link('help','Help')}}</li>	
							<li>{{HTML::link('about','About')}}</li>			
							
						</ul>
					</div>
					<!-- End nav-collapse -->
					
						@if(Auth::check())	
							<div class="memnav-alt">
							<div class="btn-group">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="memavatar"><img src="img/avatar/1.png" alt=""/></span>
								<span class="caret"></span>
								</a>				
								<ul class="dropdown-menu">
									<li>{{HTML::link('dashboard','Dashboard')}}</li>
									<li>{{HTML::link('settings', 'Settings')}}</li>
									<li>{{HTML::link('user/' . Auth::user()->username, 'My Profile')}}</li>
									<li>{{HTML::link('logout','Sign out')}}</li>
								</ul>
							</div>
						</div>
						@endif
				</div>
			</div>
		</div>