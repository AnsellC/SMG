@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Create a Collection</h1>
		@include('dashboard.messages')
		<div class="panel">
			<div class="panel-body">
				{{Form::open(array('route' => 'my-collections/store', 'method' => 'post'))}}

				<div class="form-group has-feedback {{ $errors->has('title') ? 'has-error' : '' }}">
					{{ Form::label('title', 'Title', array('class' => 'form-label')) }}
						{{ Form::text('title', Input::old('title'), array('placeholder' => 'Collection title...', 'class' => 'form-control')) }}
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
					{{ Form::label('description', 'Description', array('class' => 'form-label')) }}
						{{ Form::textarea('description', Input::old(''), array('rows' => '3', 'placeholder' => 'Enter a description...', 'class' => 'form-control')) }}
						{{ $errors->first('description', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group">
					
						<input type="submit" value="Create Collection" class="btn btn-primary"/>
				
				</div>
				
				{{Form::close()}}		
			</div>
		</div>
	</div>

</div>

@stop