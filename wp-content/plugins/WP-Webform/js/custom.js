$(document).ready(function(){
	$("#wpForm").submit(function(){
		$(".wpform-error").hide();
		var username = $("#username").val(); 
		var start_date = $(".start_date").val(); 
		var start_time = $("#start_time").val(); 
		var end_time = $("#end_time").val(); 
		var freq_per_day = $("#freq_per_day").val(); 
		var freq_per_week = $("#freq_per_week").val(); 
		if(username == ""){
			$("#username").parent().append("<span class='wpform-error'>Please select username.<span>");
			return false;
		}
		if(start_date == ""){
			$(".start_date").parent().append("<span class='wpform-error'>Please enter start date.<span>");
			return false;
		}
		if(start_time == ""){
			$("#start_time").parent().append("<span class='wpform-error'>Please select start time.<span>");
			return false;
		}
		if(end_time == ""){
			$("#end_time").parent().append("<span class='wpform-error'>Please select end time.<span>");
			return false;
		}
		if(freq_per_day == ""){
			$("#end_time").parent().append("<span class='wpform-error'>Please select frequency per day.<span>");
			return false;
		}
		if(freq_per_week == ""){
			$("#end_time").parent().append("<span class='wpform-error'>Please select frequency per week.<span>");
			return false;
		}

	});

	$('input#uploadcsvfile').change(function(){
		    $(".file-txt").remove();
		    var files = $(this)[0].files;
		    $('.custom-file-upload').after('<div class="file-txt" style="display: inline; padding: 0px 10px;">'+files.length +' files selected.</div>');
	});

});

  $( function() {
    $( "#datepicker" ).datepicker();
	$('input.timepicker').timepicker({ timeFormat: 'HH:00' });
  } );
function createUploadBtn(val){
$(".input-group").html('');
for (i = 2; i <= val; i++) {

$(".input-group").append('<label>Select files to upload (Day '+i+') :</label><div class="custom-file-upload"><i class="fa fa-cloud-upload"></i><span>Upload Image</span><input id="uploadcsvfile" name="files[]" type="file" class="upload" ></div>');
} 


}

