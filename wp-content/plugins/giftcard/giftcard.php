<?php
   /*
   Plugin Name: Gift Card
   Plugin URI: http://hourlylancer.com/
   description:a gift card plugin
   Version: 1.0
   Author: Mr. Unknown
   Author URI: http://unknown.com
   License: GPL2
   */
   
   //REGISTER HOOKS
   register_activation_hook(__FILE__,'myplugin_activate');
   register_deactivation_hook(__FILE__,'myplugin_deactivate');
   register_uninstall_hook(__FILE__,'myplugin_uninstall');
   
   
   
   //ADD ACTION HOOKS
   add_action( 'init', 'create_gift_card_post' );
	/* Filter the single_template with our custom function*/
	add_filter('single_template', 'my_custom_template');
	function my_custom_template($single) {

		global $post;

		/* Checks for single template by post type */
		if ( $post->post_type == 'giftcards' ) {
			if ( file_exists( dirname(__FILE__) . '/single-giftcards.php' ) ) {
				return dirname(__FILE__) . '/single-giftcards.php';
			}
		}

		return $single;

	}   
   function create_gift_card_post(){
	   
		 $labels = array(
        'name'                => _x( 'Gift Card', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Gift Card', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Gift Cards', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent Gift Card', 'twentythirteen' ),
        'all_items'           => __( 'All Gift Cards', 'twentythirteen' ),
        'view_item'           => __( 'View Gift Cards', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New Gift Card', 'twentythirteen' ),
        'add_new'             => __( 'Add Gift Cards', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Gift Cards', 'twentythirteen' ),
        'update_item'         => __( 'Update Gift Cards', 'twentythirteen' ),
        'search_items'        => __( 'Search Gift Cards', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
		);
     
// Set other options for Custom Post Type
     
		$args = array(
			'label'               => 'GIFT CARDS',
			'description'         => 'Gift Card Post type',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
    
        register_post_type( 'giftcards', $args );
        
	}
   add_action( 'add_meta_boxes', 'add_events_metaboxes' );
   add_action( 'save_post', 'save_gift_card_data', 10, 2);
   
   function save_gift_card_data($post_id, $post){
	   //~ echo "<pre>";print_r($_POST);die;
		if(!isset( $_POST['wp_giftcard_nounce'] ) || !wp_verify_nonce( $_POST['wp_giftcard_nounce'], basename( __FILE__ )))
				return $post_id;
    
		  /* Get the post type object. */
		  $post_type = get_post_type_object( $post->post_type );

		  /* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
			return $post_id;
				
				
				if(isset($_POST['gift_card_type']))
						update_post_meta($post_id,'gift_card_type',$_POST['gift_card_type']);
		//~ echo "<pre>";print_r($_POST);die;
		
	
	}
   //FUNCTIONS
   function add_events_metaboxes(){
		
			add_meta_box(
				   'gift_card_type',       // $id
				   'Select Gift Type',                  // $title
				   'show_custom_meta_box_2',  // $callback
				   'giftcards',                 // $page
				   'normal',                  // $context
				   'high'                     // $priority
			   );
	
	}
	function show_custom_meta_box_2() {
		global $post;

		// Use nonce for verification to secure data sending
		wp_nonce_field( basename( __FILE__ ), 'wp_giftcard_nounce' );
			$meta=get_post_meta($post->ID,'gift_card_type',true);
		?>
		
		<!-- my custom value input -->
		<select name="gift_card_type">
		<option value="buying" <?= $meta=='buying' ? 'selected':''; ?>>Buying Gift Card</option>
		<option value="exchange" <?= $meta=='exchange' ? 'selected':''; ?>>Exchange Gift Card</option>
		</select>

		<?php
	}
   function myplugin_activate(){
		//~ echo "hello";die;
		create_gift_card_post();
        flush_rewrite_rules();
	}
	function myplugin_deactivate(){
			//~ echo "deactivate";die;
	}
	function myplugin_uninstall(){
			
		}
	
	
		add_action( "wp_ajax_gift_purchase", "gift_purchase" );
		add_action( "wp_ajax_nopriv_gift_purchase", "gift_purchase" );
		
		function gift_purchase(){
			
			echo '<header class="masthead">
		
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 text-left">
        <h1 class="font-weight-light">The Currys PC World <br> Gift Card Shop </h1>
        <p class="lead">Get instantly, Shop instantly,<br> Hundreds of leading stores</p>
        <p><button class="btn btn-success view_all_succes">Get Bonus!</button></p>
      </div>
    </div>
  </div>
</header>
<div class="container steps_parent">
	
	<div class="steps" id="step_1">
		<h1 class="text-center">Choose From Loads of top brands</h1>
<!--row 1-->
		<div class="row">
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url("assets/img/MS.png",__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">MS</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/Currys-PC-World-6.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">Currys-PC-World-6</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/Decathlon.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">Decathlon</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/New-Look LRG Prod img.png',__FILE__).'" alt="Card ima€ge cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">New-Look LRG Prod img</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep" style="width: 18rem;">
					<img class="card-img-top" src="'.plugins_url('assets/img/PE-Lrg-Prod-Img-Aug12.gif',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">PE-Lrg-Prod-Img-Aug12</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/Primark_on_VoucherExpress.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">Primark</a></div>
					</div>
				</div>
			</div>
			
		</div>
<!--row 2-->
		<div class="row">
			
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/Sports Direct  gift card.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">Sports Direct</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep" >
					<img class="card-img-top" src="'.plugins_url('assets/img/Starbucks-LRG-Prod-IMG.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">Starbucks</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/Tesco-LRG-Product-IMG.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">Tesco</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/Thomas-Cook  gift card.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">Thomas-Cook</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/card.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">card</a></div>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card nextstep">
					<img class="card-img-top" src="'.plugins_url('assets/img/john-lewis--gift-card.png',__FILE__).'" alt="Card image cap">
					<div class="card-body">
						<div class="card-footer"><a href="#" class="">John-Lewis</a></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="text-center">
			<button class="btn btn-primary view_all_succes">View All</button>
		</div>
	
	</div>
	
</div>';
wp_die();
		}
		
		
		add_action( "wp_ajax_complete_order", "complete_order" );
		add_action( "wp_ajax_nopriv_complete_order", "complete_order" );
		
		
		function complete_order(){
				
				echo '<section id="curry_world">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="debenhans_bit">
					<img src="'.plugins_url('assets/img/Currys-PC-World-6.png',__FILE__).'">
					<h3>Debenhams eGift Cards</h3>
						
						<ul>
							<li><i class="fa fa-map-marker" aria-hidden="true"></i> Redeem in-store & online</li>
							<li><i class="fa fa-mobile" aria-hidden="true"></i> E-gift-card</li>
						</ul>
						
						<p>

				<div class="word_range">						
					<h6 data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-info-circle" aria-hidden="true"></i> How it work?</h6
					</h6>
				
					<div class="collapse" id="collapseExample">
					
					<p>Debenhams is a world famouse biritish department store,it sells a range of clothing, household items...<span>Read More...</span></p>
					
					</div>
				</div>
				
				
				<div id="accordion" role="tablist">
					  <div class="card">
						<div class="card-header" role="tab" id="headingOne">
						  <h5 class="mb-0">
							<a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							 <span class="euro">€</span> How to Redeem?
							</a>
						  </h5>
					</div>
					<div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
						  <div class="card-body">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
						  </div>
					</div>
					</div>
					<div class="card">
						<div class="card-header" role="tab" id="headingTwo">
						  <h5 class="mb-0">
							<a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							  <i class="fa fa-window-restore" aria-hidden="true"></i> Swapit Worry-Free Gifting
							</a>
						  </h5>
					</div>
					<div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
						  <div class="card-body">
							Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
						  </div>
					</div>
					</div>

</div>
					
					
				</div>
			</div>
			
			
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div id="form_me">
					<h6>1. Who is it for</h6>
					<a class="active active_disactive" href="#">For me?</a><span></span>
					<a class="active_disactive" href="#"><i class="fa fa-gift"></i> As a Gift</a>

				</div>
				
				<div id="gift_card">
					<h6>2. Gift Card Value</h6>
					
					<div id="quantity_add">
					
					<div id="field1" class="quantity_add">
						<div class="float-left">
						<h6>25.00<span>Exp: 23/05/2019</span></h6></div>
												<div class="float-right sub_text">
						<div class="quantity_cart">
						<span class="add_sub">-</span>
						<span  class="one_quantity">1</span>
						<span class="add_sub">+</span>
						</div>
						</div>
					</div>
					<div id="field2" class="quantity_add">
					<div class="float-left">
						<h6>50.0<span>Exp: 23/05/2019</span></h6>
					</div>
					<div class="float-right sub_text">
					<div class="quantity_cart">
					<span class="add_sub">-</span>
					<span  class="one_quantity">1</span>
					<span class="add_sub">+</span>
					</div></div>
					</div>
					
					<div id="field3" class="quantity_add">
					<div class="float-left">
						<h6>25.0<span>Exp: 23/05/2019</span></h6>
					</div>
						<div class="float-right sub_text">
						<div class="quantity_cart">
						<span class="add_sub">-</span>
						<span  class="one_quantity">1</span>
						<span class="add_sub">+</span>
						</div>
						</div>
					</div>
					</div>
					
					<div class="total">
						<div class="float-left">Total Selected:</div>
						<div class="float-right">1</div>
					</div>
					<div class="total">
					<div class="float-left">Total Value:</div>
						<div class="float-right">$25.00</div>
					</div>
					
					<button id="review_checkout" type="button" class="btn btn-link">REVIEW AND CHECKOUT</button>
					

				</div>
			</div>
			

			</div>
		</div>
	</section>';
				
				wp_die();
		}
		
		add_action( "wp_ajax_gift_checkout", "gift_checkout" );
		add_action( "wp_ajax_nopriv_gift_checkout", "gift_checkout" );


		function gift_checkout(){
				
				echo '<section id="checkout">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="debenhans_bit">
					<img src="'.plugins_url('assets/img/Currys-PC-World-6.png',__FILE__).'">
					<h3>Card Number</h3>
					<h3>Expiery</h3>
					<h3>CVV</h3>
					<h3>Name on Card</h3>
						

				</div>
			</div>
			
			
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div id="form_me">
					<h6>1. Who is it for</h6>
					<a class="active active_disactive" href="#">For me?</a><span></span>
					<a class="active_disactive" href="#"><i class="fa fa-gift"></i> As a Gift</a>

				</div>
				
				<div id="gift_card">
					<h6>2. Gift Card Value</h6>
					
					<div id="quantity_add">
					
					<div id="field1" class="quantity_add">
						<div class="float-left">
						<h6>25.00<span>Exp: 23/05/2019</span></h6></div>
							<div class="float-right sub_text">
							<div class="quantity_cart">
							<span class="add_sub">-</span>
							<span class="one_quantity">1</span>
							<span class="add_sub">+</span>
							</div>
							</div>
					</div>
					</div>
					
					<div class="total">
						<div class="float-left">Total Selected:</div>
						<div class="float-right">1</div>
					</div>
					<div class="total">
					<div class="float-left">Total Value:</div>
						<div class="float-right">$25.00</div>
					</div>
					
					<button id="complete_order" type="button" class="btn btn-link">PAY</button>
					

				</div>
			</div>
			

			</div>
		</div>
	</section>';
				
				wp_die();
		}
		add_action( "wp_ajax_complete_transaction", "complete_transaction" );
		add_action( "wp_ajax_nopriv_complete_transaction", "complete_transaction" );
		
	function complete_transaction(){
			
			echo '<section id="Transaction">
		<div class="container">
			<div class="row">
			<div class="col-md-3"></div>
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="debenhans_bit">
					<img src="'.plugins_url('assets/img/Currys-PC-World-6.png',__FILE__).'">
					<h3>Currys PC World</h3>
						<ul>
							<li><i class="fa fa-map-marker" aria-hidden="true"></i> Redeem in-store & online</li>
							<li><i class="fa fa-mobile" aria-hidden="true"></i> E--gift-card</li>
						</ul>
						

				<div class="word_range">						
					<h6 >your gift card value</h6>
					
						<h2><span class="euro">€</span>100.00</h2>
						<h3>Card Number:324982093302</h3>
						<h3>Pin:32424</h3>
				</div>
	
					
				</div>
			</div>
				
				<div class="col-md-3"></div>
			</div>
		</div>
	</section>';
		
			wp_die();
	}
	add_action( "wp_ajax_gift_exchange_home", "gift_exchange_home" );
	add_action( "wp_ajax_nopriv_gift_exchange_home", "gift_exchange_home" );
	
	function gift_exchange_home(){
			
			echo '<section id="unmwanted_gift">
		
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 text-left">
        
        <h1 class="text-white text-center">Swap unwanted gift cards!</h1>
      </div>
    </div>
  </div>
</section>


<section class="search_feedback">
	<div class="container">  
		<div class="search_card_form">
		<div class="row">

		<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
			<div class="form-group has-search">
			<span class="fa fa-search form-control-feedback"></span>
			<input type="text" id="search_steam" class="form-control" placeholder="Steam" autofocus>
			
			<div id="group_list_add">
			<div class="list_search">
				<div class="card_name">
					<img class="card-img-top" src="http://hourlylancer.com/beta/clientsdemo/steempress/wp-content/plugins/giftcard/assets/img/MS.png" alt="Card image cap">
					<div class="steam_online">
						<h6>Steam<br><span>Online use</span><br></h6>
					</div>
				</div>
			</div>
			
			<div class="add_store_list">
								<div class="add_store">
					<i class="fa fa-plus-circle" aria-hidden="true"></i>
					<div class="store_name">
						<h6>Store not listed? Enter the full brand name then click here to continue.</h6>
					</div>
				</diV>
			</div>
			
			</div>
			</div>

		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
		
			<div class="market_value">
				<span class="euor_market"> <span>€</span><span class="line_euor">|</span>	
					<input type="text" name="fname" placeholder="€100">
				</span>
				<span id="gift_exhange_page" class="market_valuesee">See Market Value</span>
				
			</div>
		
		</div>
		
	</div>
	</div>
	</div>
</section>


<section id="safe_quick">
	
	<div class="container">
		<div class="row">
			<div class="swapping_gift text-center">
				<h3>Swapping gift cards with is quick, easy and safe</h3>
				<img src="'.plugins_url('assets/img/lock.png',__FILE__).'">
				<h4>Prompt and <br>secure swapping</h4>
			</div>
		</div>
	</div>

</section>';
		
			wp_die();
	}
	add_action( "wp_ajax_gift_exhange_page", "gift_exhange_page" );
	add_action( "wp_ajax_nopriv_gift_exhange_page", "gift_exhange_page" );

	function gift_exhange_page(){
		
		echo '<section id="curry_card">
		<div class="container">
			<div class="gift_choosen">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 gift">
				<div class="debenhans_bit">
				<h6>Your Gift Card</h6>
					<img class="card-img-top" src="http://hourlylancer.com/beta/clientsdemo/steempress/wp-content/plugins/giftcard/assets/img/MS.png" alt="Card image cap">
					<h3>Steam</h3>
						
						<ul>
							<li><i class="fa fa-map-marker" aria-hidden="true"></i> Redeem in-store &amp; online</li>
							<li><i class="fa fa-mobile" aria-hidden="true"></i> E-gift-card</li>
						</ul>
						
						<div class="word_range">						
					<h6>your gift card value</h6>
					
						<h2><span class="euro">€</span>100.00</h2>
				</div>
		
				</div>
			</div>
			
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 gift">
				<div class="debenhans_bit">
				<h6>Choosen Gift Card</h6>
					<img src="http://hourlylancer.com/beta/clientsdemo/steempress/wp-content/plugins/giftcard/assets/img/Currys-PC-World-6.png">
					<h3>Currys PC World</h3>
						
						<ul>
							<li><i class="fa fa-map-marker" aria-hidden="true"></i> Redeem in-store &amp; online</li>
							<li><i class="fa fa-mobile" aria-hidden="true"></i> E-gift-card</li>
						</ul>
						
						<div class="word_range">						
					<h6>your gift card value</h6>
					
						<h2><span class="euro">€</span>100.00</h2>
				</div>
		
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12"></div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 gift">
			<div class="swap_cards"><button id="exchange_review_checkout" type="button" class="btn btn-link float-right swap_card">Swap Cards</button></div>
			</div>
	</div>

			</div>
		</div>
	</section>';
			wp_die();
	}
	add_action( "wp_ajax_exchange_review_checkout", "exchange_review_checkout" );
	add_action( "wp_ajax_nopriv_exchange_review_checkout", "exchange_review_checkout" );
	
	function exchange_review_checkout(){
			
			echo '<section id="Transaction">
		<div class="container">
			<div class="row">
			<div class="col-md-3"></div>
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="debenhans_bit">
				<h6>Choosen Gift Card</h6>
					<img src="http://hourlylancer.com/beta/clientsdemo/steempress/wp-content/plugins/giftcard/assets/img/Currys-PC-World-6.png">
					<h3>Currys PC World</h3>
						<ul>
							<li><i class="fa fa-map-marker" aria-hidden="true"></i> Redeem in-store &amp; online</li>
							<li><i class="fa fa-mobile" aria-hidden="true"></i> E--gift-card</li>
						</ul>
						

				<div class="word_range">						
					<h6>your gift card value</h6>
					
						<h2><span class="euro">€</span>100.00</h2>
						<h3>Card Number:324982093302</h3>
						<h3>Pin:32424</h3>
				</div>
	
					
				</div>
			</div>
				
				<div class="col-md-3"></div>
			</div>
		</div>
	</section>';
			
			wp_die();
		}
