@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Edit Collection</h1>
		@include('dashboard.messages')


				
				<div class="panel panel-default">
					<div class="panel-body">

						{{ Form::model($collection, array('route' => array('collections.edit', $collection->id), 'role' => 'form')) }}
						
						<div class="form-group has-feedback {{ $errors->has('title') ? 'has-error' : '' }}">
							{{ Form::label('title', 'Collection title', array('class' => 'form-label')) }}
								{{ Form::text('title', $collection->title, array('placeholder' => 'Collection title...', 'class' => 'form-control')) }}
								{{ $errors->first('title', '<span class="help-block">:message</span>') }}
						</div>

					<div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
							{{ Form::label('description', 'Description', array('class' => 'form-label')) }}
							{{ Form::textarea('description', $collection->description, array('placeholder' => 'Description...', 'class' => 'form-control')) }}
							{{ $errors->first('description', '<span class="help-block">:message</span>') }}
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