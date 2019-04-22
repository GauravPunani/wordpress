<?php
/**
* Plugin Name: WP-Webform
* Plugin URI: http://mypluginuri.com/
* Description: Zip code web form plugin.
* Version: 1.0 or whatever version of the plugin (pretty self explanatory)
* Author: Plugin Author's Name
* Author URI: Author's website
* License: A "Slug" license name e.g. GPL12
*/

register_activation_hook( __FILE__, 'install' );
register_deactivation_hook( __FILE__, 'uninstall' );

add_action('admin_menu', 'wpform_setup_menu');

function wpform_setup_menu(){
        add_menu_page( 'WP Webform', 'WP Webform', 'manage_options', 'wp-webform', 'wpform_init' );
	add_submenu_page( 'wp-webform', 'List', 'List', 'manage_options', 'List' , 'display_list');
}

function wpform_init(){
	$msg="";

// Saving plugin settings in database 


	if(isset($_POST["submit_button"])){     
	
		$wpform_title_s1=$_POST["wpform_title_s1"];
		$wpform_icon=$_FILES["wpform_icon"]["name"];
		$wpform_marker_text=$_POST["wpform_marker_text"];
		$wpform_title_s2=$_POST["wpform_title_s2"];
		$wpform_opt_s2=json_encode($_POST["wpform_opt_s2"]);
		$wpform_title_s3=$_POST["wpform_title_s3"];
		$wpform_subtitle_s3=$_POST["wpform_subtitle_s3"];
		$wpform_fontfamily=$_POST["wpform_fontfamily"];
		
		$btn_clr=$_POST["btn_clr"];
		$wpformlayout = $_POST["wpform_layout"];
		$wpform_labels1 = json_encode($_POST["wpform-label1"]);
		$wpform_labels2 = json_encode($_POST["wpform-label2"]);
		$wpform_labels3 = json_encode($_POST["wpform-label3"]);
		$sendmail=$_POST["sendmail"];
		
		$gc_site_key=$_POST["gc_site_key"];
		$gc_secret_key=$_POST["gc_secret_key"];
		update_option( 'gc_site_key', $gc_site_key);
		update_option( 'gc_secret_key', $gc_secret_key);
		
		update_option( 'wpform_title_s1', $wpform_title_s1);
		if($wpform_icon != ""){
		update_option( 'wpform_icon', $wpform_icon);
		}
		update_option( 'wpform_marker_text', $wpform_marker_text);
		update_option( 'wpform_title_s2', $wpform_title_s2);
		update_option( 'wpform_opt_s2', $wpform_opt_s2);
		update_option( 'wpform_title_s3', $wpform_title_s3);
		update_option( 'wpform_subtitle_s3', $wpform_subtitle_s3);
		update_option( 'btn_clr', $btn_clr);
		update_option( 'wpformlayout', $wpformlayout);
		update_option( 'wpform_fontfamily', $wpform_fontfamily);
		if($wpform_labels1 != 'null'){ 
		update_option( 'wpform_labels1', $wpform_labels1);  
		}if($wpform_labels2 != 'null'){ 
		update_option( 'wpform_labels2', $wpform_labels2);
		}if($wpform_labels3 != 'null'){ 
		update_option( 'wpform_labels3', $wpform_labels3);
		}		
		update_option( 'wpform_sucessmsg', $_POST["wpform_sucessmsg"]);
		update_option( 'wpform_titlefontsize', $_POST["wpform_titlefontsize"]);
		update_option( 'wpform_titlefontwt', $_POST["wpform_titlefontwt"]);
		update_option( 'wpform_contentfontsize', $_POST["wpform_contentfontsize"]);
		update_option( 'wpform_contentfontwt', $_POST["wpform_contentfontwt"]);  
		update_option( 'wpform_hidelabels', $_POST["wpform_hidelabels"]);
		update_option( 'wpform_sendmail', $sendmail);
		update_option( 'wpform_emailsubject', $_POST["wpform_emailsubject"]);
		update_option( 'wpform_btntext', $_POST["wpform_btntext"]);
		update_option( 'wpform_rbtnclr', $_POST["wpform_rbtnclr"]);
		update_option( 'wpform_privacypolicy', $_POST["wpform_privacypolicy"]);


		$msg= "Your changes has been saved.";

		 $plugin_dir= dirname(__FILE__); 

		 $target_dir = $plugin_dir."/uploads/";
		 $target_file = $target_dir . basename($_FILES["wpform_icon"]["name"]);
		 $_FILES["wpform_icon"]["tmp_name"]; 
		 $path = $plugin_dir."/uploads/"; 
		 if (move_uploaded_file($_FILES["wpform_icon"]["tmp_name"], $target_file)) {
			
		    } 
	}

// Fetching plugin settings from database

		$wpform_title_s1= get_option( 'wpform_title_s1');
		$wpform_icon = get_option( 'wpform_icon');
		$wpform_marker_text= get_option( 'wpform_marker_text');
		$wpform_title_s2=get_option( 'wpform_title_s2');
		$wpform_opt_s2=get_option( 'wpform_opt_s2');
		$wpform_title_s3=get_option( 'wpform_title_s3');
		$wpform_subtitle_s3=get_option( 'wpform_subtitle_s3');
		$btn_clr=get_option( 'btn_clr');
		$wpformlayout = get_option( 'wpformlayout');
		$wpform_labels1 = get_option( 'wpform_labels1');
		$wpform_labels2 = get_option( 'wpform_labels2');
		$wpform_labels3 = get_option( 'wpform_labels3');
		$wpformlayout=get_option( 'wpformlayout');
		$wpform_sucessmsg=get_option( 'wpform_sucessmsg');
		$wpform_emailsubject=get_option( 'wpform_emailsubject');
		$wpform_titlefontsize = get_option( 'wpform_titlefontsize');
		$wpform_titlefontwt = get_option( 'wpform_titlefontwt');
		$wpform_contentfontsize = get_option( 'wpform_contentfontsize');
		$wpform_contentfontwt = get_option( 'wpform_contentfontwt');
		$wpform_hidelabels = get_option( 'wpform_hidelabels');
		$wpform_sendmail = get_option( 'wpform_sendmail');
		$wpform_labels1_arr = json_decode( $wpform_labels1);
		$wpform_labels2_arr = json_decode( $wpform_labels2);
		$wpform_labels3_arr = json_decode( $wpform_labels3);
		$wpform_btntext = get_option( 'wpform_btntext');
		$wpform_rbtnclr = get_option( 'wpform_rbtnclr');
		$wpform_privacypolicy = get_option( 'wpform_privacypolicy');
		$gc_site_key = get_option( 'gc_site_key');
		$gc_secret_key = get_option( 'gc_secret_key');

	
		
	?>

<!--- Plugin Settings Form --->


<h3>Settings</h3>
	
<div>Use shortcode [multistep_form] to embed the form.</div>
	<div class="success-msg"><?php echo $msg; ?></div>
	  <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="">
	 <h4>Step 1</h4>
	  <div class="form-group">
	    <label class="control-label col-sm-2" for="title">Title:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="wpform_title" name="wpform_title_s1" placeholder="" value="<?php echo $wpform_title_s1; ?>">
	    </div>
	  </div>

	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Marker Icon:</label>
	    <div class="col-sm-6">
	      <input type="file" class="" id="wpform_icon" name="wpform_icon" placeholder="" value="<?php echo $wpform_icon; ?>">
	    </div>
	  </div>

	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Marker Text:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="wpform_marker_text" name="wpform_marker_text" placeholder="" value="<?php echo $wpform_marker_text; ?>">
	    </div>
	  </div>
<hr>
<h4>Step 2</h4>
	  <div class="form-group">
	    <label class="control-label col-sm-2" for="email"> Title:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="wpform_title" name="wpform_title_s2" placeholder="" value="<?php echo $wpform_title_s2; ?>">
	    </div>
	  </div>

	  <div class="form-group">
	    <label class="control-label col-sm-2" for="email"> Add Options:</label>
	    <?php $wpform_opt_s2_arr=json_decode($wpform_opt_s2);  ?>
	    <div class="col-sm-6 options">
		
	      <input type="text" class="form-control" id="wpform_title" name="wpform_opt_s2[]" placeholder="" value="<?php echo $wpform_opt_s2_arr[0]; ?>">
	    </div>
		<?php
		$i=1; $j=2;
		foreach($wpform_opt_s2_arr as $wpform_s2opt){ 
		if($wpform_opt_s2_arr[$i] != ""){
		?><div id="TextBoxDiv<?php echo $j; ?>" class="col-md-12 TextBox"><label class="col-md-2">Option #<?php echo $i+1; ?> : </label><div class="col-sm-6 options">
		
	      <input type="text" class="form-control" id="wpform_title" name="wpform_opt_s2[]" placeholder="" value="<?php echo $wpform_opt_s2_arr[$i]; ?>">
	    </div><input type="button" value="Remove" class="removeButton" onclick="remove('<?php echo $j; ?>');">
		</div>

		<?php } $i++; $j++;  }


		?>
		<div id="TextBoxesGroup"></div>
		<input type="button" value="Add" id="addButton">
	  </div>
		  <div class="form-group">
	    <label class="control-label col-sm-2" for="email">Radio Button Color:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="wpform_rbtnclr" name="wpform_rbtnclr" placeholder="" value="<?php echo $wpform_rbtnclr; ?>">
	    </div>
	  </div>
	

<hr>
<h4>Step 3</h4>
	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Title:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="wpform_title" name="wpform_title_s3" placeholder="" value="<?php echo $wpform_title_s3; ?>">
	    </div>
	  </div>
	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Sub-title:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="wpform_title" name="wpform_subtitle_s3" placeholder="" value="<?php echo $wpform_subtitle_s3; ?>">
	    </div>
	  </div>
	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Select Form Layout:</label>
	    <div class="col-sm-6">
	      <select class="form-control" name="wpform_layout" onchange="changeLayout(this.value);">

			<option value="1" <?php if($wpformlayout == "1"){ echo "selected"; }   ?> >Layout 1</option>
			<option value="2" <?php if($wpformlayout == "2"){ echo "selected"; }   ?>>Layout 2</option>
			<option value="3" <?php if($wpformlayout == "3"){ echo "selected"; }   ?>>Layout 3</option>
	      </select>
	    </div>
	  </div>
	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Button Text:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="wpform_btntext" name="wpform_btntext" placeholder="" value="<?php echo $wpform_btntext; ?>">
	    </div>
	  </div>


	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Hide Labels:</label>
	    <div class="col-sm-6">
	     	<input type="checkbox" name="wpform_hidelabels" id="wpform_hidelabels" value="1" <?php if($wpform_hidelabels == 1){ echo "checked"; } ?> >
	    </div>
	  </div>

		<div class="innerDiv form-layout">
			<p><a href="javascript:void(0);" onclick="editLabels();" class="edit-btn1" >Click here to edit labels</a></p>
			
			<div class="layout1" <?php if($wpformlayout != "1"){ echo 'style="display:none;"'; } ?> >
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="email"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels1_arr[0]; ?>" disabled="disbaled" name="wpform-label1[]"></label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="pwd"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels1_arr[1]; ?>" disabled="disbaled" name="wpform-label1[]"></label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="lastname" placeholder=""name="lastname">
			    </div>
			  </div>
			<div class="form-group">
			    <label class="control-label col-sm-2" for="pwd"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels1_arr[2]; ?>" disabled="disbaled" name="wpform-label1[]"></label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="email" placeholder="" name="email">
			    </div>
			  </div>
			<div class="form-group">
			    <label class="control-label col-sm-2" for="pwd"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels1_arr[3]; ?>" disabled="disbaled"name="wpform-label1[]"></label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="phone" placeholder="" name="phone">
			    </div>
			    
			    
			  </div>
			<!--<div class="form-group">
			    <label class="control-label col-sm-2" for="pwd">&nbsp;</label>
			    <div class="col-sm-10">
			      <input type="checkbox" class="" id="project_info" name="project_info" placeholder="" value="1"><span>Yes,I would like free project cost information.</span>
			      
			      
			    </div>
			  </div>-->
			</div>
			

			<div class="layout2" <?php if($wpformlayout != "2"){ echo 'style="display:none;"'; } ?>>
			  <div class="form-group">
			    <label class="control-label col-sm-5" for="email"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels2_arr[0]; ?>" disabled="disabled" name="wpform-label2[]"></label>
			    <div class="col-sm-5">
			      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-5" for="pwd"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels2_arr[1]; ?>" disabled="disabled" name="wpform-label2[]"></label>
			    <div class="col-sm-5">
			      <input type="text" class="form-control" id="lastname" placeholder=""name="lastname">
			    </div>
			  </div>
			<div class="form-group">
			    <label class="control-label col-sm-5" for="pwd"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels2_arr[2]; ?>" disabled="disabled" name="wpform-label2[]"></label>
			    <div class="col-sm-5">
			      <input type="text" class="form-control" id="email" placeholder="" name="email">
			    </div>
			  </div>
			<div class="form-group">
			    <label class="control-label col-sm-5" for="pwd"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels2_arr[3]; ?>" disabled="disabled" name="wpform-label2[]"></label>
			    <div class="col-sm-5">
			      <input type="text" class="form-control" id="phone" placeholder="" name="phone">
			    </div>
			  </div>
			<!--<div class="form-group">
			 <label class="control-label col-sm-1" for="pwd"></label>
			    <div class="col-sm-11">
			      <input type="checkbox" class="" id="project_info" name="project_info" placeholder="" value="1"><span>Yes,I would like free project cost information.</span>
			    </div>
			  </div>-->
			</div>



			<div class="layout3" <?php if($wpformlayout != "3"){ echo 'style="display:none;"'; } ?>>
			  <div class="form-group">
			    <label class="control-label col-sm-3" for="email"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels3_arr[0]; ?>" disabled="disabled" name="wpform-label3[]"></label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="">
			    </div>
			  </div>

			<div class="form-group">
			    <label class="control-label col-sm-3" for="pwd"><input class="control-label col-sm-12" type ="text" value="<?php echo $wpform_labels3_arr[1]; ?>" disabled="disabled" name="wpform-label3[]"></label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="email" placeholder="" name="email">
			    </div>
			  </div>
			<!--<div class="form-group">
			    <label class="control-label col-sm-2" for="pwd">&nbsp;</label>
			    <div class="col-sm-10">
			      <input type="checkbox" class="" id="project_info" name="project_info" placeholder="" value="1"><span>Yes,I would like free project cost information.</span>
			    </div>
			  </div>-->
			</div>
		</div>

			    
			    
			    
			    
			
			




<hr>
<h4>Captcha</h4>
	 <div class="form-group">
	    <label class="control-label col-sm-2" for="email">Site Key</label>
	    <div class="col-sm-6">
	       <input type="text" class="form-control" id="captcha" placeholder="Secret Key" name="gc_site_key" value="<?php echo $gc_site_key; ?>">
	    </div></div>
	    <div class="form-group">
	    <label class="control-label col-sm-2" for="email">Secret Key</label>
	    <div class="col-sm-6">
	       <input type="text" class="form-control" id="captcha" placeholder="Secret Key" name="gc_secret_key" value="<?php echo $gc_secret_key; ?>">
	    </div>
	  </div>
 	


			
			
			
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    
			    

<hr>
<h4>Design Options</h4>
	 <div class="form-group">
	    <label class="control-label col-sm-2" for="email">Button Color:</label>
	    <div class="col-sm-6">
	      <input type="text" class="form-control" id="btn_clr" name="btn_clr" placeholder="" value="<?php echo $btn_clr; ?>">
	    </div>
	  </div>
 	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Font Family:</label>
	    <div class="col-sm-6">
	      <select name="wpform_fontfamily" id="wpform_fontfamily" class="form-control">
			<option <?php if($wpform_fontfamily == "Arial"){ echo "selected"; } ?> >Arial</option>
			<option <?php if($wpform_fontfamily == "Comic Sans MS"){ echo "selected"; } ?> >Comic Sans MS</option>
			<option <?php if($wpform_fontfamily == "Trebuchet MS"){ echo "selected"; } ?> >Trebuchet MS</option>
			<option <?php if($wpform_fontfamily == "Verdana"){ echo "selected"; } ?> >Verdana</option
			><option <?php if($wpform_fontfamily == "Times New Roman"){ echo "selected"; } ?> >Times New Roman</option>
			<option <?php if($wpform_fontfamily == "Georgia"){ echo "selected"; } ?> >Georgia</option>
			<option <?php if($wpform_fontfamily == "Sans-Serif"){ echo "selected"; } ?> >Sans-Serif</option>
			<option <?php if($wpform_fontfamily == "Helvetica"){ echo "selected"; } ?> >Helvetica</option>
			<option <?php if($wpform_fontfamily == "Lucida Sans Unicode"){ echo "selected"; } ?> >Lucida Sans Unicode</option>
			<option <?php if($wpform_fontfamily == "Tahoma"){ echo "selected"; } ?> >Tahoma</option>
			<option <?php if($wpform_fontfamily == "Courier New"){ echo "selected"; } ?> >Courier New</option>
			<option <?php if($wpform_fontfamily == "Montserrat"){ echo "selected"; } ?> >Montserrat</option>
		</select>
	    </div>
	  </div>

 	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Title Font Size:</label>
	    <div class="col-sm-2">
	      <select name="wpform_titlefontsize" id="wpform_titlefontsize" class="form-control">
			<option <?php if($wpform_titlefontsize == "10"){ echo "selected"; } ?> value="10">10 px</option>
			<option <?php if($wpform_titlefontsize == "12"){ echo "selected"; } ?> value="12">12 px</option>
			<option <?php if($wpform_titlefontsize == "14"){ echo "selected"; } ?> value="14">14 px</option>
			<option <?php if($wpform_titlefontsize == "16"){ echo "selected"; } ?> value="16">16 px</option>
			<option <?php if($wpform_titlefontsize == "18"){ echo "selected"; } ?> value="18">18 px</option>
			<option <?php if($wpform_titlefontsize == "20"){ echo "selected"; } ?> value="20">20 px</option>
			<option <?php if($wpform_titlefontsize == "22"){ echo "selected"; } ?> value="22">22 px</option>
			<option <?php if($wpform_titlefontsize == "24"){ echo "selected"; } ?> value="24">24 px</option>
			<option <?php if($wpform_titlefontsize == "26"){ echo "selected"; } ?> value="26">26 px</option>
			<option <?php if($wpform_titlefontsize == "28"){ echo "selected"; } ?> value="28">28 px</option>
			<option <?php if($wpform_titlefontsize == "30"){ echo "selected"; } ?> value="30">30 px</option>
			<option <?php if($wpform_titlefontsize == "32"){ echo "selected"; } ?> value="32">32 px</option>
		</select>
	    </div>
	  </div>

 	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Title Font Weight:</label>
	    <div class="col-sm-2">
	      <select name="wpform_titlefontwt" id="wpform_titlefontwt" class="form-control">
			<option <?php if($wpform_titlefontwt == "Normal"){ echo "selected"; } ?> >Normal</option>
			<option <?php if($wpform_titlefontwt == "Bold"){ echo "selected"; } ?> >Bold</option>

		</select>
	    </div>
	  </div>

 	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Content Font Size:</label>
	    <div class="col-sm-2">
	      <select name="wpform_contentfontsize" id="wpform_contentfontsize" class="form-control">
			<option <?php if($wpform_contentfontsize == "10"){ echo "selected"; } ?> value="10">10 px</option>
			<option <?php if($wpform_contentfontsize == "12"){ echo "selected"; } ?> value="12">12 px</option>
			<option <?php if($wpform_contentfontsize == "14"){ echo "selected"; } ?> value="14">14 px</option>
			<option <?php if($wpform_contentfontsize == "16"){ echo "selected"; } ?> value="16">16 px</option>
			<option <?php if($wpform_contentfontsize == "18"){ echo "selected"; } ?> value="18">18 px</option>
			<option <?php if($wpform_contentfontsize == "20"){ echo "selected"; } ?> value="20">20 px</option>
			<option <?php if($wpform_contentfontsize == "22"){ echo "selected"; } ?> value="22">22 px</option>
			<option <?php if($wpform_contentfontsize == "24"){ echo "selected"; } ?> value="24">24 px</option>
			<option <?php if($wpform_contentfontsize == "26"){ echo "selected"; } ?> value="26">26 px</option>
			<option <?php if($wpform_contentfontsize == "28"){ echo "selected"; } ?> value="28">28 px</option>
			<option <?php if($wpform_contentfontsize == "30"){ echo "selected"; } ?> value="30">30 px</option>
			<option <?php if($wpform_contentfontsize == "32"){ echo "selected"; } ?> value="32">32 px</option>
		</select>
	    </div>
	  </div>


 	<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Content Font Weight:</label>
	    <div class="col-sm-2">
	      <select name="wpform_contentfontwt" id="wpform_contentfontwt" class="form-control">
			<option <?php if($wpform_contentfontwt == "Normal"){ echo "selected"; } ?> >Normal</option>
			<option <?php if($wpform_contentfontwt == "Bold"){ echo "selected"; } ?> >Bold</option>

		</select>
	    </div>
	  </div>
<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Success Message Text:</label>
	    <div class="col-sm-8">
	       <textarea class="form-control" name="wpform_sucessmsg"><?php echo $wpform_sucessmsg; ?></textarea>
	    </div>
	  </div>

<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Privacy Policy Text:</label>
	    <div class="col-sm-8">
	       <textarea class="form-control" name="wpform_privacypolicy" id="wpform_privacypolicy"><?php echo $wpform_privacypolicy; ?></textarea>
	    </div>
	  </div>

<hr>
<h4>Email Setting</h4>
<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Email</label>
	    <div class="col-sm-8">
	       <input class="form-control" type="text" name="sendmail" value="<?php echo $wpform_sendmail; ?>">
	    </div>
	  </div>
<div class="form-group">
	    <label class="control-label col-sm-2" for="email">Email Subject</label>
	    <div class="col-sm-8">
	       <input class="form-control" type="text" name="wpform_emailsubject" value="<?php echo $wpform_emailsubject; ?>">
	    </div>
	  </div>

	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" name="submit_button" class="btn btn-default">Save Changes</button>
	    </div>
	  </div>

	</form> 

<!---  ! Plugin Settings Form ---->
<style>
.layout2 .col-sm-5 {
  padding-left: 0 !important;
}
#wpform_privacypolicy{ height:200px; }
.form-horizontal {
  font-family: Times New Roman;
}
.innerDiv.form-layout > p {
  float: right;
  width: 100%;
  text-align: right;
}
.TextBox label {
  padding-right: 25px;
  text-align: right;
}
.layout3 label { text-align:left !important; }
input[type="checkbox"], input[type="radio"] {
  line-height: normal;
  margin: 4px -3px 3px;
}.layout2 .col-sm-11 > span {
  float: right;
  line-height: 35px;
}
.layout2 .form-horizontal .control-label {
  margin-bottom: 0;
  margin-right: -15px;
  padding-top: 7px;
  text-align: center;
}
.control-label.col-sm-5 {
  margin-top: 0 !important;
  padding-top: 0 !important;
}
.layout2 .form-group{ width:48%; float:left; }
.layout2{ //display:none; height:200px;} 
.layout3{ //display:none;} 
button[disabled], html input[disabled] {
    border: medium none;
    box-shadow: none;
    color: #333;
    cursor: default;
    font-weight: bold !important;
}
.edit-btn{ float:right; }
.form-layout{ width:80%;padding:20px; border:1px solid #ccc; }
.TextBox {
  padding-top: 10px;
}

.TextBox .col-md-6 {
  padding-left: 5px;
  padding-right: 10px;
}
.success-msg{
  text-align: center;
  color: green;
}
.TextBox .options {
  padding-left: 5px;
  padding-right: 10px;
}


</style>
<?php 
$plugin_path=plugins_url()."/WP-Webform/"; ?>
<script src="<?php echo $plugin_path; ?>js/settings.js"></script>
<link href="<?php echo $plugin_path; ?>css/settings.css" rel="css/stylesheet">
<div class="preview-container">

<?php
  wp_register_style('customstyle',plugins_url('css/custom11.css', __FILE__) );
  wp_enqueue_style( 'customstyle' ); 
  wp_register_style('timepickercss',plugins_url('css/jquery.timepicker.css', __FILE__) );
  wp_enqueue_style( 'timepickercss' ); 
  wp_register_style('bootstrapcss',plugins_url('css/bootstrap.min.css', __FILE__) );
  wp_enqueue_style( 'bootstrapcss' ); 
  wp_register_style('jqueryuicss',plugins_url('css/jquery-ui.css', __FILE__) );
  wp_enqueue_style( 'jqueryuicss' ); 
  wp_register_script('timepickerjs',plugins_url('js/jquery.timepicker.js', __FILE__) );
  wp_enqueue_script( 'timepickerjs' ); 
  wp_register_script('jquery-1.12.4',plugins_url('js/jquery-1.12.4.js', __FILE__) );
  wp_enqueue_script( 'jquery-1.12.4' ); 
  wp_register_script('jquery-ui',plugins_url('js/jquery-ui.js', __FILE__) );
  wp_enqueue_script( 'jquery-ui' ); 


?>

<?php $plugin_path=plugins_url()."/WP-FORM/"; ?>
			<style>
.preview-container {
  pointer-events: none;
}
			.freq{ width:100px !important; display:inline !important;}
.btn{ margin:20px 0px; }
.timepicker {
  background: #f0f4f7 url("<?php echo $plugin_path; ?>/images/ico-clock.png") no-repeat scroll 90% 8px !important;
  border: medium none;
  border-radius: 3px;
  box-sizing: border-box;
  color: #191919;
  cursor: pointer;
  font-size: 14px;
  height: 33px;
  line-height: 33px;
  padding: 0 35px 0 10px ;

}
.datepicker {
  background: #f0f4f7 url("<?php echo $plugin_path; ?>/images/ico-date.png") no-repeat scroll 94% 8px !important;
  border: medium none;
  border-radius: 3px;
  box-sizing: border-box;
  color: #191919;
  cursor: pointer;
  font-size: 14px;
  height: 33px;
  line-height: 33px;
  padding: 0 35px 0 10px;
  position: relative;
  width:177px !important;
}
.form-title {
  font-size: 20px;
  font-weight: bold;
  padding: 20px 0;
}
.form-group {
  margin-bottom: 30px !important;
}
.wp-admin select {
  height: 35px;
  line-height: 28px;
  padding: 2px;
}
.custom-file-upload {
    position: relative;
    overflow: hidden;
    /*margin: 10px;*/
   background: #07a9d6 none repeat scroll 0 0;
    border-radius: 4px;
    color: white;
    overflow: hidden;
    padding: 10px;
    position: relative;
    text-align: center;
    width: 20%;
}
.custom-file-upload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
label {
  display: inline-block;
  float: left;
  font-weight: 700;
  line-height: 20px;
  margin-bottom: 5px;
  max-width: 100%;
  padding: 6px 10px 0 0;
}
#username{ width:27%; }
.form-group.timep > label{ float:none !important; }
			.form-title {
			  font-size: 20px;
			  font-weight: bold;
			  padding: 20px 0;
			}
			.preview-container > form {
			  width: 70%;
			  margin: auto;
			  border: 1px solid #ccc;
			  padding: 30px;
			}
			.form-group {
			  margin-bottom: 20px;
			}
			.wp-admin select {
			  height: 35px;
			  line-height: 28px;
			  padding: 2px;
			}

			</style>

	</div>
<style>
.btn { background-color:#0073AA!important;color:white!important; }

</style>
<?php
}

// Function for displaying form entries 

function display_list(){    
	$msg="";
	global $wpdb;
	
	if(isset($_REQUEST["action"])){
		if($_REQUEST["action"] == "del"){
			$tid=$_REQUEST["tid"];
			$table_name=$wpdb->prefix."webform_data";
			$res=$wpdb->delete( $table_name, array( 'id' =>$tid) );
			if($res){
				$msg="Successfully Deleted !!";
			
			}

		}
		if($_REQUEST["action"] == "del_all"){
			$table_name = $wpdb->prefix . 'webform_data';
			$res=$wpdb->query("TRUNCATE TABLE $table_name");
			if($res){
				$msg="Successfully Deleted !!";
			}
			$path=site_url()."/wp-admin/admin.php?page=List";
			header("location:".$path);

		}
	}
	?>
	<script>
	jQuery(document).ready(function () {
	    jQuery(".ckbCheckAll").click(function () {
		jQuery(".checkBoxClass").prop('checked', jQuery(this).prop('checked'));
	    });
	});
	</script>
	<div class="container">
	<h3>List of Form Entries</h3>
	<a href="?page=List&action=del_all" class="btn button btn-lg btn-default del-btn">Delete All</a>
	<div class="msg"><?php echo $msg; ?></div>
	<form method="POST" action="" id="form-list">
	<table class="wp-list-table widefat fixed striped posts">
	<tfoot>
	<tr>	
	<th class="manage-column column-eafl_clicks" scope="col" style="width:80px";>
	Sr.No.
	</th>
	<th class="manage-column column-eafl_clicks" scope="col">First Name</th>
	<th class="manage-column column-eafl_clicks" scope="col">Last Name</th>
	<th class="manage-column column-eafl_clicks" scope="col">Email</th>
	<th class="manage-column column-eafl_clicks" scope="col">Phone</th>
	<th class="manage-column column-eafl_clicks" scope="col">Location</th>
	<th class="manage-column column-eafl_clicks" scope="col">Nature of Project</th>
	<th class="manage-column column-eafl_clicks" scope="col">Action</th>
	</tr>
	<?php

	global $wpdb;
	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit   = 100;
	$offset  = ( $pagenum - 1 ) * $limit;
	$table_name = $wpdb->prefix . 'webform_data';
	$zipcode_table = $wpdb->prefix . 'wpform_zipcodes';
	$results  = $wpdb->get_results( "SELECT * FROM $table_name LIMIT $offset, $limit" );
	if( $results ) {
	$count=$offset; 
	foreach($results as $result){ $count++;
	$id = $result->id;
	$firstname = $result->firstname;
	$lastname = $result->lastname;
	$email = $result->email;
	$phone = $result->phone;
	$zipcode = $result->zipcode;
	$step2_opt = $result->step2_opt;

	$row = $wpdb->get_row('Select * from '.$zipcode_table.' where zipcode = '.$zipcode);
	?>
	<tr class="ui-sortable-handle assisan_task">

	<td class ="td-name" id= "user_mnu1" style="text-align:left;" ><?php echo $count;?></td>
	<td class ="td-name" id= "user_mnu3" contenteditable="false"><?php echo urldecode($firstname); ?></td>
	<td class ="td-name" id= "user_mnu3" contenteditable="false"><?php echo urldecode($lastname); ?></td>
	<td class ="td-name" id= "user_mnu3" contenteditable="false"><?php echo urldecode($email); ?></td>
	<td class ="td-name" id= "user_mnu3" contenteditable="false"><?php echo urldecode($phone); ?></td>
	<td class ="td-name" id= "user_mnu3" contenteditable="false"><?php echo $row->city.", ".$row->state_code; ?></td>
	<td class ="td-name" id= "user_mnu3" contenteditable="false"><?php echo urldecode($step2_opt); ?></td>	
	<td class ="td-name" id= "user_mnu1" style="text-align:left;" ><a href="?page=List&action=del&tid=<?php echo $id; ?>">Delete</a></td>	
	</tr>

	<?php
	} } else{  ?> <td class ="td-name" id= "user_mnu1" colspan="10" style="text-align:center;" >No Records Found.</td>  <?php    }  ?>
	</tfoot>

</table>
</form>

	<style>.hndle a, .widefat tfoot td, .widefat th, .widefat thead td {
	  font-weight: 400;
	 // width: 170px;
	}
	.wp-list-table td { text-align:left; }
	.btn.button.btn-lg.del-btn {
	  background: #0073aa none repeat scroll 0 0 !important;
	  color: #fff;
	  float: right;
	  margin: 10px;
	}
	.msg {
	  color: green;
	  padding: 10px;
	  text-align: center;
	}
	.button.btn.btn-success {
	  background: #0073aa none repeat scroll 0 0 !important;
	  color: white;
	}
	.tablenav {
	  margin: 6px 10px 4px;

	}
.msg-error {
  color: #c65848;
}
span.msg-error.error {
    color: red;
}
.g-recaptcha.error {
  border: solid 2px #c64848;
  padding: .2em;
  width: 19em;
}
	</style>
	<?php $total  = $wpdb->get_var( "SELECT COUNT('id') FROM $table_name" );
		$num_of_pages = ceil( $total / $limit );
		$page_links   = paginate_links( array(
		'base'      => add_query_arg( 'pagenum', '%#%' ),
		'format'    => '',
		'prev_text' => __( '&laquo;', 'aag' ),
		'next_text' => __( '&raquo;', 'aag' ),
		'total'     => $num_of_pages,
		'current'   => $pagenum
	) );

	if ( $page_links ) {
	    echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
	}

}

// Function for creating tables on plugin activate

function install(){
	global $wpdb;

	$table_name = $wpdb->prefix . 'wpform_zipcodes';
	$webform_data_table = $wpdb->prefix . 'webform_data';

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `zipcode` varchar(100) NOT NULL,
	  `city` varchar(100) NOT NULL,
	  `state_code` varchar(100) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;";

	 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	 dbDelta( $sql ); 

	$sql1 = "CREATE TABLE IF NOT EXISTS ".$webform_data_table." (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `zipcode` varchar(100) NOT NULL,
	  `step2_opt` varchar(100) NOT NULL,
	   `firstname` varchar(100) NOT NULL,
	`lastname` varchar(100) NOT NULL,
	`phone` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL,
	  `project_info` varchar(100) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;";

	dbDelta( $sql1 ); 


	$delete = $wpdb->query("TRUNCATE TABLE ".$table_name);
	$plugin_path=plugins_url()."/WP-Webform/"; 
	$lines = file($plugin_path.'ZIPBRONZE.txt');
	foreach($lines as $line){

		$line_arr = explode(",",$line);
		$zipcode = $line_arr[0];
		$city = $line_arr[1];
		$state_code = $line_arr[2];
		$wpdb->insert($table_name, array(
			    'zipcode' => $zipcode,
			    'city' => $city,
			    'state_code' => $state_code, 
			));

	}


	update_option( 'wpform_emailsubject', "Customer Request");
	update_option( 'wpform_title_s1', " What is the location of your project? ");
	update_option( 'wpform_marker_text', "Zip Code");
	update_option( 'wpform_title_s2', "What is the nature of this project? *");
	update_option( 'wpform_opt_s2', '["Completely replace roof","Install roof on new construction"," Repair existing roof"] ');
	update_option( 'wpform_title_s3', "We have matching metal roof contractors in your are !");
	update_option( 'wpform_subtitle_s3', "Get quotes from up to 4 prescreened pros now");
	update_option( 'wpformlayout', "1");

	update_option( 'btn_clr', "#49a1a7");
	update_option( 'wpform_fontfamily', "Helvetica");
	update_option( 'wpform_titlefontsize', "18");
	update_option( 'wpform_titlefontwt', "Bold");
	update_option( 'wpform_contentfontsize', "14");
	update_option( 'wpform_contentfontwt', "Normal "); 

	update_option( 'wpformlayout', "1");
	update_option( 'wpform_fontfamily', "Montserrat");
	update_option( 'wpform_labels1', '["First Name ","Last Name ","Email","Phone"]'); 
	update_option( 'wpform_labels2','["First Name ","Last Name ","Email","Phone"]'); 
	update_option( 'wpform_labels3', '["Name","Email/Phone"] '); 
	update_option( 'wpform_sucessmsg', 'Thank you for contacting us.'); 
	update_option( 'wpform_btntext', "View Matching Pros");
	update_option( 'wpform_rbtnclr', "#49a1a7");

	

}

// Function to run on uninstalling the plugin

function uninstall(){

}


// Shortcode Form [multistep_form]


function multistep_form(){
ob_start();

	// Fetching plugin settings 

	$wpform_title_s1= get_option( 'wpform_title_s1');
	$wpform_marker_text= get_option( 'wpform_marker_text');
	$wpform_title_s2= get_option( 'wpform_title_s2');
	$wpform_title_s3= get_option( 'wpform_title_s3');
	$wpform_subtitle_s3= get_option( 'wpform_subtitle_s3');
	$btn_clr= get_option( 'btn_clr');
	$wpform_icon= get_option( 'wpform_icon');
	$wpform_fontfamily= get_option( 'wpform_fontfamily');
	if(empty($wpform_fontfamily)){ $wpform_fontfamily='"Montserrat",Helvetica,"Helvetica Neue",Arial,serif'; }
	$wpformlayout=get_option( 'wpformlayout');
	$wpform_hidelabels = get_option( 'wpform_hidelabels');
	$wpform_labels1 = get_option( 'wpform_labels1');
	$wpform_labels2 = get_option( 'wpform_labels2');
	$wpform_labels3 = get_option( 'wpform_labels3');
	$wpform_labels1_arr = json_decode( $wpform_labels1);
	$wpform_labels2_arr = json_decode( $wpform_labels2);
	$wpform_labels3_arr = json_decode( $wpform_labels3);
	$wpform_titlefontsize = get_option( 'wpform_titlefontsize');
	$wpform_titlefontwt = get_option( 'wpform_titlefontwt');
	$wpform_contentfontsize = get_option( 'wpform_contentfontsize');
	$wpform_contentfontwt = get_option( 'wpform_contentfontwt');
	$wpform_sucessmsg=get_option( 'wpform_sucessmsg');
	$plugin_upload_path=plugins_url()."/WP-Webform/uploads/"; 
	$plugin_path=plugins_url()."/WP-Webform/"; 
	$wpform_sendmail = get_option( 'wpform_sendmail');
	$wpform_btntext = get_option( 'wpform_btntext');
	$wpform_rbtnclr = get_option( 'wpform_rbtnclr');
	$wpform_privacypolicy = get_option( 'wpform_privacypolicy');
	

	$res="";
	include("handle_form_submission.php");  // Handle form submission
	?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="wpform_container">
	<div class="step1" >
<div class="fstep">
		<form class="form-horizontal" method="POST" action="" id="multistep-webform">
		<input type="hidden" name="senddata" value="<?php echo $wpform_sendmail; ?>">
		<input type="hidden" class="stepform" value="1">
		<?php //echo $res; ?>
		<?php if($res == 1){   ?>
			<div class="success-msg"><?php echo $wpform_sucessmsg; ?> 
			</div>
		<?php } else { ?>
		<h4 class="wpf-title"><?php echo $wpform_title_s1; ?></h4>
		<div class="zipcode">
		<?php  $plugin_path.$wpform_icon; ?>
		<?php if(empty($wpform_icon)){ ?>
		<img src="<?php echo $plugin_path; ?>/icon.png" height="60" width="60">

		<?php } else { ?>
	
		<img src="<?php echo $plugin_upload_path.$wpform_icon; ?>" height="60" width="60">

		<?php } ?>
		<div class="marker-text"><?php echo $wpform_marker_text; ?></div>
		<div class="s1_form"><input type="text" placeholder="Enter Zip Code" name="zipcode" id="zipcode"></div>
		</div>
</div>
		<hr>
		<div class="nxt"><input type="button" value="Next" id="next_btn" class="next_btn btn"></div>
		<?php } ?>
	</div>
	
	<div class="step2" >
<div class="fstep">

		<input type="hidden" class="stepform111" value="2">
		<h4 class="wpf-title"><?php echo $wpform_title_s2; ?></h4>
		<div class="innerDiv">
<?php  $wpform_opt_s2 = get_option( 'wpform_opt_s2'); 
					$wpform_opt_s2_arr = json_decode( $wpform_opt_s2 );
					$t=1;
			foreach($wpform_opt_s2_arr as $wpform_opt){
			?><div class="radio_row"><input type ="radio" id="test<?php echo $t;?>" name="wpform_opt"  class="chkbox"  value="<?php echo $wpform_opt; ?>">
             <label for="test<?php echo $t;?>"><span>
			<?php echo $wpform_opt; ?></span></label>
             </div>

			<?php $t++; } ?>
			
		
		</div>
</div>
		<hr>
		<div class="nxt"><!--<input type="button" value="PREVIOUS" id="s2_prevbtn" class="next_btn">-->
				<input type="button" value="Next" id="s2_nxtbtn" class="next_btn btn" disabled="disabled">
		</div>
	</div>

	<div class="step3">
<div class="fstep">
		<h4 class="wpf-title"><?php echo $wpform_title_s3; ?></h4>
		<div class="s3"></div>
		<h6 class="sub-title"><?php echo $wpform_subtitle_s3; ?></h6>
		<div class="innerDiv">
			
		<?php if($wpformlayout == "1"){    ?>
			<?php if($wpform_hidelabels != 1){ $class="col-sm-9";  } else { $class="col-sm-12"; }   ?>
			<div class="layout1">
			  <div class="form-group">
			   <?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="email"><?php echo $wpform_labels1_arr[0]; ?><span class="req-text">&nbsp;*</span></label>
			 <?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php echo $wpform_labels1_arr[0]; ?>">
			    </div>
			  </div>
			  <div class="form-group">
			  <?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="pwd"><?php echo $wpform_labels1_arr[1]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="lastname" placeholder="<?php echo $wpform_labels1_arr[1]; ?>" name="lastname">
			    </div>
			  </div>
			<div class="form-group">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="pwd"><?php echo $wpform_labels1_arr[2]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="email" placeholder="<?php echo $wpform_labels1_arr[2]; ?>" name="email">
			    </div>
			  </div>
			<div class="form-group">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="pwd"><?php echo $wpform_labels1_arr[3]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="phone" placeholder="<?php echo $wpform_labels1_arr[3]; ?>" name="phone">
			    </div>
			  </div>
			  <!-- <div class="form-group">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="pwd">&nbsp;</label>
			<?php } ?>
			  <div class="<?php echo $class; ?>">
			     <input type="checkbox" class="" id="project_info" name="project_info" placeholder="" value="1"><span>Yes, I would like free project cost information.</span>
			    </div>
			  </div>-->
			</div>

		<?php } else if($wpformlayout == "2"){  ?>
		<?php if($wpform_hidelabels != 1){ $class="col-sm-7";  $class1="col-sm-9"; } else { $class="col-sm-12"; $class1="col-sm-12";}   ?>
		<div class="layout2">
		<div class="form-group ">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-5" for="email"><?php echo $wpform_labels2_arr[0]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php echo $wpform_labels2_arr[0]; ?>">
			    </div>
			  </div>
			  <div class="form-group">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-5" for="pwd"><?php echo $wpform_labels2_arr[1]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="lastname" placeholder="<?php echo $wpform_labels2_arr[1]; ?>" name="lastname">
			    </div>
			  </div>
			<div class="form-group">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-5" for="pwd"><?php echo $wpform_labels2_arr[2]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="email" placeholder="<?php echo $wpform_labels2_arr[2]; ?>" name="email">
			    </div>
			  </div>
			<div class="form-group">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-5" for="pwd"><?php echo $wpform_labels2_arr[3]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="phone" placeholder="<?php echo $wpform_labels2_arr[3]; ?>" name="phone">
			    </div>
			  </div>
			<!--<div class="formgroup">
			<?php if($wpform_hidelabels != 1){ ?>
			 <label class="control-label col-sm-2" for="pwd"></label>
			<?php } ?>
			   <!--  <div class="<?php echo $class1; ?>">
			     <!-- <input type="checkbox" class="" id="project_info" name="project_info" placeholder="" value="1"><span>Yes, I would like free project cost information.</span>
			    </div>
			  </div>-->
		</div>

		


		<?php } else if($wpformlayout == "3"){   ?>
			<?php if($wpform_hidelabels != 1){ $class="col-sm-9"; } else { $class="col-sm-12"; }   ?>
			<div class="layout3">
			  <div class="form-group">
			    <?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="email"><?php echo $wpform_labels3_arr[0]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php echo $wpform_labels3_arr[0]; ?>">
			    </div>
			  </div>

			<div class="form-group">
			<?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="pwd"><?php echo $wpform_labels3_arr[1]; ?><span class="req-text">&nbsp;*</span></label>
			<?php } ?>
			    <div class="<?php echo $class; ?>">
			      <input type="text" class="form-control" id="email" placeholder="<?php echo $wpform_labels3_arr[1]; ?>" name="email">
			    </div>
			  </div>
			 <!--<div class="form-group">
				 <?php if($wpform_hidelabels != 1){ ?>
			    <label class="control-label col-sm-3" for="pwd">&nbsp;</label>

				<?php } ?>
			    <div class="<?php echo $class; ?> s3-chkbox" >
			      <!--<input type="checkbox" class="" id="project_info" name="project_info" placeholder="" value="1"><span>Yes, I would like free project cost information.</span>
			    </div>
			  </div>-->
			</div>

		<?php  }?>
		</div></div><hr>
		
		 
		<?php
		 $gc_site_key = get_option( 'gc_site_key');  ?>
		 <div class="capt" style="width:308px; margin:0 auto;">
<span class="msg-error error"></span>
		 <div id="recaptcha" class="g-recaptcha" data-callback="onHuman" data-sitekey="<?php echo $gc_site_key; ?>"></div>
                  <input type="hidden" id="captcha" name="captcha" value="">
		 </div>
		<div class="nxt"><input type="submit" value="<?php echo $wpform_btntext; ?>" id="s2_prevbtn1" name="webform_btn" class="next_btn btn">
			<div class="s3_footer">By submitting this request, you are agreeing to our <a href="#" class="" data-toggle="modal" data-target="#myModal">Terms & Conditions</a>.</div>	
		</div></form>
	</div>


</div>
<SCRIPT type="text/javascript"> 
  function onHuman(response) { 
   document.getElementById('captcha').value = response; 

  } 

jQuery(document).ready(function(){
jQuery("#s2_prevbtn1").click(function(){

var tesy=jQuery("#captcha").val();

 if (tesy == "") {
    jQuery( '.msg-error').text( "reCAPTCHA is mandatory" );
    if( !jQuery("#captcha").hasClass( "error" ) ){
      jQuery("#captcha").addClass( "error" );
return false;
    }
  } else {
   jQuery( '.msg-error' ).text('');
    jQuery("#captcha").removeClass( "error" );
   
  }

});

});


</SCRIPT>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<!-- Privacy Policy Popup -->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Privacy Policy</h4>
        </div>
        <div class="modal-body">
          <?php echo $wpform_privacypolicy; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<!-- ! Privacy Policy Popup -->
<script>


jQuery(document).ready(function(){


jQuery(".chkbox").click(function(){

if (!jQuery(".chkbox:checked").val()) {
 
}
else {
 jQuery("#s2_nxtbtn").removeAttr("disabled");

}

});



jQuery(".radio_row").click(function(){
  jQuery(".radio_row").removeClass("active");
  jQuery(this).addClass("active");
});

jQuery(document).keypress(function(e){ var step =  jQuery(".stepform").val();
	
        if(e.which == 13){
		if(step == 1){
			if(!jQuery('#next_btn').prop('disabled')){

			jQuery(".stepform").val('2');
			}
			
		   	jQuery('#next_btn').click();
		
			
		}else{  if(!jQuery('#s2_nxtbtn').prop('disabled')){ jQuery('#s2_nxtbtn').click();  } }
        }
    });

jQuery("#zipcode").bind("keyup paste", function(e){
		var zipcode = this.value;
		var ajaxurl = my_ajax_object.ajax_url ;
		
		var myLength = jQuery(this).val().length;
	
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

});

</script>
	<?php

	include("style.php");

	wp_register_script('validate_zipcode',plugins_url('js/validate_zipcode.js', __FILE__) );
	wp_enqueue_script( 'validate_zipcode' ); 

//$plugin_path=plugins_url()."/WP-Webform/"; 
   //	wp_enqueue_script( 'ajax-script', $plugin_path . '/js/validate_zipcode.js', array('jquery') );

    	//wp_localize_script( 'ajax-script', 'my_ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	wp_register_style('bootstrapcss',plugins_url('css/bootstrap.min.css', __FILE__) );
	wp_enqueue_style( 'bootstrapcss' ); 

	wp_register_style('webformcss',plugins_url('css/webform.css', __FILE__) );
	wp_enqueue_style( 'webformcss' ); 
$return = ob_get_contents();
ob_clean();
return $return;

}

add_action( 'wp_ajax_check_zipcode', 'check_zipcode' );
add_action( 'wp_ajax_nopriv_check_zipcode', 'check_zipcode' );

// Checking zipcode and retrieves City, State value

function check_zipcode(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'wpform_zipcodes';
	$zipcode = $_POST["zipcode"];	
	$result = $wpdb->get_row('Select * from '.$table_name.' where zipcode = '.$zipcode);
	
	if($result){
 $result->city= ucwords(strtolower($result->city));
		echo json_encode($result);
	}	
	exit;
}

add_shortcode('multistep_form', 'multistep_form');

// Loading Ajax on frontend

function my_enqueue() {

	$plugin_path=plugins_url()."/WP-Webform/"; 
   	wp_enqueue_script( 'ajax-script', $plugin_path . '/js/validate_zipcode.js', array('jquery') );

    	wp_localize_script( 'ajax-script', 'my_ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue' );

?>
