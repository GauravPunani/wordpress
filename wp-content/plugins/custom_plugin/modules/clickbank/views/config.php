<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Clickbank'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['nickname']!=''){
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'clickbank'));
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
        WHERE  meta_key= 'clickbank'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>Clickbank Settings</h3>
<form action="" method="post">
<table class="form-table">
   <tbody>
      <tr>
         <th scope="row"><label for="label-is_active">Enable module</label></th>
         <td><label for="label-is_active"><input type="checkbox" name="content-egg_Clickbank[is_active]" id="label-is_active" value="1"></label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-embed_at">Add</label></th>
         <td>
            <select name="content-egg_Clickbank[embed_at]" id="label-embed_at" value="post_bottom">
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
            <input name="content-egg_Clickbank[priority]" id="label-priority" value="10" class="regular-text">
            <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-template">Template</label></th>
         <td>
            <select name="content-egg_Clickbank[template]" id="label-template" value="simple">
               <option value="data_simple">Simple</option>
            </select>
            <p class="description">Default template</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-tpl_title">Title</label></th>
         <td>
            <input name="content-egg_Clickbank[tpl_title]" id="label-tpl_title" value="" class="regular-text">
            <p class="description">Templates may use title on data output.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
         <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Clickbank[set_local_redirect]" id="label-set_local_redirect" value="1"> Make links with local 301 redirect</label></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-ttl">Update by keyword</label></th>
         <td>
            <input name="content-egg_Clickbank[ttl]" id="label-ttl" value="2592000" class="regular-text">
            <p class="description">Lifetime of cache in seconds, after this period products will be updated if you set keyword for updating. 0 - never update</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-update_mode">Update mode</label></th>
         <td>
            <select name="content-egg_Clickbank[update_mode]" id="label-update_mode" value="visit">
               <option value="visit" selected="selected">By page view</option>
               <option value="cron">By schedule (cron)</option>
               <option value="visit_cron">By page view and by schedule</option>
            </select>
            <p class="description">If you use update by schedule, for more better results change Wordpress cron on real cron</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-nickname">ClickBank nickname <span class="cegg_required">*</span></label></th>
         <td>
            <input name="content-egg_Clickbank[nickname]" id="label-nickname" value="" class="regular-text">
            <p class="description">Your nickname on ClickBank.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-entries_per_page">Results</label></th>
         <td>
            <input name="content-egg_Clickbank[entries_per_page]" id="label-entries_per_page" value="10" class="regular-text">
            <p class="description">Number of results for one search query.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-entries_per_page_update">Results for updates </label></th>
         <td>
            <input name="content-egg_Clickbank[entries_per_page_update]" id="label-entries_per_page_update" value="6" class="regular-text">
            <p class="description">Number of results for automatic updates and autoblogging.</p>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-mainCategoryId">Category </label></th>
         <td>
            <select name="content-egg_Clickbank[mainCategoryId]" id="label-mainCategoryId" value="">
               <option value="" selected="selected">All categories</option>
               <option value="1253.">Arts &amp; Entertainment</option>
               <option value="1510.">Betting Systems</option>
               <option value="1266.">Business / Investing</option>
               <option value="1283.">Computers / Internet</option>
               <option value="1297.">Cooking, Food &amp; Wine</option>
               <option value="1308.">E-business &amp; E-marketing</option>
               <option value="1362.">Education</option>
               <option value="1332.">Employment &amp; Jobs</option>
               <option value="1338.">Fiction</option>
               <option value="1340.">Games</option>
               <option value="1344.">Green Products</option>
               <option value="1347.">Health &amp; Fitness</option>
               <option value="1366.">Home &amp; Garden</option>
               <option value="1377.">Languages</option>
               <option value="1392.">Mobile</option>
               <option value="1400.">Parenting &amp; Families</option>
               <option value="1408.">Politics / Current Events</option>
               <option value="1410.">Reference</option>
               <option value="1419.">Self-Help</option>
               <option value="1432.">Software &amp; Services</option>
               <option value="1461.">Spirituality, New Age &amp; Alternative Beliefs</option>
               <option value="1472.">Sports</option>
               <option value="1494.">Travel</option>
            </select>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-sortField">Sorting</label></th>
         <td>
            <select name="content-egg_Clickbank[sortField]" id="label-sortField" value="">
               <option value="" selected="selected">Keyword Relevance</option>
               <option value="POPULARITY">Popularity</option>
               <option value="AVERAGE_EARNINGS_PER_SALE">Avg $/sale</option>
               <option value="INITIAL_EARNINGS_PER_SALE">Initial $/sale</option>
               <option value="PCT_EARNINGS_PER_SALE">Avg %/sale</option>
               <option value="TOTAL_REBILL">Avg Rebill Total</option>
               <option value="PCT_EARNINGS_PER_REBILL">Avg %/rebill</option>
               <option value="GRAVITY">Gravity</option>
            </select>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-gravityV1">Minimum Gravity</label></th>
         <td><input name="content-egg_Clickbank[gravityV1]" id="label-gravityV1" value="" class="regular-text"></td>
      </tr>
      <tr>
         <th scope="row"><label for="label-productLanguages">Language</label></th>
         <td>
            <select name="content-egg_Clickbank[productLanguages]" id="label-productLanguages" value="">
               <option value="" selected="selected">Any</option>
               <option value="EN">English</option>
               <option value="DE">German</option>
               <option value="ES">Spanish</option>
               <option value="FR">French</option>
               <option value="IT">Italian</option>
               <option value="PT">Portuguese</option>
            </select>
         </td>
      </tr>
      <tr>
         <th scope="row"><label for="label-description_size">Trim description</label></th>
         <td>
            <input name="content-egg_Clickbank[description_size]" id="label-description_size" value="0" class="regular-text">
            <p class="description">Description size in characters (0 - do not cut)</p>
         </td>
      </tr>
   </tbody>
</table>
<p><button type="Submit" class="button button-primary">Submit Changes</button></p>
</form>