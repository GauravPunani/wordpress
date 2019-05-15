<?php
   /*
   Plugin Name: Custom Plugin
   Plugin URI: http://quirkstory.com/
   description: Testing plugin
   Version: 1.0
   Author: Bliss IT
   Author URI: http://quirkstory.com/
   License: GPL2
   */

//~ define('WP_DEBUG', false);
//~ error_reporting(E_ALL);
//~ ini_set('display_errors', 1);

$url = plugin_dir_url(__FILE__);
define('PLUGIN_BASE_URL',$url);
// echo "<h1>".plugin_dir_url(__FILE__)."config.php</h1>";
global $plugin_title;
global $custom_enabled;
global $options;
global $content_key;
add_action('admin_menu', 'test_plugin_setup_menu');
function test_plugin_setup_menu(){

$plugin_title = "Content Egg 11";

	//hidden modules page
	add_menu_page( 'Alixapress',$plugin_title, 'manage_options','alixapress','custom_alixapres');
	add_submenu_page( null,'amazon', 'amazon','manage_options','custom_amazon','custom_amazon');
	add_submenu_page( null,'clickbank', 'clickbank','manage_options','custom_clickbank','custom_clickbank');
	add_submenu_page( null,'ebay', 'ebay','manage_options','custom_ebay','custom_ebay');
	add_submenu_page( null,'envato', 'envato','manage_options','custom_envato','custom_envato');
	add_submenu_page( null,'googlebooks', 'googlebooks','manage_options','custom_googlebooks','custom_googlebooks');
	add_submenu_page( null,'google images', 'google images','manage_options','custom_googleimages','custom_googleimages');
	add_submenu_page( null,'google news', 'google news','manage_options','custom_googlenews','custom_googlenews');
	add_submenu_page( null,'pixabay', 'pixabay','manage_options','custom_pixabay','custom_pixabay');
	add_submenu_page( null,'youtube', 'youtube','manage_options','custom_youtube','custom_youtube');
	add_submenu_page( null,'walmart', 'walmart','manage_options','custom_walmart','custom_walmart');

}

function global_notice_meta_box() {
	
	$screens = array( 'post', 'page');

    foreach ( $screens as $screen ) {
        add_meta_box(
            'custom_Plugin',
            'Content Egg 11',
            'custom_plugin_meta_callback',
            $screen
        );
	 }
	}

