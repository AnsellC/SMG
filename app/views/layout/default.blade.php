<!DOCTYPE html>
<html lang="en">
	@include('layout.head')
	<body>	
		

	@if(Request::is('my-uploads'))
		@include('modals.my-upload')
		@include('modals.error')
		@include('modals.delete-item')
	@endif

	@if(Route::is('collections.manage'))
		@include('modals.manage-photos')
	@endif


	@if(Route::is('photos.show'))
		@include('modals.show-photo')
	@endif

	<div class="container-fluid" id="wrap">

	@include('layout.nav1')



	@yield('content')
	</div>
	@include('layout.footer')
	
	<script type="text/javascript">
	//<![CDATA[
		var browser			= navigator.userAgent;
		var browserRegex	= /(Android|BlackBerry|IEMobile|Nokia|iP(ad|hone|od)|Opera M(obi|ini))/;
		var isMobile		= false;
		if(browser.match(browserRegex)) {
			isMobile			= true;
			addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
			function hideURLbar(){
				window.scrollTo(0,1);
			}
		}


	//]]>
	</script>		
	<!--#### REQUIRED JAVASCRIPT #### -->
    <script src="/js/jquery.js"></script>
	<script src="/js/html5shiv.js"></script>	
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="/js/bootstrap-switch.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.min.js"></script>
	<script src="/js/site.js"></script>
	<!--#### END REQUIRED JAVASCRIPT #### -->

	{{-- MANAGE COLLECTIONS JS --}}
	@if(Route::is('collections.manage'))
		<script src="/js/jquery-sortable.min.js"></script>
		<script>

			$("#collections").sortable({
				cursor: "move",
				items: ".collection-item",
				opacity: 0.5,
				tolerance: "pointer",
				cursorAt: {
					top: 100,
					left: 100
				},
				update: function(){
					$("#save-order").removeClass("disabled");
				}
			});

			$("#save-order").on("click", function(){
				$(this).addClass("disabled");
				$(this).text('Saving...');

				var data = $("#collections").sortable('serialize');
				 $.ajax({
			            data: data,
			            type: 'POST',
			            url: '/collections/'+$(this).data('collection-id')+'/saveorder',
			            success: function(resp){
			            	toastr.success(resp);
			            	$("#save-order").text('Save Display Order').removeClass("disabled");
			            }
			     });
			});
		</script>
	@endif

	@if(Request::is('my-uploads/create'))
		<script src="/js/dropzone.min.js"></script>
		<script type="text/javascript">
			var batch = "{{ str_random(20) }}";
		</script>

	@endif

	{{-- CUSTOM JS --}}
	<script src="/js/custom.js"></script>

	</body>
</html>
