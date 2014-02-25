@extends('layout.default')
@section('content')
	<!-- Start page header -->
	<section id="page-header">
		<div class="container">
		  <div class="row">
			<div class="span12">
				<h3>Thanks for registering!</h3>
			
			</div>
		  </div>
		</div>
	</section>
	<!-- End page header  -->
	
	<!-- Start contain -->
	<section id="contain">
		<div class="container">
		  <div class="row">
			<div class="span12">
				<p>
				Thanks for signing up! Please check your e-mail shortly. We sent a confirmation link, please click that link to validate your account. You will need to validate your account before you could start uploading photos.
				</p> 
				<p>Meanwhile, you can {{ HTML::link('browse') }}
			</div>
		  </div>
		</div>
	</section>
	<!-- End contain -->
@stop