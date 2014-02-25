@extends('layout.default')
@section('content')
@include('users.profile-header')
<div class="row main-content profile">

	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<h2>Photos</h2>
	</div>
	<div class="col-md-8 col-md-offset-2 col-xs-12">

		@if(count($photos) == 0)
	
			<div class="alert alert-warning">
				This user doesn't have any photos.
			</div>
		@else
			<div class="row" id="photos">
				@foreach($photos AS $photo)

					<div class="col-xs-6 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-body">

								<?php if(empty($photo->description)) $photo->description = "no description..."; ?>
								<a href="/{{{ $photo->file_path }}}"><img title="{{{ $photo->file_name}}}" class="img-responsive lazy" src="{{{ Storage::getPhoto($photo->file_path, '384x216') }}}" /></a>
									<div class="pull-left photo-date">
										<span>{{ Date::make($photo->created_at)->ago() }}</span>
									</div>
									<div class="photo-meta pull-right">
										<span data-toggle="tooltip" title="Likes"><i class="fa fa-thumbs-up"></i> {{ count($photo->likers) }}</span>
										<span data-toggle="tooltip" title="Views"><i class="fa fa-eye"></i> {{ number_format($photo->views) }}</span>
									</div>
									<div class="clearfix"></div>
							</div>
						</div>
					</div>
				@endforeach
				
			</div>
			<button id="load-photos" data-offset="0" data-uid="{{{ $user->id }}}" class="btn btn-large btn-block btn-success">Load more...</button>
		@endif
		

	</div>
</div>

@stop