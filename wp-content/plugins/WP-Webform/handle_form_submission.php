<?php
global $wpdb;

if(isset($_POST["webform_btn"])){
if(isset($_POST['captcha']) && !empty($_POST['captcha'])):
        //your site secret key
       
		$gc_secret_key = get_option( 'gc_secret_key');
       $secret = $gc_secret_key;
        //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['captcha']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success):

		if(!isset($_POST["lastname"])){
		$lastname = "";
	}else{
		$lastname =$_POST["lastname"];
	}

	if(!isset($_POST["phone"])){
		$phone = "";
	}else{
		$phone =$_POST["phone"];
	}

	if(!isset($_POST["project_info"])){
		$project_info = "";
	}else{
		$project_info ="";
	}

$wpform_emailsubject=get_option( 'wpform_emailsubject');

		$to = $_POST["senddata"];
		$subject = $wpform_emailsubject;
		$body = '<b>Zipcode:</b>'.$_POST["zipcode"].'<br>';
		$body .= '<b>First Name:</b>'.$_POST["firstname"].'<br>';
		$body .= '<b>Last Name:</b>'.$lastname.'<br>';
		$body .= '<b>Email:</b>'.$_POST["email"];
		$body .= '<b>Nature of Project:</b>'.$_POST["wpform_opt"];
		$headers = array('Content-Type: text/html; charset=UTF-8');
 
		wp_mail( $to, $subject, $body, $headers );
	
	 $table_name = $wpdb->prefix . 'webform_data';
	  $res = $wpdb->insert($table_name, array(
			    'zipcode' => $_POST["zipcode"],
			    'step2_opt' => $_POST["wpform_opt"],
			    'firstname' => $_POST["firstname"], 
			    'lastname' => $lastname,
			    'email' => $_POST["email"], 
			    'phone' => $phone, 
			    'project_info' => $project_info, 
			));
	 else:
            $errMsg = 'Robot verification failed, please try again.';
        endif;
		else:
    $errMsg = 'Recaptcha is mandatory';
    $succMsg = '';
endif;
 

}



?>
