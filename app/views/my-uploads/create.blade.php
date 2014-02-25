@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Upload Photos</h1>
		@include('dashboard.messages')
		<div class="panel">
			<div class="panel-body">
				<div class="alert alert-success">
					<strong>Tip:</strong>
					You can upload multiple photos at the same time by clicking browse > holding the control key + clicking the images you want to upload
					<ul>
						<li>Max file size per file: 5MB</li>
						<li>Max dimensions: 3000px on the longest side.</li>
						<li>Valid files are: JPG, PNG and GIF</li>
					</ul>
				</div>
				<div class="row">
					<div class="col-md-2 col-xs-2 text-center"><button class="btn btn-primary input-block-level" id="file-upload">Select files...</button></div>
					<div class="col-md-8 col-xs-8 text-center"><div class="progress progress-striped" id="main-progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barred" style="width: 0%;"></div></div></div>
					<div class="col-md-2 col-xs-2 text-center"><a href="javascript:;" id="next-step" class="btn btn-primary input-block-level disabled">Continue <i class="icon-arrow-right"></i></a></div>
					
				</div>
				<div id="imgs" class="dropzone-previews">


				</div>
			</div>
		</div>
	</div>

</div>

@stop
