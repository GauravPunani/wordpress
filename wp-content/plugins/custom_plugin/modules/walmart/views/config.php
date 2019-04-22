<?php  
//    error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Walmart'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['apiKey']!='' && $data['lsPublisherId']!=''){
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'walmart'));
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
        WHERE  meta_key= 'walmart'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>Walmart Settings </h3>
<form action="" method="POST">
   <table class="form-table">
      <tbody>
         <tr>
            <th scope="row"><label for="label-is_active">Enable module</label></th>
            <td><label for="label-is_active"><input type="checkbox" name="content-egg_Walmart[is_active]" id="label-is_active" value="1"></label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-embed_at">Add</label></th>
            <td>
               <select name="content-egg_Walmart[embed_at]" id="label-embed_at" value="post_bottom">
                  <option value="post_bottom" selected="selected">At the end of the post</option>
                  <option value="post_top">At the beginning of the post</option>
                  <option value="shortcode">Shortcodes only</option>
               </select>
               <p class="description">The place for content of module. Shortcodes will work in any place regardless of the setting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-priority">Priority</label></th>
            <td>
               <input name="content-egg_Walmart[priority]" id="label-priority" value="10" class="regular-text">
               <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-template">Template</label></th>
            <td>
               <select name="content-egg_Walmart[template]" id="label-template" value="grid">
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
               <input name="content-egg_Walmart[tpl_title]" id="label-tpl_title" value="" class="regular-text">
               <p class="description">Templates may use title on data output.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-featured_image">Featured image</label></th>
            <td>
               <select name="content-egg_Walmart[featured_image]" id="label-featured_image" value="">
                  <option value="" selected="selected">Don't set</option>
                  <option value="first">First image</option>
                  <option value="second">Second image</option>
                  <option value="rand">Random image</option>
                  <option value="last">Last image</option>
               </select>
               <p class="description">Automatically set Featured image for post</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
            <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Walmart[set_local_redirect]" id="label-set_local_redirect" value="1"> Make links with local 301 redirect</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-ttl">Update by keyword</label></th>
            <td>
               <input name="content-egg_Walmart[ttl]" id="label-ttl" value="2592000" class="regular-text">
               <p class="description">Lifetime of cache in seconds, after this period products will be updated if you set keyword for updating. 0 - never update</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-ttl_items">Price update</label></th>
            <td>
               <input name="content-egg_Walmart[ttl_items]" id="label-ttl_items" value="604800" class="regular-text">
               <p class="description">Time in seconds for updating prices, availability, etc. 0 - never update</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-update_mode">Update mode</label></th>
            <td>
               <select name="content-egg_Walmart[update_mode]" id="label-update_mode" value="visit">
                  <option value="visit" selected="selected">By page view</option>
                  <option value="cron">By schedule (cron)</option>
                  <option value="visit_cron">By page view and by schedule</option>
               </select>
               <p class="description">If you use update by schedule, for more better results change Wordpress cron on real cron</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-apiKey">API Key <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_Walmart[apiKey]" id="label-apiKey" value="" class="regular-text">
               <p class="description">Go to <a href="https://developer.walmartlabs.com/apps/mykeys">Walmart Product APIs</a> panel to obtain your API access key.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-lsPublisherId">LinkShare Publisher ID <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_Walmart[lsPublisherId]" id="label-lsPublisherId" value="" class="regular-text">
               <p class="description">You can find your Publisher ID mentioned as partner id in the top right corner of <a target="_blank" href="https://affiliates.walmart.com/#!/banners">https://affiliates.walmart.com/#!/banners</a> (after you login using your LinkShare account).</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page">Results</label></th>
            <td>
               <input name="content-egg_Walmart[entries_per_page]" id="label-entries_per_page" value="8" class="regular-text">
               <p class="description">Number of results for one search query.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page_update">Results for updates </label></th>
            <td>
               <input name="content-egg_Walmart[entries_per_page_update]" id="label-entries_per_page_update" value="6" class="regular-text">
               <p class="description">Number of results for automatic updates and autoblogging.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-categoryId">Category</label></th>
            <td>
               <select name="content-egg_Walmart[categoryId]" id="label-categoryId" value="">
                  <option value="" selected="selected">[ All ]</option>
                  <option value=".1334134">Arts, Crafts &amp; Sewing</option>
                  <option value=".91083">Auto &amp; Tires</option>
                  <option value=".5427">Baby</option>
                  <option value=".1085666">Beauty</option>
                  <option value=".3920">Books</option>
                  <option value=".1105910">Cell Phones</option>
                  <option value=".5438">Clothing</option>
                  <option value=".3944">Electronics</option>
                  <option value=".976759">Food</option>
                  <option value=".1094765">Gifts &amp; Registry</option>
                  <option value=".976760">Health</option>
                  <option value=".4044">Home</option>
                  <option value=".1072864">Home Improvement</option>
                  <option value=".1115193">Household Essentials</option>
                  <option value=".6197502">Industrial &amp; Scientific</option>
                  <option value=".3891">Jewelry</option>
                  <option value=".4096">Movies &amp; TV</option>
                  <option value=".4104">Music on CD or Vinyl</option>
                  <option value=".7796869">Musical Instruments</option>
                  <option value=".1229749">Office</option>
                  <option value=".2637">Party &amp; Occasions</option>
                  <option value=".5428">Patio &amp; Garden</option>
                  <option value=".1005862">Personal Care</option>
                  <option value=".5440">Pets</option>
                  <option value=".5426">Photo Center</option>
                  <option value=".1085632">Seasonal</option>
                  <option value=".6163033">Services</option>
                  <option value=".4125">Sports &amp; Outdoors</option>
                  <option value=".4171">Toys</option>
                  <option value=".2636">Video Games</option>
               </select>
               <p class="description">Sorting criteria.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-sort">Sort</label></th>
            <td>
               <select name="content-egg_Walmart[sort]" id="label-sort" value="relevance">
                  <option value="relevance" selected="selected">Relevance</option>
                  <option value="price">Price</option>
                  <option value="title">Title</option>
                  <option value="bestseller">Bestseller</option>
                  <option value="customerRating">Customer Rating</option>
                  <option value="new">New</option>
               </select>
               <p class="description">Sorting criteria.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-order">Order</label></th>
            <td>
               <select name="content-egg_Walmart[order]" id="label-order" value="relevance">
                  <option value="asc">Asc</option>
                  <option value="desc">Desc</option>
               </select>
               <p class="description">Sort ordering criteria. This parameter is needed only for the sort types: Price, Title, Customer Rating.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-price_min">Price min</label></th>
            <td>
               <input name="content-egg_Walmart[price_min]" id="label-price_min" value="" class="regular-text">
               <p class="description">Minimum price to include.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-price_max">Price max</label></th>
            <td>
               <input name="content-egg_Walmart[price_max]" id="label-price_max" value="" class="regular-text">
               <p class="description">Maximum price to include.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-description_size">Trim description</label></th>
            <td>
               <input name="content-egg_Walmart[description_size]" id="label-description_size" value="300" class="regular-text">
               <p class="description">Description size in characters (0 - do not cut)</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-customer_reviews">Customer reviews</label></th>
            <td><label for="label-customer_reviews"><input type="checkbox" name="content-egg_Walmart[customer_reviews]" id="label-customer_reviews" value="1"> Parse customer reviews. It takes more time. Don't check if you don't need it.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-reviews_as_comments">Reviews as post comments</label></th>
            <td><label for="label-reviews_as_comments"><input type="checkbox" name="content-egg_Walmart[reviews_as_comments]" id="label-reviews_as_comments" value="1"> Save user reviews as post comments.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-save_img">Save images</label></th>
            <td><label for="label-save_img"><input type="checkbox" name="content-egg_Walmart[save_img]" id="label-save_img" value="1"> Save images on server</label></td>
         </tr>
      </tbody>
   </table>
   <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>