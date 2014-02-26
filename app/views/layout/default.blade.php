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

	@if(Request::is('my-collections'))
		@include('modals.delete-item')
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="/js/html5shiv.js"></script>	
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="/js/bootstrap-switch.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.min.js"></script>
	<script src="/js/site.js"></script>
	<!--#### END REQUIRED JAVASCRIPT #### -->

	{{-- LIGHTBOX GALLERY --}}
	@if(Route::is('collections.show'))
		<script src="/js/jquery.fancybox.pack.js"></script>
	@endif



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
			
			$("#file-upload").dropzone({
				url: "/my-uploads/store",
				thumbnailWidth: "640",
				thumbnailHeight: "480",
				parallelUploads: 4,
				previewTemplate: '<div class="col-md-3" style="padding: 5px; background: #fff; margin-bottom: 10px; text-align: center;"><span data-dz-name></span></small><br/><img class="img-responsive" data-dz-thumbnail/><div style="height: 12px;" class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" data-dz-uploadprogress></div></div><div data-dz-errormessage></div></div>',
				previewsContainer: "div#imgs",
				addRemoveLinks: true,
				acceptedFiles: "image/*",
				init: function() {

					this.on("removedfile", function(file){
						$.ajax({
							url: "/my-uploads/destroy/"+file.name+"/"+batch,
							type: "DELETE"
						});
					});

					this.on("totaluploadprogress", function(totalBytes, totalBytesSent){

						var percent = totalBytes + '%';
						$("#barred").width(percent);

						if(totalBytes == 100) {

							$("#next-step").removeClass("disabled");
							$("#main-progress").removeClass("active");
							$("#next-step").attr("href", "/my-uploads/process/"+batch);
						}
					});

					this.on("sending", function(file, xhr, formData){
						formData.append("batch", batch);
					});
				}
			})
		</script>

	@endif

	{{-- CUSTOM JS --}}
	<script src="/js/custom.js"></script>

	</body>
</html>
