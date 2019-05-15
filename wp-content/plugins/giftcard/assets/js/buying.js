jQuery(document).ready( function(){
	 get_ajax_data('gift_purchase');
		$(document.body).on('click','.steps .card',function(){
			get_ajax_data('complete_order');				 
		});
		$(document.body).on('click','#review_checkout',function(){
			get_ajax_data('gift_checkout');
		});
		$(document.body).on('click','#complete_order',function(){
			get_ajax_data('complete_transaction');
		});
});
	  
			

