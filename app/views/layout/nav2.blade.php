	
		<section id="header-contain">
			<div class="container">
				<div class="row">
					<div class="span12">
						<a class="brand" href="/"><img src="/img/logo.png" alt="" /></a>
						<form>
							<fieldset class="search-form">
								<input class="search" type="text" placeholder="Search...">
								<button class="search-button" type="button"></button>
							</fieldset>
						</form>		
						@if(Auth::check())	
							<div class="memnav">
							<div class="btn-group">
								<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="memavatar">
								@if(!Auth::user()->getProfilePic())
									<img src="/img/avatar/1.png" alt=""/>
								@else
									<img src="{{Auth::user()->getProfilePic('40x40')}}" alt=""/>
								@endif
								</span>
								<span class="caret"></span>
								</a>				
								<ul class="dropdown-menu">
									<li>{{HTML::link('/dashboard','Dashboard')}}</li>
									<li>{{HTML::link('/users/' . Auth::user()->username, 'My Profile')}}</li>
									<li>{{HTML::link('/logout','Sign out')}}</li>
									@if(!Auth::user()->confirmed)
									<li>{{HTML::link('/resend-activation','Resend Activation')}}</li>
									@endif
								</ul>
							</div>
						</div>
						@else				
						<div class="login-register">
							<a href="#loginbox" class="btn btn-inverse" data-toggle="modal" data-target="#loginbox">Login</a><a href="register" class="btn btn-primary">Sign Up!</a>					
						</div>	
						@endif					
					</div>
				</div>
			</div>
		</section>		