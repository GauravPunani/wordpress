<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Amazon'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['access_key_id']!='' && $data['secret_access_key']!='' && $data['associate_tag']!=''){
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'amazon'));
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
        WHERE  meta_key= 'amazon'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // echo "<pre>";print_r($data);die;
?>
<h3>Amazon</h3>
<form action="" method="post">
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row"><label for="label-is_active">Enable module</label></th>
         <td><label for="label-is_active"><input type="checkbox" name="content-egg_Amazon[is_active]" id="label-is_active" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-embed_at">Add</label></th>
         <td>
            <select name="content-egg_Amazon[embed_at]" id="label-embed_at" value="post_bottom">
               <option value="post_bottom" <?= $data->embed_at=='post_bottom' ?'selected':''; ?>>At the end of the post</option>
               <option value="post_top" <?= $data->embed_at=='post_top' ?'selected':''; ?>>At the beginning of the post</option>
               <option value="shortcode" <?= $data->embed_at=='shortcode' ?'selected':''; ?>>Shortcodes only</option>
            </select>
            <p class="description">The place for content of module. Shortcodes will work in any place regardless of the setting.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-priority">Priority</label></th>
         <td>
            <input name="content-egg_Amazon[priority]" id="label-priority" value="<?= $data->priority ? $data->priority :'10'; ?>" class="regular-text">
            <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-template">Template</label></th>
         <td>
            <select name="content-egg_Amazon[template]" id="label-template" value="data_item">
               <option value="data_compare" <?= $data->template=='data_compare' ?'selected':''; ?>>Compare</option>
               <option value="data_grid" <?= $data->template=='data_grid' ?'selected':''; ?>>Grid</option>
               <option value="data_item" <?= $data->template=='data_item' ?'selected':''; ?>>Product card</option>
               <option value="data_list" <?= $data->template=='data_list' ?'selected':''; ?>>List</option>
               <option value="data_price_tracker_alert" <?= $data->template=='data_price_tracker_alert' ?'selected':''; ?>>Price tracker &amp; alert</option>
            </select>
            <p class="description">Default template</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-tpl_title">Title</label></th>
         <td>
            <input name="content-egg_Amazon[tpl_title]" id="label-tpl_title" value="<?= $data->tpl_title; ?>" class="regular-text">
            <p class="description">Templates may use title on data output.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-featured_image">Featured image</label></th>
         <td>
            <select name="content-egg_Amazon[featured_image]" id="label-featured_image" value="">
               <option value=""value="" <?= $data->featured_image=='' ?'selected':''; ?>>Don't set</option>
               <option value="first" value="" <?= $data->featured_image=='first' ?'selected':''; ?>>First image</option>
               <option value="second" value="" <?= $data->featured_image=='second' ?'selected':''; ?>>Second image</option>
               <option value="rand" value="" <?= $data->featured_image=='rand' ?'selected':''; ?>>Random image</option>
               <option value="last" value="" <?= $data->featured_image=='last' ?'selected':''; ?>>Last image</option>
            </select>
            <p class="description">Automatically set Featured image for post</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
         <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Amazon[set_local_redirect]" id="label-set_local_redirect" value="1" <?= isset($data->set_local_redirect) ?'checked':'' ?>> Make links with local 301 redirect</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-ttl">Update by keyword</label></th>
         <td>
            <input name="content-egg_Amazon[ttl]" id="label-ttl" value="<?= $data->ttl; ?>" class="regular-text">
            <p class="description">Lifetime of cache in seconds, after this period products will be updated if you set keyword for updating. 0 - never update</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-ttl_items">Price update</label></th>
         <td>
            <input name="content-egg_Amazon[ttl_items]" id="label-ttl_items" value="<?= $data->ttl_items; ?>" class="regular-text">
            <p class="description">Time in seconds for updating prices, availability, etc. 0 - never update</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-update_mode">Update mode</label></th>
         <td>
            <select name="content-egg_Amazon[update_mode]" id="label-update_mode" value="visit">
               <option value="visit"  <?= $data->featured_image=='visit' ?'selected':''; ?>>By page view</option>
               <option value="cron"  <?= $data->featured_image=='cron' ?'selected':''; ?>>By schedule (cron)</option>
               <option value="visit_cron"  <?= $data->featured_image=='visit_cron' ?'selected':''; ?>>By page view and by schedule</option>
            </select>
            <p class="description">If you use update by schedule, for more better results change Wordpress cron on real cron</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-access_key_id">Access Key ID <span class="cegg_required">*</span></label></th>
         <td>
            <input name="content-egg_Amazon[access_key_id]" id="label-access_key_id" value="<?= $data->access_key_id; ?>" class="regular-text">
            <p class="description">Your Access Key ID which uniquely identifies you.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-secret_access_key">Secret Access Key <span class="cegg_required">*</span></label></th>
         <td>
            <input name="content-egg_Amazon[secret_access_key]" id="label-secret_access_key" value="<?= $data->secret_access_key; ?>" class="regular-text">
            <p class="description">A key that is used in conjunction with the Access Key ID to cryptographically sign an API request. To retrieve your Access Key ID or Secret Access Key, refer to <a target="_blank" href="https://docs.aws.amazon.com/AWSECommerceService/latest/DG/becomingDev.html">Becoming Product Advertising API Developer</a>.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag">Default Associate Tag <span class="cegg_required">*</span></label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag]" id="label-associate_tag" value="<?= $data->associate_tag; ?>" class="regular-text">
            <p class="description">An alphanumeric token that uniquely identifies you as an Associate. To obtain an Associate Tag, refer to <a target="_blank" href="https://docs.aws.amazon.com/AWSECommerceService/latest/DG/becomingAssociate.html">Becoming an Associate</a>.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-forced_urls_update">Forced links update</label></th>
         <td><label for="label-forced_urls_update"><input type="checkbox" name="content-egg_Amazon[forced_urls_update]" id="label-forced_urls_update" value="1" <?php echo isset($data->forced_urls_update) ?'checked':'' ?>> Override/update existing links with new Tracking ID.</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-locale">Default locale</label></th>
         <td>
            <select name="content-egg_Amazon[locale]" id="label-locale" value="us">
               <option value="us" <?= $data->locale=='us' ?'selected':''; ?>>US</option>
               <option value="uk" <?= $data->locale=='uk' ?'selected':''; ?>>UK</option>
               <option value="de" <?= $data->locale=='de' ?'selected':''; ?>>DE</option>
               <option value="jp" <?= $data->locale=='jp' ?'selected':''; ?>>JP</option>
               <option value="cn" <?= $data->locale=='cn' ?'selected':''; ?>>CN</option>
               <option value="fr" <?= $data->locale=='fr' ?'selected':''; ?>>FR</option>
               <option value="it" <?= $data->locale=='it' ?'selected':''; ?>>IT</option>
               <option value="es" <?= $data->locale=='es' ?'selected':''; ?>>ES</option>
               <option value="ca" <?= $data->locale=='ca' ?'selected':''; ?>>CA</option>
               <option value="br" <?= $data->locale=='br' ?'selected':''; ?>>BR</option>
               <option value="in" <?= $data->locale=='in' ?'selected':''; ?>>IN</option>
               <option value="mx" <?= $data->locale=='mx' ?'selected':''; ?>>MX</option>
               <option value="au" <?= $data->locale=='au' ?'selected':''; ?>>AU</option>
            </select>
            <p class="description">The branch/locale of Amazon. Each branch requires a separate registration in certain affiliate program.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-entries_per_page">Results</label></th>
         <td>
            <input name="content-egg_Amazon[entries_per_page]" id="label-entries_per_page" value="<?= $data->entries_per_page; ?>" class="regular-text">
            <p class="description">Number of results for one search query. It needs a bit more time to get more than 10 results in one request</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-entries_per_page_update">Results for updates </label></th>
         <td>
            <input name="content-egg_Amazon[entries_per_page_update]" id="label-entries_per_page_update" value="<?= $data->entries_per_page_update; ?>" class="regular-text">
            <p class="description">Number of results for automatic updates and autoblogging. It needs a bit more time to get more than 10 results in one request</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-link_type">Link type</label></th>
         <td>
            <select name="content-egg_Amazon[link_type]" id="label-link_type" >
               <option value="product" <?= $data->link_type=='product' ?'selected':''; ?>>Product page</option>
               <option value="add_to_cart" <?= $data->link_type=='add_to_cart' ?'selected':''; ?>>Add to cart</option>
            </select>
            <p class="description">Type of partner links. Know more about amazon <a target="_blank" href="https://affiliate-program.amazon.com/gp/associates/help/t2/a11">90 day cookie</a>.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-search_index">Categories for search</label></th>
         <td>
            <select name="content-egg_Amazon[search_index]" id="label-search_index" value="All">
               <option value="All" <?= $data->search_index=='All' ?'selected':''; ?>>[ All ]</option>
               <option value="Blended" <?= $data->search_index=='Blended' ?'selected':''; ?>>[ Blended ]</option>
               <option value="Music" <?= $data->search_index=='Music' ?'selected':''; ?>>[ Music ]</option>
               <option value="Video" <?= $data->search_index=='Video' ?'selected':''; ?>>[ Video ]</option>
               <option value="Apparel" <?= $data->search_index=='Apparel' ?'selected':''; ?>>Apparel</option>
               <option value="Automotive" <?= $data->search_index=='Automotive' ?'selected':''; ?>>Automotive</option>
               <option value="Baby" <?= $data->search_index=='Baby' ?'selected':''; ?>>Baby</option>
               <option value="Beauty" <?= $data->search_index=='Beauty' ?'selected':''; ?>>Beauty</option>
               <option value="Books" <?= $data->search_index=='Books' ?'selected':''; ?>>Books</option>
               <option value="Classical" <?= $data->search_index=='Classical' ?'selected':''; ?>>Classical</option>
               <option value="DigitalMusic" <?= $data->search_index=='DigitalMusic' ?'selected':''; ?>>DigitalMusic</option>
               <option value="DVD" <?= $data->search_index=='DVD' ?'selected':''; ?>>DVD</option>
               <option value="Electronics" <?= $data->search_index=='Electronics' ?'selected':''; ?>>Electronics</option>
               <option value="GourmetFood" <?= $data->search_index=='GourmetFood' ?'selected':''; ?>>GourmetFood</option>
               <option value="Grocery" <?= $data->search_index=='Grocery' ?'selected':''; ?>>Grocery</option>
               <option value="HealthPersonalCare" <?= $data->search_index=='HealthPersonalCare' ?'selected':''; ?>>HealthPersonalCare</option>
               <option value="HomeGarden" <?= $data->search_index=='HomeGarden' ?'selected':''; ?>>HomeGarden</option>
               <option value="Industrial" <?= $data->search_index=='Industrial' ?'selected':''; ?>>Industrial</option>
               <option value="Jewelry" <?= $data->search_index=='Jewelry' ?'selected':''; ?>>Jewelry</option>
               <option value="KindleStore" <?= $data->search_index=='KindleStore' ?'selected':''; ?>>KindleStore</option>
               <option value="Kitchen" <?= $data->search_index=='Kitchen' ?'selected':''; ?>>Kitchen</option>
               <option value="Magazines" <?= $data->search_index=='Magazines' ?'selected':''; ?>>Magazines</option>
               <option value="Merchants" <?= $data->search_index=='Merchants' ?'selected':''; ?>>Merchants</option>
               <option value="Miscellaneous" <?= $data->search_index=='Miscellaneous' ?'selected':''; ?>>Miscellaneous</option>
               <option value="MP3Downloads" <?= $data->search_index=='MP3Downloads' ?'selected':''; ?>>MP3Downloads</option>
               <option value="MusicalInstruments" <?= $data->search_index=='MusicalInstruments' ?'selected':''; ?>>MusicalInstruments</option>
               <option value="MusicTracks" <?= $data->search_index=='MusicTracks' ?'selected':''; ?>>MusicTracks</option>
               <option value="OfficeProducts" <?= $data->search_index=='OfficeProducts' ?'selected':''; ?>>OfficeProducts</option>
               <option value="OutdoorLiving" <?= $data->search_index=='OutdoorLiving' ?'selected':''; ?>>OutdoorLiving</option>
               <option value="PCHardware" <?= $data->search_index=='PCHardware' ?'selected':''; ?>>PCHardware</option>
               <option value="PetSupplies" <?= $data->search_index=='PetSupplies' ?'selected':''; ?>>PetSupplies</option>
               <option value="Photo" <?= $data->search_index=='Photo' ?'selected':''; ?>>Photo</option>
               <option value="Shoes" <?= $data->search_index=='Shoes' ?'selected':''; ?>>Shoes</option>
               <option value="Software" <?= $data->search_index=='Software' ?'selected':''; ?>>Software</option>
               <option value="SportingGoods" <?= $data->search_index=='SportingGoods' ?'selected':''; ?>>SportingGoods</option>
               <option value="Tools" <?= $data->search_index=='Tools' ?'selected':''; ?>>Tools</option>
               <option value="Toys" <?= $data->search_index=='Toys' ?'selected':''; ?>>Toys</option>
               <option value="UnboxVideo" <?= $data->search_index=='UnboxVideo' ?'selected':''; ?>>UnboxVideo</option>
               <option value="VHS" <?= $data->search_index=='VHS' ?'selected':''; ?>>VHS</option>
               <option value="VideoGames" <?= $data->search_index=='VideoGames' ?'selected':''; ?>>VideoGames</option>
               <option value="Watches" <?= $data->search_index=='Watches' ?'selected':''; ?>>Watches</option>
               <option value="Wireless" <?= $data->search_index=='Wireless' ?'selected':''; ?>>Wireless</option>
               <option value="WirelessAccessories" <?= $data->search_index=='WirelessAccessories' ?'selected':''; ?>>WirelessAccessories</option>
            </select>
            <p class="description">The list of categories for US Amazon. For local branches some of categories may be not available. If you do not set category for searching, no other filtering options in addition to searching for the keyword (for example, the minimal price or sorting) will not working.  Search by EAN require a Category to be specified.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-sort">Sorting order</label></th>
         <td>
            <input name="content-egg_Amazon[sort]" id="label-sort" value="<?= $data->sort; ?>" class="regular-text">
            <p class="description">Sorting variants depend on locale and chosed category. List of all available values you can find <a href="http://docs.amazonwebservices.com/AWSECommerceService/latest/DG/index.html?APPNDX_SortValuesArticle.html">here</a>.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-brouse_node">Brouse node</label></th>
         <td>
            <input name="content-egg_Amazon[brouse_node]" id="label-brouse_node" value="<?= $data->brouse_node; ?>" class="regular-text">
            <p class="description">Integer ID "node" on Amazon. The search will be made only in this "node".</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-title">Search in title</label></th>
         <td><label for="label-title"><input type="checkbox" name="content-egg_Amazon[title]" id="label-title" value="1" <?= isset($data->title) ?'checked':'' ?>> The search will produce only by product name.</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-merchant_id">Only Amazon</label></th>
         <td><label for="label-merchant_id"><input type="checkbox" name="content-egg_Amazon[merchant_id]" id="label-merchant_id" value="1" <?= isset($data->merchant_id) ?'checked':'' ?>> Select products that are selling by Amazon. Other sellers are excluded from the search.</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-minimum_price">Minimal price</label></th>
         <td>
            <input name="content-egg_Amazon[minimum_price]" id="label-minimum_price" value="<?= $data->minimum_price; ?>" class="regular-text">
            <p class="description">Example, 8.99</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-maximum_price">Maximal price</label></th>
         <td>
            <input name="content-egg_Amazon[maximum_price]" id="label-maximum_price" value="<?= $data->maximum_price; ?>" class="regular-text">
            <p class="description">Example, 98.50</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-min_percentage_off">Minimal discount</label></th>
         <td>
            <select name="content-egg_Amazon[min_percentage_off]" id="label-min_percentage_off">
               <option value="" <?= $data->min_percentage_off=='' ?'selected':''; ?>>Any</option>
               <option value="5%"  <?= $data->min_percentage_off=='5%' ?'selected':''; ?>>5%</option>
               <option value="10%" <?= $data->min_percentage_off=='10%' ?'selected':''; ?>>10%</option>
               <option value="15%" <?= $data->min_percentage_off=='15%' ?'selected':''; ?>>15%</option>
               <option value="20%" <?= $data->min_percentage_off=='20%' ?'selected':''; ?>>20%</option>
               <option value="25%" <?= $data->min_percentage_off=='25%' ?'selected':''; ?>>25%</option>
               <option value="30%" <?= $data->min_percentage_off=='30%' ?'selected':''; ?>>30%</option>
               <option value="35%" <?= $data->min_percentage_off=='35%' ?'selected':''; ?>>35%</option>
               <option value="40%" <?= $data->min_percentage_off=='40%' ?'selected':''; ?>>40%</option>
               <option value="45%" <?= $data->min_percentage_off=='45%' ?'selected':''; ?>>45%</option>
               <option value="50%" <?= $data->min_percentage_off=='50%' ?'selected':''; ?>>50%</option>
               <option value="60%" <?= $data->min_percentage_off=='60%' ?'selected':''; ?>>60%</option>
               <option value="70%" <?= $data->min_percentage_off=='70%' ?'selected':''; ?>>70%</option>
               <option value="80%" <?= $data->min_percentage_off=='80%' ?'selected':''; ?>>80%</option>
               <option value="90%" <?= $data->min_percentage_off=='90%' ?'selected':''; ?>>90%</option>
               <option value="95%" <?= $data->min_percentage_off=='95%' ?'selected':''; ?>>95%</option>
            </select>
            <p class="description">Choose products with discount. You must set category of product. Note, that this option works not for all categories.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-customer_reviews">Customer reviews</label></th>
         <td><label for="label-customer_reviews"><input type="checkbox" name="content-egg_Amazon[customer_reviews]" id="label-customer_reviews" value="1"> Get user reviews. Reviews will be in iframe. Iframe url is valid only 24 hours, please, use autoupdating function with less than 24 hour to keep actual url.</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-truncate_reviews_at">Cut reviews</label></th>
         <td>
            <input name="content-egg_Amazon[truncate_reviews_at]" id="label-truncate_reviews_at" value="500" class="regular-text">
            <p class="description">Number of characters for one review. 0 - the maximal length of the text.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-editorial_reviews">Parse description</label></th>
         <td><label for="label-editorial_reviews"><input type="checkbox" name="content-egg_Amazon[editorial_reviews]" id="label-editorial_reviews" value="1"  <?php echo isset($data->editorial_reviews) ?'checked':'' ?>> Parse description of products from seller</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-editorial_reviews_type">Type of description</label></th>
         <td>
            <select name="content-egg_Amazon[editorial_reviews_type]" id="label-editorial_reviews_type" value="All">
               <option value="allow_all" <?= $data->editorial_reviews_type=='allow_all' ?'selected':''; ?>>Like on Amazon</option>
               <option value="safe_html" <?= $data->editorial_reviews_type=='safe_html' ?'selected':''; ?>>Safe HTML</option>
               <option value="allowed_tags" <?= $data->editorial_reviews_type=='allowed_tags' ?'selected':''; ?>>Only allowed HTML tags</option>
               <option value="text" <?= $data->editorial_reviews_type=='text' ?'selected':''; ?>>Text only</option>
            </select>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-editorial_reviews_size">Size of description</label></th>
         <td>
            <input name="content-egg_Amazon[editorial_reviews_size]" id="label-editorial_reviews_size" value="<?= $data->editorial_reviews_size; ?>" class="regular-text">
            <p class="description">The maximum size of the item description. 0 - do not cut.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-https_img">Use images with https</label></th>
         <td>
            <label for="label-https_img">
            <input type="checkbox" name="content-egg_Amazon[https_img]" id="label-https_img" value="1" <?php echo isset($data->https_img) ?'checked':'' ?>> Rewrite url of images with https. Use it if you have SSL on your domain</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-save_img">Save images</label></th>
         <td><label for="label-save_img"><input type="checkbox" name="content-egg_Amazon[save_img]" id="label-save_img" value="1" <?php echo isset($data->save_img) ?'checked':'' ?>> Save images on server Enabling this option violates rules of API.</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-show_small_logos">Small logos</label></th>
         <td>
            <label for="label-show_small_logos">
               <input type="checkbox" name="content-egg_Amazon[show_small_logos]" id="label-show_small_logos" value="1"  <?php echo isset($data->show_small_logos) ?'checked':'' ?>> Show small logos
               <p class="description">Read more: <a target="_blank" href="https://advertising.amazon.com/ad-specs/en/policy/brand-usage">Amazon brand usage guidelines</a>.</p>
            </label>
         </td>
      </tr>
      <!-- <tr>
         <th scope="row"><label for="label-associate_tag_us">Associate Tag for US locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_us]" id="label-associate_tag_us" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_uk">Associate Tag for UK locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_uk]" id="label-associate_tag_uk" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_de">Associate Tag for DE locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_de]" id="label-associate_tag_de" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_jp">Associate Tag for JP locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_jp]" id="label-associate_tag_jp" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_cn">Associate Tag for CN locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_cn]" id="label-associate_tag_cn" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_fr">Associate Tag for FR locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_fr]" id="label-associate_tag_fr" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_it">Associate Tag for IT locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_it]" id="label-associate_tag_it" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_es">Associate Tag for ES locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_es]" id="label-associate_tag_es" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_ca">Associate Tag for CA locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_ca]" id="label-associate_tag_ca" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_br">Associate Tag for BR locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_br]" id="label-associate_tag_br" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_in">Associate Tag for IN locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_in]" id="label-associate_tag_in" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_mx">Associate Tag for MX locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_mx]" id="label-associate_tag_mx" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-associate_tag_au">Associate Tag for AU locale</label></th>
         <td>
            <input name="content-egg_Amazon[associate_tag_au]" id="label-associate_tag_au" value="" class="regular-text">
            <p class="description">Type here your tracking ID for this locale if you need multiple locale parsing</p>
         </td>
      </tr> -->
   </tbody>
</table>
<p><button type="Submit" class="button button-primary">Submit Changes</button></p>
</form>