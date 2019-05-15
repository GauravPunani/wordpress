<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Aliexpress'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['api_key']!=''){
                  $key=true;
            } 
            else{
                  $key=false;
                     echo "<p style='color:red;'>api key can't be empty</p>";
            } 
      }
            
            
      if($key){
            $data=json_encode($data);
            global $wpdb;
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'aliexpress'));
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
        WHERE  meta_key= 'aliexpress'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 //~ print_r($data);
?>

<h3>Aliexpress settings</h3>
<form action="" method="post">
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row"><label for="label-is_active">Enable module</label></th>
         <td><label for="label-is_active"><input type="checkbox" name="content-egg_Aliexpress[is_active]" id="label-is_active" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-embed_at">Add</label></th>
         <td>
            <select name="content-egg_Aliexpress[embed_at]" id="label-embed_at" value="post_bottom">
               <option value="post_bottom" <?= $data->embed_at='post_bottom' ?'selected':''; ?>>At the end of the post</option>
               <option value="post_top" <?= $data->embed_at='post_top' ?'selected':''; ?>>At the beginning of the post</option>
               <option value="shortcode" <?= $data->embed_at='shortcode' ?'selected':''; ?>>Shortcodes only</option>
            </select>
            <p class="description">The place for content of module. Shortcodes will work in any place regardless of the setting.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-priority">Priority</label></th>
         <td>
            <input name="content-egg_Aliexpress[priority]" id="label-priority" value="<?= $data->priority ? $data->priority :'10'; ?>" class="regular-text">
            <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-template">Template</label></th>
         <td>
            <select name="content-egg_Aliexpress[template]" id="label-template" value="grid">
               <option value="data_grid">Grid</option>
               <option value="data_item">Product card</option>
               <option value="data_list">List</option>
               <option value="data_price_tracker_alert">Price tracker &amp; alert</option>
            </select>
            <p class="description">Default template</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-tpl_title">Title</label></th>
         <td>
            <input name="content-egg_Aliexpress[tpl_title]" value="<?= $data->tpl_title; ?>" id="label-tpl_title" value="" class="regular-text">
            <p class="description">Templates may use title on data output.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-featured_image">Featured image</label></th>
         <td>
            <select name="content-egg_Aliexpress[featured_image]" id="label-featured_image" value="">
               <option value="" <?= $data->featured_image=='' ?'selected':''; ?>>Don't set</option>
               <option value="first" <?= $data->featured_image=='first' ?'selected':''; ?>>First image</option>
               <option value="second" <?= $data->featured_image=='second' ?'selected':''; ?>>Second image</option>
               <option value="rand" <?= $data->featured_image=='rand' ?'selected':''; ?>>Random image</option>
               <option value="last" <?= $data->featured_image=='last' ?'selected':''; ?>>Last image</option>
            </select>
            <p class="description">Automatically set Featured image for post</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
         <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Aliexpress[set_local_redirect]" id="label-set_local_redirect" value="1" <?= isset($data->set_local_redirect) ?'checked':'' ?>> Make links with local 301 redirect</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-ttl">Update by keyword</label></th>
         <td>
            <input name="content-egg_Aliexpress[ttl]" id="label-ttl" value="2592000" class="regular-text">
            <p class="description">Lifetime of cache in seconds, after this period products will be updated if you set keyword for updating. 0 - never update</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-ttl_items">Price update</label></th>
         <td>
            <input name="content-egg_Aliexpress[ttl_items]" id="label-ttl_items" value="604800" class="regular-text">
            <p class="description">Time in seconds for updating prices, availability, etc. 0 - never update</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-update_mode">Update mode</label></th>
         <td>
            <select name="content-egg_Aliexpress[update_mode]" id="label-update_mode" value="visit">
               <option value="visit" selected="selected">By page view</option>
               <option value="cron">By schedule (cron)</option>
               <option value="visit_cron">By page view and by schedule</option>
            </select>
            <p class="description">If you use update by schedule, for more better results change Wordpress cron on real cron</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-api_key">API Key <span class="cegg_required">*</span></label></th>
         <td>
            <input name="content-egg_Aliexpress[api_key]" id="label-api_key" value="<?= $data->api_key; ?>" class="regular-text">
            <p class="description">Special key to access Aliexpress API. You can get it <a target="_blank" href="http://portals.aliexpress.com/adcenter/api_setting.htm">here</a>.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-tracking_id">Tracking ID</label></th>
         <td>
            <input name="content-egg_Aliexpress[tracking_id]" id="label-tracking_id" value="<?= $data->tracking_id; ?>" class="regular-text">
            <p class="description">Specify if you want to send traffic through the original affiliate program Aliexpress. You can find it <a target="_blank" href="http://portals.aliexpress.com/track_id_manage.htm">here</a>. This option must be set before saving products in database.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-deeplink">Deeplink</label></th>
         <td>
            <input name="content-egg_Aliexpress[deeplink]" id="label-deeplink" value="<?= $data->deeplink; ?>" class="regular-text">
            <p class="description">Set this option, if you want to send traffic to one of CPA-network with support of aliexpress and deeplink.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-entries_per_page">Results</label></th>
         <td>
            <input name="content-egg_Aliexpress[entries_per_page]" id="label-entries_per_page" value="<?= $data->entries_per_page!='' ?$data->entries_per_page:'10'; ?>" class="regular-text">
            <p class="description">Number of results for one search query.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-entries_per_page_update">Results for updates </label></th>
         <td>
            <input name="content-egg_Aliexpress[entries_per_page_update]" id="label-entries_per_page_update" value="<?= $data->entries_per_page_update!='' ?$data->entries_per_page_update:'6'; ?>" class="regular-text">
            <p class="description">Number of results for automatic updates and autoblogging.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-category_id">Category </label></th>
         <td>
            <select name="content-egg_Aliexpress[category_id]" id="label-category_id" value="0">
               <option value="0" selected="selected">All categories</option>
               <option value="3">Apparel &amp; Accessories</option>
               <option value="34">Automobiles &amp; Motorcycles</option>
               <option value="1501">Baby Products</option>
               <option value="66">Beauty &amp; Health</option>
               <option value="7">Computer &amp; Networking</option>
               <option value="13">Construction &amp; Real Estate</option>
               <option value="44">Consumer Electronics</option>
               <option value="100008578">Customized Products</option>
               <option value="5">Electrical Equipment &amp; Supplies</option>
               <option value="502">Electronic Components &amp; Supplies</option>
               <option value="2">Food</option>
               <option value="1503">Furniture</option>
               <option value="200003655">Hair &amp; Accessories</option>
               <option value="42">Hardware</option>
               <option value="15">Home &amp; Garden</option>
               <option value="6">Home Appliances</option>
               <option value="200003590">Industry &amp; Business</option>
               <option value="36">Jewelry &amp; Watch</option>
               <option value="39">Lights &amp; Lighting</option>
               <option value="1524">Luggage &amp; Bags</option>
               <option value="21">Office &amp; School Supplies</option>
               <option value="509">Phones &amp; Telecommunications</option>
               <option value="30">Security &amp; Protection</option>
               <option value="322">Shoes</option>
               <option value="200001075">Special Category</option>
               <option value="18">Sports &amp; Entertainment</option>
               <option value="1420">Tools</option>
               <option value="26">Toys &amp; Hobbies</option>
               <option value="1511">Watches</option>
            </select>
            <p class="description">Limit the search of goods by this category.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-high_quality_items">Best quality products</label></th>
         <td><label for="label-high_quality_items"><input type="checkbox" name="content-egg_Aliexpress[high_quality_items]" id="label-high_quality_items" value="1" <?= $data->high_quality_items!='' ?'checked':'' ?>> Only products with high sales, good user feedbacks</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-local_currency">Currency</label></th>
         <td>
            <select name="content-egg_Aliexpress[local_currency]" id="label-local_currency" value="USD">
               <option value="USD" selected="selected">USD</option>
               <option value="RUB">RUB</option>
               <option value="GBP">GBP</option>
               <option value="BRL">BRL</option>
               <option value="CAD">CAD</option>
               <option value="AUD">AUD</option>
               <option value="EUR">EUR</option>
               <option value="INR">INR</option>
               <option value="UAH">UAH</option>
               <option value="JPY">JPY</option>
               <option value="MXN">MXN</option>
               <option value="IDR">IDR</option>
               <option value="TRY">TRY</option>
               <option value="SEK">SEK</option>
            </select>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-language">Language</label></th>
         <td>
            <select name="content-egg_Aliexpress[language]" id="label-language" value="en">
               <option value="en" selected="selected">en</option>
               <option value="pt">pt</option>
               <option value="ru">ru</option>
               <option value="es">es</option>
               <option value="fr">fr</option>
               <option value="id">id</option>
               <option value="it">it</option>
               <option value="nl">nl</option>
               <option value="tr">tr</option>
               <option value="vi">vi</option>
               <option value="th">th</option>
               <option value="de">de</option>
               <option value="ko">ko</option>
               <option value="ja">ja</option>
               <option value="ar">ar</option>
               <option value="pl">pl</option>
               <option value="he">he</option>
            </select>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-commission_rate_from">Minimal commission</label></th>
         <td>
            <input name="content-egg_Aliexpress[commission_rate_from]" id="label-commission_rate_from" value="<?= $data->commission_rate_from; ?>" class="regular-text">
            <p class="description">Minimal commission (without %). Example, 3</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-original_price_from">Minimal price</label></th>
         <td>
            <input name="content-egg_Aliexpress[original_price_from]" id="label-original_price_from" value="<?= $data->original_price_from; ?>" class="regular-text">
            <p class="description">Must be set in USD. Example, 12.34</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-original_price_to">Maximal price</label></th>
         <td>
            <input name="content-egg_Aliexpress[original_price_to]" id="label-original_price_to" value="<?= $data->original_price_to; ?>" class="regular-text">
            <p class="description">Must be set in USD. Example, 56.78</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-volume_from">Minimal sales</label></th>
         <td>
            <input name="content-egg_Aliexpress[volume_from]" id="label-volume_from" value="<?= $data->volume_from; ?>" class="regular-text">
            <p class="description">Minimal number of partner sales for last month. Example, 123</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-volume_to">Maximal sales</label></th>
         <td>
            <input name="content-egg_Aliexpress[volume_to]" id="label-volume_to" value="<?= $data->volume_to; ?>" class="regular-text">
            <p class="description">Max number of partner sales for last month. Example, 456</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-sort">Sorting</label></th>
         <td>
            <select name="content-egg_Aliexpress[sort]" id="label-sort" value="">
               <option value="" selected="selected">Default</option>
               <option value="orignalPriceUp">Price low to high</option>
               <option value="orignalPriceDown">Price high to low</option>
               <option value="sellerRateDown">Seller rating</option>
               <option value="commissionRateUp">Commission from low to high</option>
               <option value="commissionRateDown">Commission from high to low</option>
               <option value="volumeDown">Sales</option>
               <option value="validTimeUp">Lifetime from low to high</option>
               <option value="validTimeDown">Lifetime from high to low</option>
            </select>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-start_credit_score">Seller rating</label></th>
         <td>
            <input name="content-egg_Aliexpress[start_credit_score]" id="label-start_credit_score" value="<?= $data->start_credit_score; ?>" class="regular-text">
            <p class="description">Minimal seller rating, for example 12</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-save_img">Save images</label></th>
         <td><label for="label-save_img"><input type="checkbox" name="content-egg_Aliexpress[save_img]" id="label-save_img" value="1" <?= $data->save_img ?'checked':'';?>> Save images on server</label></td>
      </tr>
   </tbody>
</table>
<p><button type="Submit" class="button button-primary">Submit Changes</button></p>
</form>
