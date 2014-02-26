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

