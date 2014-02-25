@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>E-mail and password</h1>

		<div class="panel">
			<div class="panel-body">
			@include('dashboard.messages')

				<h4>Change E-Mail Address</h4>
				
				{{Form::model(Auth::user(), array('route' => array('users.update', Auth::user()->id), 'method' => 'put'))}}
				<input type="hidden" name="m" value="edit-email-pass" />
				
				<div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
					{{ Form::label('email', 'E-mail Address', array('class' => 'form-label')) }}
						{{ Form::text('email', Input::old(''), array('placeholder' => 'E-mail Address...', 'class' => 'form-control')) }}
						{{ $errors->first('email', '<span class="help-block">:message</span>') }}
						<small>You would need to validate this e-mail address if changed and lose all upload capabilities until you validate it.</small>
				</div>
				<div class="form-group">
						 {{Form::submit('Change E-Mail', array('class' => 'btn btn-primary'))}}
				</div>				
				{{Form::close()}}	

				<h4>Change Password</h4>
				{{ Form::open(array('route' => 'users.changepass', 'method' => 'put')) }}
				
				<div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
					{{ Form::label('current_password', 'Current Password', array('class' => 'form-label')) }}
						{{ Form::password('current_password', array('class' => 'form-control')) }}
						{{ $errors->first('current_password', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
					{{ Form::label('password', 'New Password', array('class' => 'form-label')) }}
						{{ Form::password('password', array('class' => 'form-control')) }}
						{{ $errors->first('password', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
					{{ Form::label('password_confirmation', 'Confirm New Password', array('class' => 'form-label')) }}
						{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
						{{ $errors->first('password_confirmation', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group">

						 {{Form::submit('Change Password', array('class' => 'btn btn-primary'))}}
				</div>				
				{{Form::close()}}								

				<h4>E-Mail Notifications</h4>
				
				{{Form::model(Auth::user(), array('route' => array('users.update', Auth::user()->id), 'method' => 'put'))}}
				<input type="hidden" name="m" value="change-email-settings" />
				
				<div class="form-group">
						<span class="form-inline">{{Form::label('email_notification_comment', 'E-Mail me when a photo I\'ve uploaded receives a comment.')}} {{Form::checkbox('email_notification_comment', '1')}}
				</div>	
				<div class="form-group">
						<span class="form-inline">{{Form::label('email_notification_like', 'E-Mail me when a photo I\'ve uploaded receives a like.')}} {{Form::checkbox('email_notification_like', '1')}}
						
				</div>
				<div class="form-group">
						<span class="form-inline">{{Form::label('email_notification_pm', 'E-Mail me I receive a private message')}} {{Form::checkbox('email_notification_pm', '1')}}
						
				</div>
				<div class="form-group">
						 {{Form::submit('Save Notification Settings', array('class' => 'btn btn-primary'))}}
				</div>				
				{{Form::close()}}					
			</div>
		</div>
	</div>

</div>

@stop

