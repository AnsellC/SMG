@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Edit Photo</h1>
		@include('dashboard.messages')
		<div class="panel">
			<div class="panel-body">
				{{ Form::model($photo, array('route' => array('photos/update', $photo->id), 'method' => 'PATCH' )) }}
					<div class="form-group {{ $errors->has('file_name') ? 'error' : '' }}">
						{{ Form::label('file_name', 'Name:', array('class' => 'control-label')) }}
						<div class="controls">
							{{ Form::text('file_name', $photo->file_name, array('placeholder' => 'Name...','class' => 'form-control')) }}
							{{ $errors->first('file_name', '<span class="help-block">:message</span>') }}
						</div>
					</div>
					<img src="{{{ Storage::getPhoto($photo->file_path) }}}" alt="" class="img-responsive" />
					<div class="form-group">
						<div class="controls">
							<span class="form-inline">
							 {{ Form::label('allow_collect', 'Allow other users to add this photo on their collection?') }} {{ Form::checkbox('allow_collect', '1') }}
							
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="controls">
							<span class="form-inline">
							 {{ Form::label('private', 'Private photo') }} {{ Form::checkbox('private', '1') }}
							
							</span>
						</div>
					</div>					
					<div class="form-group {{ $errors->has('description') ? 'error' : '' }}">
						{{ Form::label('description', 'Description:', array('class' => 'control-label')) }}
						<div class="controls">
							{{ Form::textarea('description', $photo->description, array('rows' => '3', 'placeholder' => 'Description...', 'class' => 'form-control')) }}
							{{ $errors->first('description', '<span class="help-block">:message</span>') }}
						</div>
					</div>
					<div class="form-group">
						<div class="controls">
							<input type="submit" value="Save Changes" class="btn btn-primary"/>
						</div>
					</div>
				{{ Form::close() }}	
			</div>
		</div>
	</div>

</div>

@stop
