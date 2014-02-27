@extends('layout.default')
@section('content')
<!-- Start page header -->
	<section id="page-header">
		<div class="container">
		  <div class="row">
			<div class="span12">
				<h3>Resend Activation E-Mail</h3>
			</div>
		  </div>
		</div>
	</section>
	<!-- End page header  -->
<section id="contain">
		<div class="container">
		  <div class="row">
			@include('dashboard.sidebar')
			<div class="span9">		

			@include('dashboard.messages')
			
				<p>An e-mail containing an activation link will be sent to <strong>{{Auth::user()->email}}</strong>. It may take a while for the email to arrive and also check your spam/trash folder.</p>
				<a href="/account/resend-activation-now" class="btn btn-primary">Re-send Activation E-Mail Now</a>		
			</div>
		  </div>
		</div>
	</section>

@stop