function custom_plugin_meta_callback(){
	global $options;
	global $post;

	$post_meta=get_post_meta($post->ID,'content_egg_11_meta',true);
	 // echo "<pre>";print_r($post_meta);die;
	$options=get_option('custom_enabled');
	
	//~ print_r($options);die;
	if(empty($options)){
		echo "Configure and activate modules of Content Egg 11 plugin";
	}
	else{
		//all work for api will be done here
			include plugin_dir_path(__FILE__).'search.php';
			if(is_array($options) && !empty($options)){
			foreach ($options as $key => $value) {
				?>
				<hr>
				<p><?= ucfirst($key); ?> results</p>
				<ul class="nav nav-tabs">
						<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#home_<?= $key; ?>">Search</a>
						</li>
						<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#menu1_<?= $key; ?>"><?= ucfirst($key); ?></a>
						</li>
				</ul>

					<div class="tab-content">
							<div class="tab-pane container active" id="home_<?= $key; ?>">
								<div class="form-group">
								<p><input class="form-controll"  type="text" placeholder="Search" id="search_<?= $key; ?>">
								<button type="button" class="btn btn-primary"  onclick="single_search('<?= $key; ?>','search_<?= $key; ?>')">Search</button></p>
								</div>
								<div id="<?= $key; ?>_data"></div>
							</div>
					<div class="tab-pane container fade" id="menu1_<?= $key; ?>">
						
						<!-- GET THE SAVED CONTENT -->
						<?php
						// echo "<pre>";print_r($post_meta);die;
						if(is_array($post_meta) && !empty($post_meta)){
							switch ($key) {
								case 'pixabay':
									if(array_key_exists($key, $post_meta)){
										include_once 'modules/pixabay/api.php';
											$obj=new Pixabay;
											echo $obj->showsaved($post_meta[$key]);
									}
									break;		
									case 'envato':
									if(array_key_exists($key, $post_meta)){
										include_once 'modules/envato/api.php';
											$obj=new envato;
											echo $obj->showsaved($post_meta[$key]);
									}
									break;
									case 'ebay':
										if(array_key_exists($key, $post_meta)){
											include_once 'modules/ebay/api.php';
											$obj=new ebay;
											echo $obj->showsaved($post_meta[$key]);
										}

									break;
									case 'googlebooks':

										if(array_key_exists($key, $post_meta)){
											include_once 'modules/googlebooks/api.php';
											$obj=new googlebooks;
											echo $obj->showsaved($post_meta[$key]);
										}

									break;

									case 'googlenews':
									if(array_key_exists($key, $post_meta)){
										include_once 'modules/googlenews/api.php';
										$obj=new googlenews;
										echo $obj->showsaved($post_meta[$key]);
									}
									break;

									case 'youtube':
									if(array_key_exists($key, $post_meta)){
										include_once 'modules/youtube/api.php';
										$obj=new Youtube;
										echo $obj->showsaved($post_meta[$key]);
									}
									break;
									case 'googleimages':
										if(array_key_exists($key, $post_meta)){
										include_once 'modules/googleimages/api.php';
										$obj=new googleimages;
										echo $obj->showsaved($post_meta[$key]);
									}
									break;
									case 'amazon':
										if(array_key_exists($key, $post_meta)){
											include_once 'modules/amazon/api.php';
											$obj=new amazon;
											echo $obj->showsaved($post_meta[$key]);
										}
									break;
									case 'walmart':
										if(array_key_exists($key, $post_meta)){
											include_once 'modules/walmart/api.php';
											$obj=new walmart;
											echo $obj->showsaved($post_meta[$key]);
										}
									break;
									case 'alixapress':
										if(array_key_exists($key, $post_meta)){
											include_once 'modules/alixapress/api.php';
											$obj=new alixapress;
											echo $obj->showsaved($post_meta[$key]);
										}
									break;
								default:
									# code...
									break;
							}
						}
						?>
							</div>
					</div>
				
				
				<?php
			}
		}


			
	}
}
add_action( 'wp_ajax_nopriv_get_all_api', 'get_all_api' );
add_action( 'wp_ajax_get_all_api', 'get_all_api' );
add_action( 'wp_ajax_nopriv_get_more_data', 'get_more_data' );
add_action( 'wp_ajax_get_more_data', 'get_more_data' );
add_action( 'wp_ajax_nopriv_get_single_api', 'get_single_api' );
add_action( 'wp_ajax_get_single_api', 'get_single_api' );
add_action( 'wp_ajax_nopriv_remove_content_11_meta', 'remove_content_11_meta' );
add_action( 'wp_ajax_remove_content_11_meta', 'remove_content_11_meta' );
add_action( 'wp_ajax_nopriv_save_content_egg_11_meta', 'content_egg_11_meta' );
add_action( 'wp_ajax_content_egg_11_meta', 'content_egg_11_meta' );
add_action( 'admin_head', 'my_custom_admin_head' );
add_action( 'admin_footer', 'my_action_javascript' );
add_action( 'wp_enqueue_scripts', 'my_plugin_scripts_and_styles' );

function get_more_data(){
		//initializing the variables
	$module_name=$_POST['module_name'];
	$pageoffset=$_POST['pageoffset'];
	$query=$_POST['query'];
	//call the module for data
	$data=array();
	include_once 'modules/'.$module_name.'/api.php';
	$obj=new $module_name();
	$temp=$obj->getdata($query,$pageoffset);
	list($data['arr'][$module_name],$totalcount)=$obj->parseResult($temp);
	$data['api'][$module_name."_data"]=$obj->preparehtml($data['arr'][$module_name],$totalcount,$query,$pageoffset);

	echo json_encode($data);
	die;
}

function my_plugin_scripts_and_styles(){
	 wp_register_style( 'my-plugin-css', plugin_dir_url( __FILE__ ) . 'assets/css/front.css',  false );
  wp_enqueue_style( 'my-plugin-css' );
}

function my_custom_admin_head(){
	?>
	<link rel="stylesheet" href="<?= plugin_dir_url( __FILE__ ) . 'assets/css/front.css'; ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= plugin_dir_url( __FILE__ ) . 'assets/css/mystyle.css'; ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	<?php

}
function remove_content_11_meta(){
	$post_id=$_POST['post_id'];
	$module_name=$_POST['module_name'];
	$key=$_POST['key'];
	$meta=get_post_meta($post_id,'content_egg_11_meta',true);
	unset($meta[$module_name][$key]);
	update_post_meta($post_id,'content_egg_11_meta',$meta);
	die;
}
function get_single_api(){
	
	//initializing the variables
	$module_name=$_POST['module_name'];
	$query=$_POST['query'];
	//call the module for data
	$data=array();
	include_once 'modules/'.$module_name.'/api.php';
	$obj=new $module_name();
	$temp=$obj->getdata($query);
	list($data['arr'][$module_name],$totalcount)=$obj->parseResult($temp);
	$data['api'][$module_name."_data"]=$obj->preparehtml($data['arr'][$module_name],$totalcount,$query);
		
	echo json_encode($data);
	die;
}

