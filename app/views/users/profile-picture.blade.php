@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Profile Picture</h1>
		@include('dashboard.messages')
				<div class="alert alert-warning">
					<ul>
						<li>Accepted file types: JPG, PNG, GIF</li>
						<li>Maximum Dimensions: 1920px on the longest side</li>
						<li>Maximum File Size: 5MB</li>
					</ul>
					<strong>Upload process may take a while depending on your connection speed.</strong>
				</div>		

		<div class="panel">
			<div class="panel-body">
				
				{{Form::open(array('route' => 'account.saveProfilePicture', 'method' => 'post', 'files' => true))}}
				<div class="form-group">
					{{Form::label('profile_photo', 'Upload a Profile Photo')}}
					{{Form::file('profile_photo', array('class' => 'form-control'))}}
				</div>
				<div class="form-group">
					{{Form::submit('Upload Photo', array('class' => 'btn btn-primary'))}}
				</div>
				{{Form::close()}}
				
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
				@if(!Auth::user()->getProfilePic())

					<img src="http://www.placehold.it/500x300&text=No%20Photo" alt="" class="img-responsive"/>
				@else
					<img src="{{Auth::user()->getProfilePic()}}" alt="" class="img-responsive"/>

				@endif	
					</div>
				</div>				
			</div>
		</div>
	</div>

</div>

@stop
