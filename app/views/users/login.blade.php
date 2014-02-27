@extends('layout.default')
@section('content')

	<div class="row">

		<div class="col-md-4 col-md-offset-4 panel panel-default">
			<div class="panel-body">
				<h1>Login to your account</h1>


				@if(Session::has('msg'))
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ Session::get('msg') }}
					</div>
				@endif
				{{ Form::open(array('route' => 'login')) }}

					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
						{{ Form::label('email', 'E-Mail Address', array('class' => 'control-label', 'role' => 'form')) }}
						<div class="controls">
							{{ Form::email('email', Input::old('email'), array('placeholder' => 'Your E-Mail Address...', 'class' => 'form-control')) }}
							{{ $errors->first('email', '<span class="help-block">:message</span>') }}
						</div>
					</div>

					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						{{ Form::label('password', 'Password', array('class' => 'control-label')) }}
						<div class="controls">
							{{ Form::password('password', array('class' => 'form-control')) }}
							{{ $errors->first('password', '<span class="help-block">:message</span>') }}
						</div>
					</div>
					<div class="form-group">
					
						{{ Form::submit('Login', array('class'=>'btn btn-large btn-primary')) }}
				
					</div>	
				{{ Form::close() }}	
			</div>
		</div>

	</div>
@stop
