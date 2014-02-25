	@if(Session::has('message'))
				<div class="alert alert-info marginbot35">
				  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  <strong>Success!</strong><br />
				 	{{Session::get('message')}}
				</div>
				@endif
				@if($errors->any())
				  <div class="alert alert-danger marginbot35">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error:</strong><br />
					<ul>
					{{ implode('', $errors->all('<li>:message</li>'))}}
					</ul>
					</div>
				@endif
