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

		var collection = new Array();



		$('*[data-toggle="select-item"]').on("click", function(){
			var parent = $(this).parent("div").parent("div").parent("div").parent("div");
			var parent_sel = $(this).parent("div").parent("div").parent("div").parent("div").data("chosen");
			var photo_id = parseInt($(this).data("photo-id"));

			console.log(parent_sel);
			if(parent_sel.toString() == "no") {
				
				parent.data("chosen", "yes");
				parent.addClass("chosen");
				$(this).html('<i class="fa fa-times"></i>');
				collection.push(photo_id);
				
			}
			else {
				parent.removeClass("chosen");
				parent.data("chosen", "no");
				$(this).html('<i class="fa fa-check"></i>');
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


$(document).ready(function(){

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
		});