function get_all_api(){
		$query=$_POST['query'];
		// echo $query;
		$options=$_POST['opt'];
		// print_r($options);die;
		$data=array();
		if(array_key_exists('ebay',$options)){
				include_once 'modules/ebay/api.php';
				$obj=new ebay;
				$temp=$obj->getdata($query);
				list($data['arr']['ebay'],$totalcount)=$obj->parseResult($temp);
				$data['api']['ebay_data']=$obj->preparehtml($data['arr']['ebay'],$totalcount,$query);
		}
		if(array_key_exists('googlenews',$options)){
				include_once 'modules/googlenews/api.php';
				$obj= new googlenews;  
				$temp=$obj->getdata($query);
				list($data['arr']['googlenews'],$totalcount)=$obj->parseResult($temp);
				$data['api']['googlenews_data']=$obj->preparehtml($data['arr']['googlenews'],$totalcount,$query);
		}
		if(array_key_exists('youtube',$options)){
				include_once 'modules/youtube/api.php';
				$obj=new Youtube;
				$result=$obj->getdata($query);
				list($data['arr']['youtube'],$totalcount)=$obj->parseResult($result);
				$data['api']['youtube_data']=$obj->preparehtml($data['arr']['youtube'],$totalcount,$query);
		}
		if(array_key_exists('googlebooks',$options)){
				require_once  'modules/googlebooks/api.php';
				$obj = new googlebooks;  
				$results=$obj->getdata($query);  
				list($data['arr']['googlebooks'],$totalcount)=$obj->parseResult($results);
				$data['api']['googlebooks_data']=$obj->preparehtml($data['arr']['googlebooks'],$totalcount,$query);   
		}
		if(array_key_exists('pixabay',$options)){
				require_once  'modules/pixabay/api.php';
				$obj = new Pixabay;   
				$results=$obj->getdata($query);
				list($data['arr']['pixabay'],$totalcount)=$obj->parseResult($results);
				$data['api']['pixabay_data']=$obj->preparehtml($data['arr']['pixabay'],$totalcount,$query);  
		}
		if(array_key_exists('envato',$options)){
				require_once  'modules/envato/api.php';
				$obj = new envato;   
				$result=$obj->getdata($query);
				list($data['arr']['envato'],$totalcount)=$obj->parseResult($result);
				$data['api']['envato_data']=$obj->preparehtml($data['arr']['envato'],$totalcount,$query);
		}
		if(array_key_exists('googleimages',$options)){
					require_once 'modules/googleimages/api.php';
					$obj=new googleimages;
					$result=$obj->getdata($query);
					// print_r($result);die;
					list($data['arr']['googleimages'],$totalcount)=$obj->parseResult($result);
					$data['api']['googleimages_data']=$obj->preparehtml($data['arr']['googleimages'],$totalcount,$query);
		}
		if(array_key_exists('amazon',$options)){
			require_once 'modules/amazon/api.php';
			$obj=new amazon;
			$parsed_xml=$obj->getdata($query);
			list($data['arr']['amazon'],$totalcount)=$obj->parseResult($parsed_xml);
			$data['api']['amazon_data']=$obj->preparehtml($data['arr']['amazon'],$totalcount,$query);
			// echo "<pre>";print_r($data);
		}
		if(array_key_exists('walmart',$options)){
			require_once 'modules/walmart/api.php';
			$obj=new walmart;
			$parsed_xml=$obj->getdata($query);
			list($data['arr']['walmart'],$totalcount)=$obj->parseResult($parsed_xml);
			$data['api']['walmart_data']=$obj->preparehtml($data['arr']['walmart'],$totalcount,$query);
			// echo "<pre>";print_r($data);
		}
		if(array_key_exists('alixapress',$options)){
			require_once 'modules/alixapress/api.php';
			$obj=new alixapress;
			$parsed_xml=$obj->getdata($query);
			list($data['arr']['alixapress'],$totalcount)=$obj->parseResult($parsed_xml);
			$data['api']['alixapress_data']=$obj->preparehtml($data['arr']['alixapress'],$totalcount,$query);
			// echo "<pre>";print_r($data);
		}
		echo json_encode($data);
	die;
}
function content_egg_11_meta(){
	$post_id=$_POST['post_id'];
	$module_name=$_POST['api_name'];
	$item_key=$_POST['item_key'];
	$data=$_POST['data_to_store'];
	//~ print_r($data);die;
	//get the post meta if exist before
	$content_meta=array();
	$content_meta=get_post_meta($post_id,'content_egg_11_meta',true);
	if(is_array($content_meta))
	{
		//adding the data to the meta array
			$content_meta[$module_name][$item_key]=$data;
	}	
	else{
			
			$content_meta=array();
			$content_meta[$module_name][$item_key]=$data;
		}
		
	//update the post meta array
	update_post_meta($post_id,'content_egg_11_meta',$content_meta);
	//get the post meta after update and return it
	$meta=get_post_meta($post_id,'content_egg_11_meta',true);
		
	//include the module file by calling 
	include_once 'modules/'.$module_name.'/api.php';
	$obj=new $module_name();
	$res=$obj->getsinglerecord($item_key,$data,$post_id);
	echo $res;
	// echo json_encode($meta[$module_name][$item_key]);
	// include_once include_once 'modules/'.$module_name.'/api.php';;
	//calling the maped class for the data to append in the another tab to list the saved once
	
	die;

}

