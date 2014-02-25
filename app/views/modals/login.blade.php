<!-- Start modal -->
	<div id="loginbox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="loginlabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 id="loginlabel">Login</h4>
		</div>
		<div class="alert alert-danger hidden" style="margin: 10px;" id="login_msg">
		</div>
		{{ Form::open(array('route' => 'login','class' => 'form-horizontal marginbot-clear', 'id' => 'login_form')) }}
			<div class="modal-body">
				<div class="control-group margintop30">
					{{ Form::label('email', 'E-Mail', array('class' => 'control-label')) }}
					<div class="controls">
						{{Form::email('email', '', array('placeholder' => 'Your email address...'))}}
					</div>
				</div>
				<div class="control-group">
					{{ Form::label('password', 'Password:', array('class' => 'control-label')) }}
					<div class="controls">
						{{Form::password('password')}}
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="remember" value="1"> Remember me
						</label>
						{{HTML::link('forgotpass', 'Forgot password?')}}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
				{{ Form::submit('Login', array('class'=>'btn btn-primary')) }}
			</div>
		{{ Form::close() }}	
	</div>
	<!-- End modal -->		