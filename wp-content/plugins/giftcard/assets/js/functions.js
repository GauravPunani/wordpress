function get_ajax_data(action_name){
		console.log(ajaxurl);
		$.ajax({
			url: ajaxurl,
			//~ url: "<?= plugins_url('completePurchase.php',__FILE__); ?>",
			type: 'POST',
			data:{ 
				action: action_name, // this is the function in your functions.php that will be triggered
			},
			beforeSend:function(){
					show_loader();
				},
			success: function( data ){
				hide_loader();
				//Do something with the result from server
				$('#mainbody').hide().html(data).fadeIn();
				console.log(data);
			}
	  });
	
}

function show_loader(){
	$('#loader_header').show();
	$('#loader_form').addClass('loader_form');
}

function hide_loader(){
	$('#loader_header').hide();
	$('#loader_form').removeClass('loader_form');		
}