function my_action_javascript()
{
	include_once plugin_dir_path(__FILE__).'assets/js/api.php';
}


function custom_egg()
{
	include_once dirname(__FILE__)."/settings.php";
}


register_activation_hook( __FILE__, 'my_plugin_create_db' );
register_deactivation_hook( __FILE__, 'custom_deactivate' );
register_uninstall_hook(__FILE__, 'custom_uninstall');

function my_plugin_create_db() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'custom_plugin';
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		meta_key varchar(255),
		meta_value longtext,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	// include_once plugin_dir_url(__FILE__)."config.php";
		$data=['general','alixapress','amazon','clickbank','ebay','envato','googlebooks','googleimages','googlenews','pixabay','youtube','walmart'];
		foreach ($data as $key => $value) {
			$d=[
				'meta_key'=>$value,
				'meta_value'=>''
			];
			$wpdb->insert($table_name,$d);
		}
	}

}

// function custom_activate(){
	
// 		array( 'MyPlugin', 'install' )
// }
function custom_deactivate(){
	//~ delete_option('custom_enabled');
}
function custom_uninstall(){
		delete_option('custom_enabled');
}
function custom_product(){
	include dirname(__FILE__)."/products.php";
}
function custom_alixapres()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/alixapress/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('alixapress',$data,$key);
	}
	
}
function custom_amazon()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/amazon/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('amazon',$data,$key);
	}
}
function custom_clickbank(){
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/clickbank/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('clickbank',$data,$key);
	}
}
function custom_ebay()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/ebay/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('ebay',$data,$key);
	}
}
function custom_envato()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/envato/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('envato',$data,$key);
	}
}
function custom_googlebooks()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/googlebooks/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('googlebooks',$data,$key);
	}
}
function custom_googleimages()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/googleimages/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('googleimages',$data,$key);
	}
}
function custom_googlenews()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/googlenews/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('googlenews',$data,$key);
	}
}
function custom_pixabay()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/pixabay/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('pixabay',$data,$key);
	}
}
function custom_youtube()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/youtube/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('youtube',$data,$key);
	}
}
function custom_walmart()
{
	include_once plugin_dir_path(__FILE__)."header.php"; 
	include_once 'modules/walmart/views/config.php';
	if($_SERVER['REQUEST_METHOD']=='POST'){
	check_api_enabled('walmart',$data,$key);
	}
}

function check_api_enabled($name,$data,$key){
	if($key){
			

		$options=get_option('custom_enabled');
		if(array_key_exists('is_active', $data)){
			// echo "is active";
			$options[$name]='true';
			update_option('custom_enabled',$options);

		}
		else{
			echo "not active";
			if(array_key_exists($name,$options)){
				echo "key exist";
				unset($options[$name]);
				update_option('custom_enabled',$options);
			}
		}
		
	
	}
	
}

