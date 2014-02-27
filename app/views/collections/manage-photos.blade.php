@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Manage Collection Photos: {{{ $collection->title }}}</h1>
		@include('dashboard.messages')


			

				@if(count($collection->photos) == 0)

					<div class="alert alert-warning col-xs-12">
								This collection doesn't contain any photos.
					</div>
				@else
					<div class="col-xs-12 save-manage text-right">
						<button type="button" class="btn btn-primary disabled"  data-collection-id="{{ $collection->id }}" id="save-order">Save Display Order</button>
					</div>
					<div class="row" id="collections">
						@foreach($collection->photos AS $photo)

							<div id="item-{{ $photo->id }}" class="col-xs-6 col-lg-3 collection-item drag">
								<div class="panel panel-default">
									<div class="panel-body">
										<a href="/{{ $photo->file_path }}">
											<img src="{{ Storage::getPhoto($photo->file_path, '384x216') }}" alt="" class="img-responsive"/>
										</a>
										<div class="btn-group pull-left photo-menu">
										<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i></button>
										
											<ul class="dropdown-menu" role="menu">
												@if($photo->isMine())
													<li><a href="/photos/edit/{{$photo->id}}">Edit Photo</a></li>
													<li><a href="javascript:;" data-url="/photos/delete/{{$photo->id}}" data-id="{{ $photo->id }}" class="confirm-delete">Delete</a></li>
												@endif
												<li><a class="ajax-request" data-remove="#item-{{ $photo->id }}" href="/collections/edit/{{ $collection->id }}/remove/{{$photo->id}}">Remove from collection</a></li>
												
											</ul>
										</div>
										<div class="pull-right photo-meta">

											<span><i class="fa fa-eye" data-toggle="tooltip" title="Total collection views"></i> {{ number_format($photo->views) }}</span>
											<span><i class="fa fa-calendar"></i> {{ Date::make($photo->created_at)->ago() }}</span>
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

