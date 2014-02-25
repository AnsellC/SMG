<!DOCTYPE html>
<html lang="en">
	@include('layout.head')

	<body>	
		
	@if(Request::is('my-uploads'))
		@include('modals.my-upload')
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
    <!-- Javascript
    ================================================== -->
    <script src="/js/jquery.js"></script>
	<script src="/js/html5shiv.js"></script>	
		
  
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="/js/bootstrap-switch.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.min.js"></script>

	@if(Route::is('collections.manage'))
		<script src="/js/jquery-sortable.min.js"></script>
	@endif

	
	<script type="text/javascript">

	$(function(){

		$('[data-toggle="tooltip"]').tooltip();
		$('body').popover({ selector: '[data-toggle="popover"]', trigger: 'hover' });
		$('*[data-loading-text]').click(function () {
    		$(this).button('loading');
		});
		$('[data-toggle="select"]').on('click', function(){

			$(this).select();
		});

		$('[type="checkbox"]').bootstrapSwitch();

		$('.ajax-request').on('click', function(){
			var btn = $(this);
			$.ajax({
				type: 'GET',
				dataType: 'json',
				url: $(this).attr("href"),
				success: function(resp) {
					if(resp.error == null)
					{
						toastr.success(resp.msg);
						if(btn.data("remove"))
							$(btn.data("remove")).fadeOut();
						
					}
					else 
						toastr.error(resp.msg);
				}
			});

			return false;
		});
	});

	</script>

	@if(Route::is('collections.manage'))
		<script type="text/javascript">

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
	@if(Route::is('users.show'))
	<script type="text/javascript">
	

		$(function(){

			$(document).on('click', '#load-photos', function(){

				var btn = $(this);
				btn.text('Please wait...');

				var offset = parseInt($(this).attr('data-offset')) + 9;
				
				var uid = $(this).data('uid');
				$.get('/api/getphotos/'+uid+'/9/'+offset, function(data){
					
					if(data.length > 0)
					{
						$("#photos").append(data);
						btn.attr("data-offset", offset);
						btn.text('Load more...');

					} else {

						btn.remove();
					}

					
					
				});

			});
		});
	</script>
	@endif



	@if(Route::is('photos.show'))
		<script type="text/javascript">
		$(function(){

			$("textarea.comment-txt").keyup(function(e) {
			    while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
			        $(this).height($(this).height()+1);
			    };
			});

			$('textarea.comment-txt').keydown(function(event) {
	   			 if (event.keyCode == 13) {
	        		$(this.form).submit()
	       			return false;
	     		}
     		});


			$(document).on('click','#like-btn', function(){
				$(this).text('Please wait...');
				$.getJSON('/users/addfavorite/'+$(this).data("photo-id"), function(data){

						if(data.msg == "success") {

							$("#like-btn").html('<i class="fa fa-thumbs-down"></i> Unlike').removeClass('btn-success').addClass('btn-danger').removeAttr('id').attr('id', 'unlike-btn');

						}
							
						else {

							$("#like-btn").html('<i class="fa fa-thumbs-up"></i> Like');
						}
					}
				);
			});

			$(document).on('click', '#unlike-btn', function(){
				$(this).text('Please wait...');
				$.getJSON('/users/delfavorite/'+$(this).data("photo-id"), function(data){

						if(data.msg == "success") {
							$("#unlike-btn").html('<i class="fa fa-thumbs-up"></i> Like').removeClass('btn-danger').addClass('btn-success').removeAttr('id').attr('id', 'like-btn');

						}
							
						else {

							$("#unlike-btn").html('<i class="fa fa-thumbs-down"></i> Unlike');
						}
					}
				);
			});

		});
		</script>
	@endif
	@if(Request::is('my-uploads') OR Route::is('collections.manage'))
	{{'
	

		<script type="text/javascript">


		var collection = new Array();



		$(\'*[data-toggle="select-item"]\').on("click", function(){
			var parent = $(this).parent("div").parent("div").parent("div").parent("div");
			var parent_sel = $(this).parent("div").parent("div").parent("div").parent("div").data("chosen");
			var photo_id = parseInt($(this).data("photo-id"));

			console.log(parent_sel);
			if(parent_sel.toString() == "no") {
				
				parent.data("chosen", "yes");
				parent.addClass("chosen");
				$(this).html(\'<i class="fa fa-times"></i>\');
				collection.push(photo_id);
				
			}
			else {
				parent.removeClass("chosen");
				parent.data("chosen", "no");
				$(this).html(\'<i class="fa fa-check"></i>\');
				var indx = collection.indexOf(photo_id);
				if (indx > -1) {
    				collection.splice(indx, 1);
				}

			}
			
		});

			$(".add-collection").on("click", function(){
				if(collection.length == 0)
				{
					$("#error-modal").modal("show");
					$("#error-modal").children("div").children("div").children(".modal-body").text("You dont have any photos selected.");
				} else {

					$("#collection-modal").modal("show");
					$("#photoarray").val(collection.join(","));
				}
			});


			$(".confirm-delete-all").on("click", function(){

				if(collection.length == 0)
				{
					$("#error-modal").modal("show");
					$("#error-modal").children(".modal-body").text("You dont have any photos selected.");
				} else {

					$("#delete-item-modal").data("url", "/photos/groupdelete/"+collection.join(",")).data("from", "all").modal("show");
				}

			});

				$("#delete-confirm").on("click", function(){
					
					var id = $("#delete-item-modal").data("id");
					var m = $("#delete-item-modal").data("from");

					$.ajax({
						url: $("#delete-item-modal").data("url"),
						type: "GET",
						success: function(data){
							if(data.toString() == "success"){
								
								if(m.toString() == "all")
								{
									$(".chosen").hide();
								}	
								else
									$("#photo-item-"+id).fadeOut();

								
							}

						}
					});
					$("#delete-item-modal").modal("hide");
				});
				$(".confirm-delete").on("click", function(e) {
					
				    e.preventDefault();

				    var url = $(this).data("url");
				    var id = $(this).data("id");
				    
				    $("#delete-item-modal").data("url", url).data("id", id).data("from", "single").modal("show");
				});			
		</script>
	'}}
	
	@endif
	@if(Request::is('my-uploads/create'))
	{{'<script src="/js/dropzone.min.js"></script>'}}
	{{'<script type="text/javascript">
		var batch = "'.str_random(20).'";
		
		$(document).ready(function(){

			$("#file-upload").dropzone({
				url: "/my-uploads/store",
				thumbnailWidth: "640",
				thumbnailHeight: "480",
				parallelUploads: 4,
				previewTemplate: \'<div class="col-md-3" style="padding: 5px; background: #fff; margin-bottom: 10px; text-align: center;"><span data-dz-name></span></small><br/><img class="img-responsive" data-dz-thumbnail/><div style="height: 12px;" class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" data-dz-uploadprogress></div></div><div data-dz-errormessage></div></div>\',
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

						var percent = totalBytes + \'%\';
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
		});
		</script>
	'}}
	@endif
	
	</body>
</html>
