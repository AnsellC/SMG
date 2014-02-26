<head>
		<meta charset="utf-8">
		<title>18augst gallery insporation template</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
	
		{{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css') }}
		{{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css') }}
		{{ HTML::style('/css/smg.css?=' . time())}}
		{{ HTML::style('/css/bootstrap-switch.min.css') }}
		{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.min.css') }}
		
		@if(Route::is('collections.show'))
			{{ HTML::style('/css/jquery.fancybox.css') }}
		@endif		
		<!-- Font -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,700,300' rel='stylesheet' type='text/css'>
	
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="/ico/favicon.png">
	</head>