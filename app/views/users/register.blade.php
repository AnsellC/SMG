@extends('layout.default')
@section('content')



	<div class="row">

		<div class="col-md-6 col-md-offset-3 panel panel-default">
			<div class="panel-body">
				<h1>Sign up</h1>
				{{ Form::open(array('route' => 'user.add')) }}

					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
						{{ Form::label('email', 'E-Mail Address', array('class' => 'control-label', 'role' => 'form')) }}
						<div class="controls">
							{{ Form::email('email', Input::old('email'), array('placeholder' => 'Your E-Mail Address...', 'class' => 'form-control')) }}
							{{ $errors->first('email', '<span class="help-block">:message</span>') }}
						</div>
					</div>

					<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
						{{ Form::label('username', 'Username', array('class' => 'control-label')) }}
						<div class="controls">
							{{ Form::text('username', Input::old(''), array('placeholder' => 'Username...', 'class' => 'form-control')) }}
							{{ $errors->first('username', '<span class="help-block">:message</span>') }}
						</div>
					</div>

					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						{{ Form::label('password', 'Password', array('class' => 'control-label')) }}
						<div class="controls">
							{{ Form::password('password', array('class' => 'form-control')) }}
							{{ $errors->first('password', '<span class="help-block">:message</span>') }}
						</div>
					</div>

					<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
						{{ Form::label('password_confirmation', 'Confirm Password', array('class' => 'control-label')) }}
						<div class="controls">
							{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
							{{ $errors->first('password_confirmation', '<span class="help-block">:message</span>') }}
						</div>
					</div>
					<div class="form-group">
					
						{{ Form::submit('Register', array('class'=>'btn btn-large btn-primary')) }}
				
					</div>	
				{{ Form::close() }}	
			</div>
		</div>

	</div>
@stop
