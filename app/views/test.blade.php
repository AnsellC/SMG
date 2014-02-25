
	{{ Form::open(array('route' => 'my-uploads/store',  'files' => true)) }}
	
	{{ Form::file('file') }}
	{{ Form::submit('gogo') }}
	
	{{ Form::close() }}