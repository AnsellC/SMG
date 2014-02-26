@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<div class="row">
			<div class="col-md-6 col-xs-6"><h1>My Uploads</h1></div>
			<div class="col-md-6 col-xs-6 text-right page-controls-header">
				<div class="btn-group">
					<button class="btn btn-danger" data-toggle="dropdown">With selected <span class="caret"></span> </button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#" class="add-collection">Add to collection...</a></li>
						<li><a href="#" class="confirm-delete-all">Mass delete</a></li>
					</ul>
				</div>
			</div>
		
		</div>
		@include('dashboard.messages')

				@if(count($photos) == 0)
					<div class="alert alert-warning">

						You haven't uploaded any photos yet. Start <a href="/my-uploads/create">Uploading now!</a>
					</div>		
				@else

				<div class="col-md-12" style="margin-bottom: 50px;">
					<div class="row">
					@foreach($photos AS $photo)
 
					<div class="col-xs-6 col-lg-4" id="item-{{ $photo->id }}" data-chosen="no">
						<div class="panel panel-default">
							<div class="panel-body photo-items">
										
								<a href="/{{{ $photo->file_path }}}"><img title="{{{ $photo->file_name}}}" class="img-responsive lazy" src="{{{ Storage::getPhoto($photo->file_path, '384x216') }}}" /></a>
								
								<div class="btn-group pull-left photo-menu">
									<button type="button" class="btn btn-default btn-sm" data-toggle="select-item" data-photo-id="{{ $photo->id }}"><i class="fa fa-check"></i></button>
									<div class="btn-group">
									<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i></button>
									
										<ul class="dropdown-menu" role="menu">
											<li><a href="/photos/edit/{{$photo->id}}">Edit</a></li>
											<li><a href="javascript:;" data-url="/photos/delete/{{$photo->id}}" data-id="{{ $photo->id }}" class="confirm-delete">Delete</a></li>
										</ul>
									</div>
								</div>
	

									<div class="photo-meta pull-right" style="margin-top: 8px;">
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

</div>

@stop
