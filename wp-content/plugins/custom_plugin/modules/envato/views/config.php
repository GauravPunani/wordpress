<?php  
//    error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Envato'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['token']!=''){
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'envato'));
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
        WHERE  meta_key= 'envato'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>Envato Settings</h3>
<form action="" method="POST">
   <input type="hidden" name="option_page" value="content-egg--Envato"><input type="hidden" name="action" value="update"><input type="hidden" id="_wpnonce" name="_wpnonce" value="62304415be"><input type="hidden" name="_wp_http_referer" value="/delta/steempress/wp-admin/admin.php?page=content-egg--Envato">                                
   <table class="form-table">
   </table>
   <table class="form-table">
      <tbody>
         <tr>
            <th scope="row"><label for="label-is_active">Enable module</label></th>
            <td><label for="label-is_active"><input type="checkbox" name="content-egg_Envato[is_active]" id="label-is_active" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-embed_at">Add</label></th>
            <td>
               <select name="content-egg_Envato[embed_at]" id="label-embed_at" value="post_bottom">
                  <option value="post_bottom" <?= $data->embed_at=='' ?'selected':''; ?>>At the end of the post</option>
                  <option value="post_top" <?= $data->embed_at=='' ?'selected':''; ?>>At the beginning of the post</option>
                  <option value="shortcode" <?= $data->embed_at=='' ?'selected':''; ?>>Shortcodes only</option>
               </select>
               <p class="description">The place for content of module. Shortcodes will work in any place regardless of the setting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-priority">Priority</label></th>
            <td>
               <input name="content-egg_Envato[priority]" id="label-priority" value=" <?= $data->priority ? $data->priority :'10'; ?>" class="regular-text">
               <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-template">Template</label></th>
            <td>
               <select name="content-egg_Envato[template]" id="label-template" value="grid">
                  <option value="data_grid">Grid</option>
                  <option value="data_item">Product card</option>
                  <option value="data_list">List</option>
               </select>
               <p class="description">Default template</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-tpl_title">Title</label></th>
            <td>
               <input name="content-egg_Envato[tpl_title]" id="label-tpl_title" value="" class="regular-text">
               <p class="description">Templates may use title on data output.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-featured_image">Featured image</label></th>
            <td>
               <select name="content-egg_Envato[featured_image]" id="label-featured_image" value="">
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
            <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Envato[set_local_redirect]" id="label-set_local_redirect" value="1"> Make links with local 301 redirect</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-ttl">Update by keyword</label></th>
            <td>
               <input name="content-egg_Envato[ttl]" id="label-ttl" value="2592000" class="regular-text">
               <p class="description">Lifetime of cache in seconds, after this period products will be updated if you set keyword for updating. 0 - never update</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-ttl_items">Price update</label></th>
            <td>
               <input name="content-egg_Envato[ttl_items]" id="label-ttl_items" value="604800" class="regular-text">
               <p class="description">Time in seconds for updating prices, availability, etc. 0 - never update</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-update_mode">Update mode</label></th>
            <td>
               <select name="content-egg_Envato[update_mode]" id="label-update_mode" value="visit">
                  <option value="visit" selected="selected">By page view</option>
                  <option value="cron">By schedule (cron)</option>
                  <option value="visit_cron">By page view and by schedule</option>
               </select>
               <p class="description">If you use update by schedule, for more better results change Wordpress cron on real cron</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-token">Token <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_Envato[token]" id="label-token" value="" class="regular-text">
               <p class="description">You can <a href="https://build.envato.com/create-token/">generate a personal token</a> to access Envato API.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-deeplink">Deeplink</label></th>
            <td>
               <input name="content-egg_Envato[deeplink]" id="label-deeplink" value="" class="regular-text">
               <p class="description">Set this option, if you want to send traffic through one of affiliate network with Envato support, eg. https://1.envato.market/c/1234567/123456/1234?u={{url_encoded}}</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-your_username">Your Envato username</label></th>
            <td>
               <input name="content-egg_Envato[your_username]" id="label-your_username" value="" class="regular-text">
               <p class="description">Deprecated. Use Deeplink instead.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page">Results</label></th>
            <td>
               <input name="content-egg_Envato[entries_per_page]" id="label-entries_per_page" value="8" class="regular-text">
               <p class="description">Number of results for one search query.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page_update">Results for updates </label></th>
            <td>
               <input name="content-egg_Envato[entries_per_page_update]" id="label-entries_per_page_update" value="6" class="regular-text">
               <p class="description">Number of results for automatic updates and autoblogging.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-site">Site</label></th>
            <td>
               <select name="content-egg_Envato[site]" id="label-site" value="">
                  <option value="" selected="selected">All</option>
                  <option value="themeforest.net">themeforest.net</option>
                  <option value="photodune.net">photodune.net</option>
                  <option value="codecanyon.net">codecanyon.net</option>
                  <option value="videohive.net">videohive.net</option>
                  <option value="audiojungle.net">audiojungle.net</option>
                  <option value="graphicriver.net">graphicriver.net</option>
                  <option value="3docean.net">3docean.net</option>
               </select>
               <p class="description">The site to match.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-rating_min">Rating min</label></th>
            <td>
               <input name="content-egg_Envato[rating_min]" id="label-rating_min" value="" class="regular-text">
               <p class="description">Minimum rating to filter by.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-price_min">Price min</label></th>
            <td>
               <input name="content-egg_Envato[price_min]" id="label-price_min" value="" class="regular-text">
               <p class="description">Minimum price to include.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-price_max">Price max</label></th>
            <td>
               <input name="content-egg_Envato[price_max]" id="label-price_max" value="" class="regular-text">
               <p class="description">Maximum price to include.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-date">Date</label></th>
            <td>
               <select name="content-egg_Envato[date]" id="label-date" value="">
                  <option value="" selected="selected">Any</option>
                  <option value="this-year">this year</option>
                  <option value="this-month">this month</option>
                  <option value="this-week">this week</option>
                  <option value="this-day">this day</option>
               </select>
               <p class="description">Restrict items by original uploaded date.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-username">Username</label></th>
            <td>
               <input name="content-egg_Envato[username]" id="label-username" value="" class="regular-text">
               <p class="description">Username to restrict by.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-sort_by">Order</label></th>
            <td>
               <select name="content-egg_Envato[sort_by]" id="label-sort_by" value="">
                  <option value="" selected="selected">Default</option>
                  <option value="relevance">relevance</option>
                  <option value="rating">rating</option>
                  <option value="sales">sales</option>
                  <option value="price">price</option>
                  <option value="date">date</option>
                  <option value="updated">updated</option>
                  <option value="category">category</option>
                  <option value="name">name</option>
                  <option value="trending">trending</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-sort_direction">Order direction</label></th>
            <td>
               <select name="content-egg_Envato[sort_direction]" id="label-sort_direction" value="">
                  <option value="" selected="selected">Default</option>
                  <option value="asc">asc</option>
                  <option value="desc">desc</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-resolution_min">Resolution</label></th>
            <td>
               <select name="content-egg_Envato[resolution_min]" id="label-resolution_min" value="">
                  <option value="" selected="selected">All</option>
                  <option value="720p">720p</option>
                  <option value="1080p">1080p</option>
                  <option value="2K">2K</option>
                  <option value="4K">4K</option>
               </select>
               <p class="description">The minimum resolution for video content.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-vocals_in_audio">Vocals</label></th>
            <td>
               <select name="content-egg_Envato[vocals_in_audio]" id="label-vocals_in_audio" value="">
                  <option value="" selected="selected">All</option>
                  <option value="background vocals">background vocals</option>
                  <option value="lead vocals">lead vocals</option>
                  <option value="instrumental version included">instrumental version included</option>
                  <option value="vocal samples">vocal samples</option>
               </select>
               <p class="description">The type of vocal content in audio files.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-description_size">Trim description</label></th>
            <td>
               <input name="content-egg_Envato[description_size]" id="label-description_size" value="300" class="regular-text">
               <p class="description">Description size in characters (0 - do not cut)</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-save_img">Save images</label></th>
            <td><label for="label-save_img"><input type="checkbox" name="content-egg_Envato[save_img]" id="label-save_img" value="1"> Save images on server</label></td>
         </tr>
      </tbody>
   </table>
   <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>