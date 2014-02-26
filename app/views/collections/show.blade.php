@extends('layout.default')
@section('content')

<div class="row collection-header">

	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<h1>{{{ $collection-> title }}}</h1>
		<div class="sub-heading">
			by <a href="/users/{{$collection->user->username }}">{{$collection->user->username }}</a> Last updated {{ Date::make($collection->updated_at)->ago() }}
		</div>
		<div class="description">
			{{{ $collection->description }}}
		</div>
	</div>
</div>



<div class="row main-content profile">
	
	

	<div class="col-md-8 col-md-offset-2 col-xs-12">

		@if(count($collection->photos) == 0)
		
			<div class="alert alert-warning">
				This collection is empty.
			</div>
		@else

			<div class="row" id="photos">
				@foreach($collection->photos AS $photo)			
					<div class="col-xs-6 col-lg-4">
						<div class="panel panel-default">
							<div class="panel-body">

								<?php if(empty($photo->description)) $photo->description = "no description..."; ?>
								<a data-fancybox-group="gallery" class="fancybox fancybox.ajax" href="/api/getphoto/{{$photo->id}}/html"><img title="{{{ $photo->file_name}}}" class="img-responsive lazy" src="{{{ Storage::getPhoto($photo->file_path, '384x216') }}}" /></a>
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
			
		@endif
		

	</div>
</div>

@stop