<script type="text/javascript">
	var arr_data=new Array();
	function remove_meta(module_name,key,elem,post_id){
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

		$.ajax({
				type:"post",
				// dataType: 'json', 	
				url:ajaxurl,
				data:{
					action:'remove_content_11_meta',
					module_name:module_name,
					key:key,
					post_id:post_id
				},
				beforeSend:function(){
					// elem.text('Removing....');
				},
				success:function(data){
					console.log('success');
					console.log(data);
					if(module_name=='amazon')
						$(elem).parent().parent().parent().remove();
					else
						$(elem).parent().parent().remove();
				},
				error:function (jqXHR, textStatus, errorThrown){
					console.log('error');	
				}

		});

}

	$(document).on('click', '.copy_div' , function(e) {
		// console.log(cloned);return;
		<?php global $post; ?>
     			// alert('called');
		// console.log($(this).wrap('</p>').parent().html());
		// console.log($(this).attr('id'));
		var contex=$(this);
			//first get the id of the div and then split to get api name and real if of elem
		var content_id=$(this).attr('id');
		var temp=content_id.split('_');
		//module name to save in php array key
		var api_name=temp[0];
		// console.log(temp);
		// console.log(api_name);return;
		
		// module key name for sub array in php
		var item_key=temp[1];
		//data to store into the database is 
		var data_to_store=arr_data[api_name][item_key];

		// console.log(data_to_store);return;
		// var data=$(this).wrap('</p>').parent().html();
		// $(this).unwrap();
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		var post_id=<?php echo $post->ID; ?>;
		$.ajax({
				type:"post",
				// dataType: 'json', 	
				url:ajaxurl,
				data:{
					action:'content_egg_11_meta',
					api_name:api_name,
					item_key:item_key,
					data_to_store:data_to_store,
					post_id:post_id
				},
				beforeSend:function(){
					console.log('in call');
				},
				success:function(e){
					console.log('success');
					console.log(e);
					contex.css("opacity", "0.5");
					//removing the copy div class to not perform the same action
					contex.removeClass("copy_div");
					$('#menu1_'+api_name).append(e);
					
				},
				error:function (jqXHR, textStatus, errorThrown){
					console.log('error');	
				}

		});


		//get the data array from php


});
	function fetch_data(){
		<?php global $options; ?>
		var options=<?php echo json_encode($options); ?>;
		var query=$('#content_egg_11_query').val();

		// console.log(options);
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		$.ajax({
				type:"post",
				dataType: 'json', 	
				url:ajaxurl,
				data:{
					action:'get_all_api',
					opt:options,
					query:query
				},
				beforeSend:function(){
					$.each(options,function(key,val){
						// console.log(key);
						var url="<?=  PLUGIN_BASE_URL; ?>";
							url+='assets/gif/loader.gif';
						// console.log(gif);
						$('#'+key+"_data").html('<img  src="'+url+'"" alt="#">');
					});
				},
				success:function(data){
					// var temp=$.parseJSON(data);
						arr_data=data.arr;
						$.each(data.api,function(key,val){
							$('#'+key).html(val);
						});
				},
				error:function (jqXHR, textStatus, errorThrown){
						console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
				}

		});
}


function single_search(module_name,search_id) {
	
				var query=$('#'+search_id).val();
				console.log(module_name);
				console.log(query);
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	$.ajax({
				type:"post",
				dataType: 'json', 	
				url:ajaxurl,
				data:{
					action:'get_single_api',
					module_name:module_name,
					query:query
				},
				beforeSend:function(){
					var url="<?=  PLUGIN_BASE_URL; ?>";
							url+='assets/gif/loader.gif';
						$('#'+module_name+'_data').html('<img  src="'+url+'"" alt="#">');
				},
				success:function(data){
					console.log(data.arr[module_name]);
					arr_data[module_name]=data.arr[module_name];
					console.log(arr_data);
						console.log(data.api);
						$.each(data.api,function(key,val){
							$('#'+module_name+'_data').html(val);
						});

					// // var temp=$.parseJSON(data);
					// 	arr_data=data.arr;
					// 	$.each(data.api,function(key,val){
					// 		$('#'+key).html(val);
					// 	});
				},
				error:function (jqXHR, textStatus, errorThrown){
				console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
				}

		});
	$('#all_search').submit(function(e){
		e.preventDefault();
		fetch_data();
	});
}



function get_more(module_name,pageoffset,query,elem){
		
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		$.ajax({
				type:"post",
				dataType: 'json', 	
				url:ajaxurl,
				data:{
					action:'get_more_data',
					module_name:module_name,
					pageoffset:pageoffset,
					query:query
				},
				beforeSend:function(){
					var url="<?=  PLUGIN_BASE_URL; ?>";
							url+='assets/gif/loader.gif';
						$('#'+module_name+'_load').html('<img  src="'+url+'"" alt="#">');
					
				},
				success:function(data){
					$('#'+module_name+'_load').remove();
					console.log(data.arr[module_name]);
					//~ arr_data[module_name] =data.arr[module_name];
					$.each(data.arr[module_name],function(key,val){
						
							arr_data[module_name][key]=val;
						
						});
					$.each(data.api,function(key,val){
							$('#'+module_name+'_data').append(val);
						});
				},
				error:function (jqXHR, textStatus, errorThrown){
						console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
				}

		});
	}

</script>
