@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Upload Photos: Step 2</h1>
		@include('dashboard.messages')
		<div class="panel">
			<div class="panel-body">
				@include('dashboard.messages')

				<div class="alert alert-success">
					The photos has been successfully uploaded. You may now edit each photo's title, description and privacy settings. 
				</div>
				{{Form::open(array('route' => 'my-uploads/process'))}}
				<input type="hidden" name="process_group" value="{{$process_group}}"/>
				<p style="text-align: right;">
				<input type="submit" value="Done Editing" class="btn btn-primary"/>
				</p>
				<div class="row">
					<?php $ctr = 1;?>
				@foreach($photos AS $photo)
					
					
				
					<div class="col-md-4 col-xs-6 img-box">
						<input type="hidden" name="id[]"  value="{{$photo->id}}" />
						{{Form::text('file_name_'. $photo->id, $photo->file_name, array('class' => 'form-control'))}}
						
							<div class="holder"><img src="/uploads/user_assets/{{$photo->file_path}}/original.jpg" class="img-responsive"/></div>
							<div class="form-inline form-switches">
								<label for="allow_collect-{{$ctr}}" data-toggle="tooltip" data-title="Setting this to YES will enable other users to add this photo to their collection">Can be collected</label>
								<input type="checkbox" id="allow_collect-{{$ctr}}" name="allow_collect_{{ $photo->id }}" value="1" checked="checked" />
							</div>
							<div class="form-inline form-switches">
								<label for="private-{{$ctr}}" data-toggle="tooltip" data-title="Setting this photo to private will block everyone (excluding you) from accessing it">Private</label>
								<input type="checkbox" data-on-text="Yes" data-off-text="No" id="private-{{$ctr}}" name="private_{{ $photo->id }}" value="1" />
							</div>							
						<textarea name="description_{{$photo->id}}" placeholder="A short description..." class="form-control">{{$photo->description}}</textarea>
					</div>
					@if($ctr%3 == 0)
						<div style="clear:both;"></div>
					@endif
					<?php $ctr++; ?>
				@endforeach
				
				</div>
				{{Form::close()}}
				
			</div>
		</div>
	</div>

</div>

@stop