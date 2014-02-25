@extends('layout.default')
@section('content')
@include('users.profile-header')
<div class="row main-content profile">

	<div class="col-xs-12 col-md-8 col-md-offset-2">
		<h2>Collections</h2>
	</div> 
	<div class="col-md-8 col-md-offset-2 col-xs-12">
		@if(count($collections) == 0)
	
			<div class="alert alert-warning">
				This user doesn't have any collections.
			</div>
		@else
			
			<div class="row">
				@foreach($collections AS $collection)
				<div class="col-xs-6 col-lg-4">
					<div class="panel panel-default">
						<div class="panel-body">
							<a href="/collections/{{$collection->id}}-{{{Str::slug($collection->title)}}}">
								@if(count($collection->photos) == 0)	

										<img src="http://www.placehold.it/384x216&text=No%20Photos" alt="" class="img-responsive"/>
									@else
										<img src="/uploads/user_assets/{{$collection->photos[0]->file_path}}/384x216.jpg" alt="" class="img-responsive"/>
									@endif
							</a>

							<h4><a href="/collections/{{$collection->id}}-{{{Str::slug($collection->title)}}}">{{{ $collection->title }}}</a></h4>
							<p class="text-right collection-stats">
								<span data-toggle="tooltip" title="Photos inside this collection"><i class="fa fa-picture-o"></i> {{ number_format(count($collection->photos))}}</span>
								<span><i class="fa fa-eye" data-toggle="tooltip" title="Total collection views"></i> {{ number_format($collection->views) }}</span>
								<span><i class="fa fa-calendar"></i> {{ Date::make($collection->created_at)->ago() }}</span>
							</p>
						</div>
					</div>
				</div>
					 
				@endforeach
				
			</div>
		@endif
		


	</div>
</div>

@stop