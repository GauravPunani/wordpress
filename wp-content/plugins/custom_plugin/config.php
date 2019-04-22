<?php

class config {

	public function getapis()
	{
		$data=['aliexpress','amazon','clickbank','ebay','envato','googlebooks','google_images','google_news','pixabay','youtube','walmart'];
		return $data;
	}

	public function get_options($meta_key){
		global $wpdb;
		$data=$wpdb->get_results( "SELECT * FROM wp_custom_plugin WHERE meta_key =$meta_key" );
		return json_decode($data);
	}
	
}