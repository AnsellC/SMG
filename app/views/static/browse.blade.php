@extends('layout.default')
@section('content')


<div class="row main-content">

	<div class="col-xs-4 col-xs-offset-1">
		<h1>Browse</h1>
	</div>
	<div class="col-xs-6 text-right">
		{{ $photos->links() }}
	</div>

	<div class="col-xs-10 col-xs-offset-1">
		

		<div class="row">
	
			@foreach($photos AS $photo)
				
				<div class="col-xs-6 col-md-3">

					
					<div class="panel panel-default">
						<div class="panel-body">
							
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
		

	</div>
	<div class="col-xs-12 text-center">
		{{ $photos->links() }}
	</div>
</div>
	
@stop