//append the content in body
add_action('wp_head', 'add_bootstrap');
add_filter( 'the_content', 'wpse6034_the_content' );
function wpse6034_the_content($content){
	global $wpdb;
	global $post;
	// if(is_home()){echo "homepage";die;}
	// echo "<pre>";print_r($post);die;
				$content_meta=get_post_meta($post->ID,'content_egg_11_meta',true);
				//loop over the content meta and get the modules by key of it and get the frontend view for the module with data and return it
				// echo count($content_meta);die;
				// echo "<pre>";print_r($content_meta);die;
				$data=array();
				if(is_array($content_meta) && !empty($content_meta)){
				foreach($content_meta as $key=>$val){

					//get the settings for module
						$module_setting=cg11_get_setting_fields($key);
						if(array_key_exists('is_active',(array)$module_setting)){
							// echo "<pre>";print_r($module_setting);die;
							if(is_array(array($module_setting)) && !empty((array)$module_setting)){
							//get the template view from module class
								$data[$key]=cg11_get_template_frontend($key,$module_setting,$content_meta[$key]);
								}
						}
						

				}
				// print_r($data);die;
				if(is_array($data) && !empty($data)){
							foreach($data as $key=> $val){
							$content .=$val;
							}
				}
					}
				
					return $content;


				
		die;
		
	//for ebay
	if(is_array($content_meta) && !empty($content_meta)){
		if(array_key_exists('ebay',$content_meta)){
			foreach ($content_meta['ebay'] as $key => $value) {
				if(array_key_exists('status', $value)){
				?>
				<div class="row">
					<div class="col-sm-3">
						<img src="<?= $value['galleryURL']; ?>" alt="">
					</div>
					<div class="col-sm-9">
						<h3><?= $value['title']; ?></h3>
						<p><b>USD</b> <?= $value['currentPrice']; ?></p>

					</div>
				</div>
				<?php
				}
			}
		}

		
		// for youtube

		if(array_key_exists('youtube',$content_meta)){
			$html="<div class='container'>";
			foreach ($content_meta['youtube'] as $key => $item) {
				if(array_key_exists('status', $item)){
						if(isset($item['videoId'])){

							$videoId=$item['videoId'];

							$html .="<div class='row' ";
							$html.="<div class='col-sm-12'>";
							$html.="<iframe  width='100%' height='250' src='https://www.youtube.com/embed/".$videoId."' frameborder='0' allowfullscreen='' ></iframe>";
							$html.="</div>";
							$html.="<div class='col-sm-12'>";
							$html.="<h3>".$item['title']."</h3>";
							$html.="<p>".$item['description']."</p>";
							$html.="</div>";
							$html.="</div>";
						}

					}
					
			}
			$html .="</div>";
			echo $html;
		}


		//FOR GOOGLE NEWS
		if(array_key_exists('googlenews',$content_meta)){
			$google_news="<ul>";
			foreach ($content_meta['googlenews'] as $key => $value) {
				if(array_key_exists('status', $value)){
						$google_news .="<li class='' >".$value['title']."</li>";
				}
			}
			$google_news .="</ul>";
			echo $google_news;
		}

		//for envato
		if(array_key_exists('envato',$content_meta)){
			// echo "<pre>";print_r($content_meta['envato']);die;
			$html="<div class='container'>";
		$i=0;
		foreach($content_meta['envato'] as $key=>$item)
		{
			if(array_key_exists('status', $item)){
			$imagearray='';
			if($item['img_url']!='')
			{
				$imagearray=$item['img_url'];
			}
			$html.="<div class='row'>" ;
			$html.="<div class='col-sm-12'>";
			$html.="<img width='100%'  src='".$imagearray."'  >";
			$html.="</div>";

			$html.="<div class='col-sm-12'>";
			$html.="<h3>".$item['name']."</h3>";
			$html.="<p>".$item['description']."</p>";
	
			$html.="<p>USD ".$item['price']."</p>";
			$html.="</div>";
			$html.="</div>";
			}
			
		}
		
		$html.="</div>";

		echo  $html;
		}

		// for googlebooks
		if(array_key_exists('googlebooks',$content_meta)){
				$html='';
              foreach($content_meta['googlebooks'] as $key=>$value){
                   if(array_key_exists('status', $value)){
	                  $html .='<div class="row " id=googlebooks_'.$key.'>'; 
	                  if($value['thumbnail']!=''){
	                    $html .= '<div class="col-sm-1"><img width="20px" height="20px" src="'.$value['thumbnail'].'" alt=""></div>';
	                  }
	                  else{
	                    $html .= '<div class="col-sm-1"><img width="20px" height="20px" alt=""></div>';
	                  }  

	                  
	                  $html .='<div class="col-sm-11">';
	                  $html .='<h4>'.$value['title'].'</h4>';
	                  if($value['description']!=''){
	                    $html .='<p>'.$value['description'].'</p>';
	                  }
	                  
	                  $html .='</div>';
	                  $html .='</div>';
              	}
              }
              echo  $html;
		}
		//for pixabay
		if(array_key_exists('pixabay',$content_meta)){

				$html='<div class="container">';
				foreach($content_meta['pixabay'] as $key=>$item){
					if(array_key_exists('status', $item)){
						$html.="<div class='row ' id=pixabay_".$key.">";
						$html.="<div class='col-sm-12'>";
						$html.="<img width='100%'  src='".$item['img_url']."' frameborder='0' allowfullscreen='' >";
						$html.="</div>";
						$html.="</div>";
					}
				}
					$html .="</div>";
					echo  $html;
		}	

		//for Google Images
		if(array_key_exists('googleimages',$content_meta)){

			$results ='<div class="container">';
				foreach ($content_meta['googleimages'] as $key => $value) {
						if(array_key_exists('status', $value)){
							$results .="<div class='row ' id='googleimages_".$key."'>";
							$results .="<div class='col-sm-12'>";
							$results .="<img class='img-fluid' src=".$value['link']." alt='#'>";
							$results .="</div>";
							$results .="</div>";
					}
				}
			$results .="</div>";
			echo  $results;
		}
		//for amazon
		if(array_key_exists('amazon',$content_meta)){
					$data=cg11_get_setting_fields('amazon');
					//~ print_r($data);die;
					if(is_array(array($data)) && !empty((array)$data)){
							//get the template view from module class
							//~ echo "there";die;
							cg11_get_template_frontend('amazon',$meta_data,$content_meta['amazon']);
					}
					die;
				$html ='<div class="container">';
				foreach ($content_meta['amazon'] as $key => $value) {
					//get the settings field data for the module
					
						if(array_key_exists('status', $value)){

							$html .="<div class='row copy_div' id='amazon_".$key."'>";
							$html.="<div class='col-sm-6'>";
							$html .="<a rel='nofollow' target='_blank' href=".$value['link']."><img class='img-fluid' src=".$value['img_url']." alt='#'></a>";
							$html.="</div>";
							$html .="<div class='col-sm-6'>";
							$html .="<h4>".$value['title']."</h4>";
							$html .="<strike>".$value['price']."</strike>";
							$html .="<h4>".$value['currency_code']." ".$value['lowest_new_price']."</h4>";
							if(array_key_exists('lowest_new_price',$value)){
								$html .="<p>".$value['TotalNew']." new from ".$value['lowest_new_price']."</p>";	
							}
							if(array_key_exists('lowest_used_price', $value))
									$html .="<p>".$value['TotalUsed']." used from ".$value['lowest_used_price']."</p>";
							
							$html .="<a rel='nofollow' target='_blank' href=".$value['link']."><button class='btn btn-success'>Buy Now</button></a>";
							
									

							$html .="</div>";
							$html .="</div>";

						}
				}

				$html .="</div>";
				echo  $html;
		}


	}
	
	

	return $content;

}
function add_bootstrap(){
	?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<?php
}


