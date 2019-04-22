
jQuery(document).ready(function(){ 

   

    jQuery("#addButton").click(function () {
 var counter = jQuery(".TextBox").length+2; 
	if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
	}

	var newTextBoxDiv = jQuery(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);
	newTextBoxDiv.addClass("col-md-12 TextBox");
	newTextBoxDiv.after().html('<label class="col-md-2">Option #'+ counter + ' : </label>' +
	      '<div class="col-md-6"><input type="text" class="form-control" name="wpform_opt_s2[]" id="textbox' + counter + '" value=""></div><input type="button" value="Remove" class="removeButton" onclick="remove('+counter+');">');

	newTextBoxDiv.appendTo("#TextBoxesGroup");


	counter++;
     });

     jQuery(".removeButton").click(function () { //alert(counter);
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }

	counter--;

        jQuery("#TextBoxDiv" + counter).remove();

     });

     jQuery("#getButtonValue").click(function () {

	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + jQuery('#textbox' + i).val();
	}
    	  alert(msg);
     });
  });

function remove(counter){
 //alert(counter);
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }

	

        jQuery("#TextBoxDiv" + counter).remove();counter--;


}
function editLabels(){

	jQuery(".form-layout input").removeAttr("disabled");
}

function changeLayout(val){
	if(val == "1"){
		jQuery(".layout1").show();
		jQuery(".layout2").hide();
		jQuery(".layout3").hide();

	}else if(val == "2"){
		jQuery(".layout2").show();
		jQuery(".layout1").hide();
		jQuery(".layout3").hide();

	}else if(val == "3"){
		jQuery(".layout3").show();
		jQuery(".layout2").hide();
		jQuery(".layout1").hide();
	}
}
