<?php
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
	/*update_option( 'wpform_title_s1', " What is the location of your project? ");
	update_option( 'wpform_marker_text', "Zip Code");
	update_option( 'wpform_title_s2', "What is the nature of this project? *");
	update_option( 'wpform_opt_s2', '["Completely replace roof","Install roof on new construction"," Repair existing roof"] ');
	update_option( 'wpform_title_s3', "We have matching metal roof contractors in your area !");
	update_option( 'wpform_subtitle_s3', "Get quotes from up to 4 prescreened pros now");
	update_option( 'wpformlayout', "1");
 */
	update_option( 'btn_clr', '#49a1a7');
	update_option( 'wpform_fontfamily', 'Helvetica');
	update_option( 'wpform_titlefontsize', '18');
	update_option( 'wpform_titlefontwt', 'Bold');
	update_option( 'wpform_contentfontsize', '14');
	update_option( 'wpform_contentfontwt', 'Normal');

	update_option( 'wpformlayout', "1");
	update_option( 'wpform_fontfamily', "Montserrat");
	update_option( 'wpform_labels1', '["First Name *","Last Name *","Email","Phone"]'); 
	update_option( 'wpform_labels2','["First Name *","Last Name *","Email","Phone"]'); 
	update_option( 'wpform_labels3', '["Name","Email/Phone"] '); 


?>
