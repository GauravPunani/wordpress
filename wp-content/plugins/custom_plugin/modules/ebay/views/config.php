<?php  
//    error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Ebay'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['app_id']!=''){
                  $key=true;
            } 
            else{
                  $key=false;
                     echo "<p style='color:red;'>Please fill the required Fields</p>";
            } 
      }
            
            
      if($key){
            $data=json_encode($data);
            global $wpdb;
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'ebay'));
            // $wpdb->insert('wp_custom_plugin',array('meta_key'=>'aliexpress','meta_value'=>$data));
            // echo $wpdb->insert_id;
      }
      
   } 
}
//get the data if exist
global $wpdb;

 $result = $wpdb->get_results ( "
    SELECT * 
    FROM  wp_custom_plugin
        WHERE  meta_key= 'ebay'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>Ebay Settings</h3>
<form action="" method="POST">                
   <table class="form-table">
   </table>
   <table class="form-table">
      <tbody>
         <tr>
            <th scope="row"><label for="label-is_active">Enable module</label></th>
            <td><label for="label-is_active"><input type="checkbox" name="content-egg_Ebay[is_active]" id="label-is_active" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-embed_at">Add</label></th>
            <td>
               <select name="content-egg_Ebay[embed_at]" id="label-embed_at" value="post_bottom">
                  <option value="post_bottom" <?= $data->embed_at=='first' ?'selected':''; ?>>At the end of the post</option>
                  <option value="post_top" <?= $data->embed_at=='first' ?'selected':''; ?>>At the beginning of the post</option>
                  <option value="shortcode" <?= $data->embed_at=='first' ?'selected':''; ?>>Shortcodes only</option>
               </select>
               <p class="description">The place for content of module. Shortcodes will work in any place regardless of the setting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-priority">Priority</label></th>
            <td>
               <input name="content-egg_Ebay[priority]" id="label-priority" value="10" class="regular-text" <?= $data->priority ? $data->priority :'10'; ?>>
               <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-template">Template</label></th>
            <td>
               <select name="content-egg_Ebay[template]" id="label-template" value="data_list">
                  <option value="data_grid" <?= $data->template=='data_grid' ?'selected':''; ?>>Grid</option>
                  <option value="data_item" <?= $data->template=='data_item' ?'selected':''; ?>>Product card</option>
                  <option value="data_list" selected="selected" <?= $data->template=='data_list' ?'selected':''; ?>>List</option>
                  <option value="data_price_tracker_alert" <?= $data->template=='data_price_tracker_alert' ?'selected':''; ?>>Price tracker &amp; alert</option>
               </select>
               <p class="description">Default template</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-tpl_title">Title</label></th>
            <td>
               <input name="content-egg_Ebay[tpl_title]" id="label-tpl_title" value="<?= $data->tpl_title; ?>" class="regular-text">
               <p class="description">Templates may use title on data output.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-featured_image">Featured image</label></th>
            <td>
               <select name="content-egg_Ebay[featured_image]" id="label-featured_image" value="">
                  <option value="" <?= $data->featured_image=='' ?'selected':''; ?>>Don't set</option>
                  <option value="first" <?= $data->featured_image=='first' ?'selected':''; ?>>First image</option>
                  <option value="second" <?= $data->featured_image=='second' ?'selected':''; ?>>Second image</option>
                  <option value="rand" <?= $data->featured_image=='rand' ?'selected':''; ?>Random image</option>
                  <option value="last" <?= $data->featured_image=='last' ?'selected':''; ?>>Last image</option>
               </select>
               <p class="description">Automatically set Featured image for post</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
            <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Ebay[set_local_redirect]" id="label-set_local_redirect" value="1" <?= isset($data->set_local_redirect) ?'checked':'' ?>> Make links with local 301 redirect</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-ttl">Update by keyword</label></th>
            <td>
               <input name="content-egg_Ebay[ttl]" id="label-ttl" value="<?= $data->ttl; ?>" class="regular-text">
               <p class="description">Lifetime of cache in seconds, after this period products will be updated if you set keyword for updating. 0 - never update</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-ttl_items">Price update</label></th>
            <td>
               <input name="content-egg_Ebay[ttl_items]" id="label-ttl_items" value="<?= $data->ttl_items; ?>" class="regular-text">
               <p class="description">Time in seconds for updating prices, availability, etc. 0 - never update</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-update_mode">Update mode</label></th>
            <td>
               <select name="content-egg_Ebay[update_mode]" id="label-update_mode" value="visit">
                  <option value="visit" <?= $data->featured_image=='visit' ?'selected':''; ?>>By page view</option>
                  <option value="cron" <?= $data->featured_image=='cron' ?'selected':''; ?>>By schedule (cron)</option>
                  <option value="visit_cron" <?= $data->featured_image=='visit_cron' ?'selected':''; ?>>By page view and by schedule</option>
               </select>
               <p class="description">If you use update by schedule, for more better results change Wordpress cron on real cron</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-app_id">Application ID (AppID) <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_Ebay[app_id]" id="label-app_id" value="<?= $data->app_id; ?>" class="regular-text">
               <p class="description">API access key to Ebay. You can get it in <a href="http://developer.ebay.com/join">eBay Developers Program</a>.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-tracking_id">EPN Campaign ID</label></th>
            <td>
               <input name="content-egg_Ebay[tracking_id]" id="label-tracking_id" value="<?= $data->tracking_id; ?>" class="regular-text">
               <p class="description">This is connection with partner program EPN. Campaign ID is valid for all programs which were approved for you on EPN. If you leave this field blank - you will not get commissions from sales.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-custom_id">EPN Custom ID (chanel)</label></th>
            <td>
               <input name="content-egg_Ebay[custom_id]" id="label-custom_id" value="<?= $data->custom_id; ?>" class="regular-text">
               <p class="description">Any word, for example, name of domain. Custom ID will be included in sale report on EPN, so, you can additionally check your traffic. </p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-ebayin_aff_id">Ebay.in Affilite ID</label></th>
            <td>
               <input name="content-egg_Ebay[ebayin_aff_id]" id="label-ebayin_aff_id" value="<?= $data->ebayin_aff_id; ?>" class="regular-text">
               <p class="description">For eBay India's Affiliate program only. Go to <a href="https://ebayindia.hasoffers.com/publisher/#!/account">Ebay Hasoffers Dashboard</a> and find your Affiliate ID.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-skimlinks_id">Skimlinks Site ID</label></th>
            <td>
               <input name="content-egg_Ebay[skimlinks_id]" id="label-skimlinks_id" value="<?= $data->skimlinks_id; ?>" class="regular-text">
               <p class="description">Set this if you want to direct traffic over <a href="http://www.keywordrush.com/go/skimlinks">Skimlinks</a>. Id for domain you can find <a href="https://hub.skimlinks.com/account">here</a>.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-viglink_id">Viglink ID</label></th>
            <td>
               <input name="content-egg_Ebay[viglink_id]" id="label-viglink_id" value="<?= $data->viglink_id; ?>" class="regular-text">
               <p class="description">Set this if you want to direct traffic over <a href="http://www.keywordrush.com/go/viglink">Viglink</a>. Id for domain you can find <a href="http://www.viglink.com/install">here</a>. Id is the same for all domains</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-deeplink">Deeplink</label></th>
            <td>
               <input name="content-egg_Ebay[deeplink]" id="label-deeplink" value="<?= $data->deeplink; ?>" class="regular-text">
               <p class="description">Set Deeplink for one of CPA-networks. You can use parameter as <em>partner_id=12345</em>, or make link as template, for example, <em>{{url}}/partner_id-12345/</em>. Another example is   https://ad.admitad.com/g/g8f0qmlavfa/?ulp={{url_encoded}}. {{url}} and {{url_encoded}} - will be replaced by product url. If product url is after affiliate url - use {{url_encoded}}</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-global_id">Locale</label></th>
            <td>
               <select name="content-egg_Ebay[global_id]" id="label-global_id" value="EBAY-US">
                  <option value="EBAY-US" <?= $data->global_id=='EBAY-US' ?'selected':''; ?>>eBay United States</option>
                  <option value="EBAY-IE" <?= $data->global_id=='EBAY-IE' ?'selected':''; ?>>eBay Ireland</option>
                  <option value="EBAY-AT" <?= $data->global_id=='EBAY-AT' ?'selected':''; ?>>eBay Austria</option>
                  <option value="EBAY-AU" <?= $data->global_id=='EBAY-AU' ?'selected':''; ?>>eBay Australia</option>
                  <option value="EBAY-FRBE" <?= $data->global_id=='EBAY-FRBE' ?'selected':''; ?>>eBay Belgium (French)</option>
                  <option value="EBAY-NLBE" <?= $data->global_id=='EBAY-NLBE' ?'selected':''; ?>>eBay Belgium (Dutch)</option>
                  <option value="EBAY-ENCA" <?= $data->global_id=='EBAY-ENCA' ?'selected':''; ?>>eBay Canada (English)</option>
                  <option value="EBAY-FRCA" <?= $data->global_id=='EBAY-FRCA' ?'selected':''; ?>>eBay Canada (French)</option>
                  <option value="EBAY-FR" <?= $data->global_id=='EBAY-FR' ?'selected':''; ?>>eBay France</option>
                  <option value="EBAY-DE" <?= $data->global_id=='EBAY-DE' ?'selected':''; ?>>eBay Germany</option>
                  <option value="EBAY-IT" <?= $data->global_id=='EBAY-IT' ?'selected':''; ?>>eBay Italy</option>
                  <option value="EBAY-ES" <?= $data->global_id=='EBAY-ES' ?'selected':''; ?>>eBay Spain</option>
                  <option value="EBAY-CH" <?= $data->global_id=='EBAY-CH' ?'selected':''; ?>>eBay Switzerland</option>
                  <option value="EBAY-GB" <?= $data->global_id=='EBAY-GB' ?'selected':''; ?>>eBay UK</option>
                  <option value="EBAY-NL" <?= $data->global_id=='EBAY-NL' ?'selected':''; ?>>eBay Netherlands</option>
                  <option value="EBAY-MOTOR" <?= $data->global_id=='EBAY-MOTOR' ?'selected':''; ?>>eBay Motors</option>
                  <option value="EBAY-IN" <?= $data->global_id=='EBAY-IN' ?'selected':''; ?>>eBay India</option>
                  <option value="EBAY-HK" <?= $data->global_id=='EBAY-HK' ?'selected':''; ?>>eBay Hong Kong</option>
                  <option value="EBAY-MY" <?= $data->global_id=='EBAY-MY' ?'selected':''; ?>>eBay Malaysia</option>
                  <option value="EBAY-PH" <?= $data->global_id=='EBAY-PH' ?'selected':''; ?>>eBay Philippines</option>
                  <option value="EBAY-PL" <?= $data->global_id=='EBAY-PL' ?'selected':''; ?>>eBay Poland</option>
                  <option value="EBAY-SG" <?= $data->global_id=='EBAY-SG' ?'selected':''; ?>>eBay Singapore</option>
               </select>
               <p class="description">Local site of Ebay. For each local site you must have separate registration in affiliate program.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page">Results</label></th>
            <td>
               <input name="content-egg_Ebay[entries_per_page]" id="label-entries_per_page" value="<?= $data->entries_per_page; ?>" class="regular-text">
               <p class="description">Number of results for one search query.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page_update">Results for updates </label></th>
            <td>
               <input name="content-egg_Ebay[entries_per_page_update]" id="label-entries_per_page_update" value="<?= $data->entries_per_page_update; ?>" class="regular-text">
               <p class="description">Number of results for automatic updates and autoblogging.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-sort_order">Sorting</label></th>
            <td>
               <select name="content-egg_Ebay[sort_order]" id="label-sort_order" value="BestMatch">
                  <option value="BestMatch"  <?= $data->sort_order=='BestMatch' ?'selected':''; ?>>BestMatch</option>
                  <option value="CurrentPriceHighest" <?= $data->sort_order=='CurrentPriceHighest' ?'selected':''; ?>>CurrentPriceHighest</option>
                  <option value="EndTimeSoonest" <?= $data->sort_order=='EndTimeSoonest' ?'selected':''; ?>>EndTimeSoonest</option>
                  <option value="PricePlusShippingHighest" <?= $data->sort_order=='PricePlusShippingHighest' ?'selected':''; ?>>PricePlusShippingHighest</option>
                  <option value="PricePlusShippingLowest" <?= $data->sort_order=='PricePlusShippingLowest' ?'selected':''; ?>>PricePlusShippingLowest</option>
                  <option value="StartTimeNewest" <?= $data->sort_order=='StartTimeNewest' ?'selected':''; ?>>StartTimeNewest</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-end_time_to">Ending time</label></th>
            <td>
               <input name="content-egg_Ebay[end_time_to]" id="label-end_time_to" value="<?= $data->end_time_to; ?>" class="regular-text">
               <p class="description">Lifetime of lots in seconds. Only lots which will be closed not later than the specified time will be chosen.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-category_id">Category </label></th>
            <td>
               <input name="content-egg_Ebay[category_id]" id="label-category_id" value="<?= $data->category_id; ?>" class="regular-text">
               <p class="description">Id of category for searching. Id of categories you can find in URL of category on <a href="http://www.ebay.com/sch/allcategories/all-categories">this page</a>. You can set maximum 3 categories separated with comma. Example, "2195,2218,20094".</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-description_search">Search in description</label></th>
            <td><label for="label-description_search"><input type="checkbox" name="content-egg_Ebay[description_search]" id="label-description_search" value=" <?php echo isset($data->description_search) ?'checked':'' ?>"> Include description of product in searching. This will take more time, than searching only by title.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-search_logic">Searching logic</label></th>
            <td>
               <select name="content-egg_Ebay[search_logic]" id="label-search_logic" value="AND">
                  <option value="AND" <?= $data->search_logic=='AND' ?'selected':''; ?>>AND logic for multiple keywords</option>
                  <option value="OR" <?= $data->search_logic=='OR' ?'selected':''; ?>>OR logic for multiple keywords</option>
                  <option value="EXACT" <?= $data->search_logic=='EXACT' ?'selected':''; ?>>Exact sequence of words</option>
               </select>
               <p class="description">Логика поиска для поискового запроса, состоящего из нескольких слов.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-condition">Product condition</label></th>
            <td>
               <select name="content-egg_Ebay[condition]" id="label-condition" >
                  <option value="" <?= $data->condition=='' ?'selected':''; ?>>Any</option>
                  <option value="1000," <?= $data->condition=='1000' ?'selected':''; ?>>New</option>
                  <option value="1000,2000,2500" <?= $data->condition=='1000,2000,2500' ?'selected':''; ?>>New + Refurbished</option>
                  <option value="3000," <?= $data->condition=='3000' ?'selected':''; ?>>Used</option>
                  <option value="3000,2000,2500" <?= $data->condition=='3000,2000,2500' ?'selected':''; ?>>Used + Refurbished</option>
                  <option value="7000," <?= $data->condition=='7000' ?'selected':''; ?>>For parts or not working</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-exclude_category">Exclude category</label></th>
            <td>
               <input name="content-egg_Ebay[exclude_category]" id="label-exclude_category" value="<?= $data->exclude_category; ?>" class="regular-text">
               <p class="description">Id of category, which must be excluded while searching. Id of categories you can find in URL of category on <a href="http://www.ebay.com/sch/allcategories/all-categories">this page</a>. You can set maximum 25 categories separated with comma. Example, "2195,2218,20094".</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-feedback_score_min">Minimal seller rating</label></th>
            <td>
               <select name="content-egg_Ebay[feedback_score_min]" id="label-feedback_score_min" value="">
                  <option value="" <?= $data->feedback_score_min=='' ?'selected':''; ?>>Any</option>
                  <option value="10." <?= $data->feedback_score_min=='10' ?'selected':''; ?>>Yellow star - 10 ratings</option>
                  <option value="50." <?= $data->feedback_score_min=='50' ?'selected':''; ?>>Blue star - 50 rating</option>
                  <option value="100." <?= $data->feedback_score_min=='100' ?'selected':''; ?>>Turquoise star - 100 rating</option>
                  <option value="500." <?= $data->feedback_score_min=='500' ?'selected':''; ?>>Purple star - 500 rating</option>
                  <option value="1000." <?= $data->feedback_score_min=='1000' ?'selected':''; ?>>Red star - 1,000 rating</option>
                  <option value="5000." <?= $data->feedback_score_min=='5000' ?'selected':''; ?>>Green star - 5,0000 ratings</option>
                  <option value="10000." <?= $data->feedback_score_min=='10000' ?'selected':''; ?>>Yellow shooting star - 10,000</option>
                  <option value="25000." <?= $data->feedback_score_min=='25000' ?'selected':''; ?>>Turquoise shooting star - 25000</option>
                  <option value="50000." <?= $data->feedback_score_min=='50000' ?'selected':''; ?>>Purple shooting star - 50,000</option>
                  <option value="100000." <?= $data->feedback_score_min=='100000' ?'selected':''; ?>>Red shooting star 100,000</option>
                  <option value="500000." <?= $data->feedback_score_min=='500000' ?'selected':''; ?>>Green shooting star - 500,000</option>
                  <option value="1000000." <?= $data->feedback_score_min=='1000000' ?'selected':''; ?>>Silver shooting star - 1,000,000</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-best_offer_only">Best Offer</label></th>
            <td><label for="label-best_offer_only"><input type="checkbox" name="content-egg_Ebay[best_offer_only]" id="label-best_offer_only" value="1" <?php echo isset($data->best_offer_only) ?'checked':'' ?>> Only  "Best Offer" lots.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-featured_only">Featured</label></th>
            <td><label for="label-featured_only"><input type="checkbox" name="content-egg_Ebay[featured_only]" id="label-featured_only" value="1" <?php echo isset($data->featured_only) ?'checked':'' ?>> Only "Featured" lots.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-free_shipping_only">Free Shipping</label></th>
            <td><label for="label-free_shipping_only"><input type="checkbox" name="content-egg_Ebay[free_shipping_only]" id="label-free_shipping_only" value="1" <?php echo isset($data->free_shipping_only) ?'checked':'' ?>> Only lots with free delivery</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-local_pickup_only">Local Pickup</label></th>
            <td><label for="label-local_pickup_only"><input type="checkbox" name="content-egg_Ebay[local_pickup_only]" id="label-local_pickup_only" value="1" <?php echo isset($data->local_pickup_only) ?'checked':'' ?>> Only lots with "local pickup" option.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-get_it_fast_only">Get It Fast</label></th>
            <td><label for="label-get_it_fast_only"><input type="checkbox" name="content-egg_Ebay[get_it_fast_only]" id="label-get_it_fast_only" value="1" <?php echo isset($data->get_it_fast_only) ?'checked':'' ?>> Only "Get It Fast" lots.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-top_rated_seller_only">Top-rated seller</label></th>
            <td><label for="label-top_rated_seller_only"><input type="checkbox" name="content-egg_Ebay[top_rated_seller_only]" id="label-top_rated_seller_only" value="1" <?php echo isset($data->top_rated_seller_only) ?'checked':'' ?>> Only products from Top-rated "Top-rated" vendors.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-hide_dublicate_items">Hide dublicates</label></th>
            <td><label for="label-hide_dublicate_items"><input type="checkbox" name="content-egg_Ebay[hide_dublicate_items]" id="label-hide_dublicate_items"  value="1" <?php echo isset($data->hide_dublicate_items) ?'checked':'' ?>> Filter similar lots</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-listing_type">Type of auction</label></th>
            <td>
               <select name="content-egg_Ebay[listing_type]" id="label-listing_type" value="">
                  <option value="" <?= $data->listing_type=='' ?'selected':''; ?>>All</option>
                  <option value="Auction" <?= $data->listing_type=='Auction' ?'selected':''; ?>>Auction</option>
                  <option value="AuctionWithBIN" <?= $data->listing_type=='AuctionWithBIN' ?'selected':''; ?>>Auction with BIN</option>
                  <option value="AuctionWithBIN" <?= $data->listing_type=='AuctionWithBIN' ?'selected':''; ?>>Fixed Price</option>
                  <option value="FixedPrice,AuctionWithBIN" <?= $data->listing_type=='FixedPrice,AuctionWithBIN' ?'selected':''; ?>>Fixed Price + Auction with BIN</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-max_bids">Maximum bids</label></th>
            <td>
               <input name="content-egg_Ebay[max_bids]" id="label-max_bids" value="<?= $data->max_bids; ?>" class="regular-text">
               <p class="description">Example, 10</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-min_bids">Minimum bids</label></th>
            <td>
               <input name="content-egg_Ebay[min_bids]" id="label-min_bids" value="<?= $data->min_bids; ?>" class="regular-text">
               <p class="description">Example, 3</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-max_price">Maximal price</label></th>
            <td>
               <input name="content-egg_Ebay[max_price]" id="label-max_price" value="<?= $data->max_price; ?>" class="regular-text">
               <p class="description">Example, 300.50</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-min_price">Minimal price</label></th>
            <td>
               <input name="content-egg_Ebay[min_price]" id="label-min_price" value="<?= $data->min_price; ?>" class="regular-text">
               <p class="description">Example, 10.98</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-payment_method">Payment options</label></th>
            <td>
               <select name="content-egg_Ebay[payment_method]" id="label-payment_method" value="">
                  <option value="" <?= $data->payment_method=='' ?'selected':''; ?>>Any</option>
                  <option value="PayPal" <?= $data->payment_method=='FPayPal' ?'selected':''; ?>>PayPal</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-available_to">Available to</label></th>
            <td>
               <input name="content-egg_Ebay[available_to]" id="label-available_to" value="<?= $data->available_to; ?>" class="regular-text">
               <p class="description">Limits items to those available to the specified country only. Expects the two-letter ISO 3166 country code.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-get_description">Get description</label></th>
            <td><label for="label-get_description"><input type="checkbox" name="content-egg_Ebay[get_description]" id="label-get_description" value="1"  <?php echo isset($data->get_description) ?'checked':'' ?>> Get description of product. This takes more requests for Ebay API and slow down searching. Description will be requested only for 20 first products for one searching</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-description_size">Size of description</label></th>
            <td>
               <input name="content-egg_Ebay[description_size]" id="label-description_size" value="<?= $data->description_size; ?>" class="regular-text">
               <p class="description">The maximum size of the item description. 0 - do not cut.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-save_img">Save images</label></th>
            <td><label for="label-save_img"><input type="checkbox" name="content-egg_Ebay[save_img]" id="label-save_img" value="1" <?php echo isset($data->save_img) ?'checked':'' ?>> Save images on server</label></td>
         </tr>
      </tbody>
   </table>
   <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>