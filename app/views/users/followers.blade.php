@extends('layout.default')
@section('content')
@include('users.profile-header')
<div class="row main-content profile">

	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<h2>Followers</h2>
	</div>
	<div class="col-md-8 col-md-offset-2 col-xs-12">

		@if(count($user->followers) == 0)
	
			<div class="alert alert-warning">
				This user doesn't have any followers.
			</div>
		@else
			<div class="row" id="photos">
				@foreach($user->followers AS $follower)
					
					<div class="col-xs-6 col-lg-4 follower">
						
						<div class="panel panel-default">
							<div class="panel-body">
								<img class="pull-left pic" src="{{ $follower->getProfilePic('60x60') }}"/>
								<span class="username"><a href="/users/{{{ $follower->username }}}">{{ $follower->username }}</a></span>
								<span class="location">
									@if(!empty($follower->country) AND $follower->show_location == 1)
										<i class="fa fa-map-marker"></i> {{{ $follower->country }}}</i>
									@else
										<i class="fa fa-calendar-o"></i> {{ Date::make($follower->created_at)->ago() }}
									@endif
								</span>
								<a class="btn btn-primary btn-sm @if(Auth::user())follow-user@endif" href="/follow/{{ $follower->username }}">
								@if(Auth::user() AND Auth::user()->iFollow($follower->id))
									<i class="fa fa-thumbs-up"></i> Following
								@else
									<i class="fa fa-hand-o-right"></i> Follow
								@endif
							</a>
							</div>
						</div>
						
					</div>
					
					
				@endforeach
				
			</div>
			
		@endif
		

	</div>
</div>

@stop