// add_action( 'publish_post', 'post_published_notification', 10, 2 );


add_action( 'add_meta_boxes', 'global_notice_meta_box' );

add_action('save_post', 'post_published_notification', 10, 2 );
function post_published_notification($ID,$post){
	// echo "got called";die;
	$meta=get_post_meta($ID,'content_egg_11_meta',true);
	// echo "<pre>";print_r($meta);die;
	// if($post->post_type=='post'){

		if(is_array($meta) && !empty($meta)){
			foreach ($meta as $module => $value) {
		foreach ($value as $key => $v) {
			$meta[$module][$key]['status']='true';
		}
			
		}
		update_post_meta($ID,'content_egg_11_meta',$meta);
	}
	// }
	
	
	// echo "<pre>";print_r($meta);die;

	
}

function cg11_get_setting_fields($module_name){
		global $wpdb;

		 $result = $wpdb->get_results ("
		SELECT * 
		FROM  wp_custom_plugin
		WHERE  meta_key= '$module_name'
		" );
		//~ print_r($result);die;
		$data=json_decode($result[0]->meta_value);
		return $data;
	}
	
function cg11_get_template_frontend($module_name,$module_settings,$content_data){
			//load the module file
			include_once "modules/".$module_name."/api.php";
			$obj=new $module_name();
			$data=$obj->get_template_frontend($module_settings,$content_data);
			return $data;
}
