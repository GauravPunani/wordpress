jQuery(document).ready( function(){
		get_ajax_data('gift_exchange_home');
		$(document.body).on('click','#gift_exhange_page',function(){
			get_ajax_data('gift_exhange_page');
		});
		$(document.body).on('click','#exchange_review_checkout',function(){
			get_ajax_data('exchange_review_checkout');
		});
		//search_steam
		$(document.body).on('keyup','#search_steam',function(){
				if($('#search_steam').val().length>0)
					$('#group_list_add').show();	
				else
					$('#group_list_add').hide();
		});
});
