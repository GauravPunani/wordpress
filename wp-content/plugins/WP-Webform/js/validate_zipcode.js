jQuery(document).ready(function(){

	jQuery("#next_btn").attr("disabled","disabled"); 

/*	jQuery("#zipcode").bind("keyup paste", function(e){
		var zipcode = this.value;
		var ajaxurl = my_ajax_object.ajax_url ;
		
		var myLength = jQuery(this).val().length;
		//alert(myLength);
		if( myLength < 5){ 

		var data = {
			'action': 'check_zipcode',
			'zipcode': zipcode
		};
		jQuery.post(ajaxurl, data, function(response) {
			//if(response == "" ){

				jQuery(".marker-text").html("Zip Code"); 
				jQuery("#next_btn").removeClass("enable"); 
				jQuery("#next_btn").attr("disabled","disabled"); 
				
			//}
		});
		

		}
		else if( myLength == 5){

		var data = {
			'action': 'check_zipcode',
			'zipcode': zipcode
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {

			if(response){

				var obj = JSON.parse(response); 
				jQuery(".marker-text").html(obj.city+", "+obj.state_code); 
				jQuery("#next_btn").addClass("enable"); 
				jQuery("#next_btn").removeAttr("disabled"); 
				//jQuery("#next_btn").attr("id",""); 
				
			}
else
{
jQuery(".marker-text").html("Enter Valid Zip Code."); 
}
		});
		}else if( myLength > 5){ 

			var data = {
			'action': 'check_zipcode',
			'zipcode': zipcode
		};

			jQuery.post(ajaxurl, data, function(response) {

			//if(response == ""){

				jQuery(".marker-text").html("Enter Valid Zip Code."); 
				jQuery("#next_btn").removeClass("enable"); 
				jQuery("#next_btn").attr("disabled","disabled"); 
				
			//}
		});
		

		}
	});
*/

	/*START 15-07-17 */
/*	jQuery('.enable').click(function(){
alert(12345);
 jQuery('.step1').css('display','none !important');
});
jQuery('#s2_prevbtn').click(function(){
jQuery('.step1').show();
jQuery('.step2').hide();  
});
jQuery('#s2_nxtbtn').click(function(){
jQuery('.step1').hide();
jQuery('.step2').hide();
});
jQuery('.step3 #s2_prevbtn').click(function(){
 jQuery('.step1').hide();
jQuery('.step2').show(); 
 jQuery('.step3').hide();
});
*/

	/*END*/
	jQuery(".next_btn").click(function(){

		if(jQuery(this).hasClass("enable")){ 
			jQuery('.step1').hide();
			jQuery(".step2").show(); 
			//jQuery('html, body').animate({
			//scrollTop: jQuery(".step2").offset().top
		   // }, 2000);
			
		}

	});

	jQuery("#s2_nxtbtn").click(function(){ 
		jQuery('.step1').hide();
		jQuery('.step2').hide();
		jQuery(".step3").show(); 
			//jQuery('html, body').animate({
			//scrollTop: jQuery(".step3").offset().top
		    //}, 2000);
	});


	jQuery("#s2_prevbtn").click(function(){
		jQuery('.step1').show();
		jQuery('.step2').hide();  
			//jQuery('html, body').animate({
			//scrollTop: jQuery(".step1").offset().top
		    //}, 2000);
	});
/*jQuery('.step3 #s2_prevbtn').click(function(){
 jQuery('.step1').hide();
jQuery('.step2').show(); 
 jQuery('.step3').hide();\

}); */

	jQuery("#multistep-webform").submit(function(){
		var firstname = jQuery("#firstname").val();
		if(firstname == ""){ jQuery("#firstname").focus();  return false;}

		var lastname = jQuery("#lastname").val();
		if(lastname == ""){ jQuery("#lastname").focus();  return false;}

		var email = jQuery("#email").val();
		if(email == ""){ jQuery("#email").focus();  return false; }

		var phone = jQuery("#phone").val();
		if(phone == ""){ jQuery("#phone").focus(); return false; }

	});
});
