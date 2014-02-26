

@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>My Collections</h1>
		@include('dashboard.messages')

				@if(count($collections) == 0)
					<div class="alert alert-success">
						<h4>What is a Collection?</h4>
						<p>A collection acts like an album where you can organize your photos into a group. Usually this is used to group up multiple photos of the same project build to show progress of a kit build or just to show a quick SBS assembly, painting and weathering of a project.</p>
						<p>
							It is recommended to create a collection if you want to upload photos of the same kit so it appears more organized.
						</p>
					</div>		
				@else
					<div class="row">

					@foreach($collections AS $collection)

						
						<div class="col-xs-6 col-lg-4" id="item-{{ $collection->id }}">
							<div class="panel panel-default collection-item">
								<div class="panel-body">
									
									<a href="/collections/{{$collection->id}}-{{{Str::slug($collection->title)}}}">
										@if(count($collection->photos) == 0)	

												<img src="http://www.placehold.it/384x216&text=No%20Photos" alt="" class="img-responsive"/>
											@else
												<img src="/uploads/user_assets/{{$collection->photos[0]->file_path}}/384x216.jpg" alt="" class="img-responsive"/>
											@endif
									</a>

									<h5><a href="/collections/{{$collection->id}}-{{{Str::slug($collection->title)}}}">{{{ $collection->title }}}</a></h5>
									<div class="btn-group pull-left">
									<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i></button>
									
										<ul class="dropdown-menu" role="menu">
											<li><a href="/collections/{{ $collection->id }}/manage">Manage Photos</a></li>
											<li><a href="/collections/edit/{{$collection->id}}">Edit</a></li>
											<li><a href="javascript:;" data-url="/collections/delete/{{$collection->id}}" data-id="{{ $collection->id }}" class="confirm-delete">Delete</a></li>
										</ul>
									</div>
									<div class="pull-right collection-stats">
										<span data-toggle="tooltip" title="Photos inside this collection"><i class="fa fa-picture-o"></i> {{ number_format(count($collection->photos))}}</span>
										<span><i class="fa fa-eye" data-toggle="tooltip" title="Total collection views"></i> {{ number_format($collection->views) }}</span>
										<span><i class="fa fa-calendar"></i> {{ Date::make($collection->created_at)->ago() }}</span>
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