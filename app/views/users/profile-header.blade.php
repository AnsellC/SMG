
<div class="profile-header row">
	<div class="col-md-8 col-md-offset-2">
		<div class="row">
			<div class="col-xs-4 col-md-2">
				<div class="picture">
					@if(!Auth::user()->getProfilePic())
						<img src="/img/avatar/1.png" class="img-circle" alt=""/><br />
					@else
						<img class="avatar img-responsive" src="{{{ $user->getProfilePic('120x120') }}}" alt="" /><br />
					@endif
					<button class="btn btn-primary btn-sm">Follow</button>
				</div>
			</div>
			<div clas="col-xs-8 col-md-10">
				<div class="username">
					<h1>
					@if($user->showfullname == "1")
						{{{ $user->fullname }}} ({{{ $user->username }}})
					@else
						{{{ $user->username }}}
					@endif
					</h1>
					<p class="sub">
					@if(!empty($user->specialty))
						{{{ $user->specialty }}} scale modeling specialist
					@endif
					@if($user->show_location == "1" AND !empty($user->country))
						<br />
						<i class="fa fa-map-marker"></i> {{{ $user->country }}}
					@endif
					</p>
				</div>
				<div class="user-meta">
					<div class="pull-left links visible-lg visible-md">
						@if(!empty($user->website))
							<span><i class="fa fa-link"></i> <a href="{{{ $user->website }}}" rel="nofollow">My Website</a></span>
						@endif
						@if(!empty($user->facebook))
							<span><i class="fa fa-facebook"></i> <a href="{{{ $user->facebook }}}" rel="nofollow">Facebook</a></span>
						@endif
						@if(!empty($user->twitter))
							<span><i class="fa fa-twitter"></i> <a href="{{{ $user->twitter }}}" rel="nofollow">Twitter</a></span>	
						@endif
					</div>			
					<div class="pull-right user-numbers">
						<div>
							<a class="{{ Route::is( 'users.show') ? 'active' : '' }}" href="/users/{{{ $user->username }}}">
								<span class="count">{{ number_format(count($user->photos)) }}</span>
								<span class="label">Photos</span>
							</a>
						</div>
						<div>
							<a class="{{ Route::is( 'users.showCollections') ? 'active' : '' }}" href="/users/{{{ $user->username }}}/collections">
								<span class="count">{{ number_format(count($user->collections)) }}</span>
								<span class="label">Collections</span>
							</a>
						</div>
						<div>
							<a href="/users/{{{ $user->username }}}/followers">
								<span class="count">{{ number_format(count($user->followers)) }}</span>
								<span class="label">Followers</span>
							</a>
						</div>					
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		
	</div>
</div>
