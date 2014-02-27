@extends('layout.default')
@section('content')


<div class="row main-content">

	<div class="col-xs-10 col-xs-offset-1">
		<h1>Contact</h1>
	</div>

	<div class="col-xs-10 col-xs-offset-1">

			@if(Session::has('message'))
				<div class="alert alert-info">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				 	{{Session::get('message')}}
				</div>
			@endif
		<div class="panel panel-default">
			
			<div class="panel-body">
				<p>Use this form to report bugs, give suggestions or feedback about the site.</p>
				{{ Form::open(array('route' => 'contact', 'role' => 'form')) }}
				
				<div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
					{{ Form::label('name', 'Your Name', array('class' => 'form-label')) }}
						{{ Form::text('name', Input::old(''), array('placeholder' => 'full name or alias...', 'class' => 'form-control')) }}
						{{ $errors->first('name', '<span class="help-block">:message</span>') }}
				</div>
				<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
					{{ Form::label('email', 'Email Address', array('class' => 'form-label')) }}
						{{ Form::text('email', Input::old(''), array('placeholder' => 'your email...', 'class' => 'form-control')) }}
						{{ $errors->first('email', '<span class="help-block">:message</span>') }}
				</div>
				<div class="form-group has-feedback {{ $errors->has('message') ? 'has-error' : '' }}">
					{{ Form::label('message', 'Your Message', array('class' => 'form-label')) }}
						{{ Form::textarea('message', Input::old(''), array('placeholder' => 'Your Message...', 'class' => 'form-control')) }}
						{{ $errors->first('message', '<span class="help-block">:message</span>') }}
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" value="Send Message" class="btn btn-primary"/>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div>

	</div>
</div>
	
@stop