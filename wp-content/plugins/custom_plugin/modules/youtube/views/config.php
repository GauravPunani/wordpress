<?php  
//    error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Youtube'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['api_key']!=''){
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'youtube'));
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
        WHERE  meta_key= 'youtube'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>Youtube Settings</h3>
<form action="" method="POST">                            
   <table class="form-table">
      <tbody>
         <tr>
            <th scope="row"><label for="label-is_active">Enable module</label></th>
            <td><label for="label-is_active"><input type="checkbox" name="content-egg_Youtube[is_active]" id="label-is_active" checked="checked" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-embed_at">Add</label></th>
            <td>
               <select name="content-egg_Youtube[embed_at]" id="label-embed_at" value="post_bottom">
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
               <input name="content-egg_Youtube[priority]" id="label-priority" value="<?= $data->priority ? $data->priority :'10'; ?>" class="regular-text">
               <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-template">Template</label></th>
            <td>
               <select name="content-egg_Youtube[template]" id="label-template" value="data_simple">
                  <option value="data_responsive_embed" <?= $data->template=='data_responsive_embed' ?'selected':''; ?>>Large</option>
                  <option value="data_simple" <?= $data->template=='data_simple' ?'selected':''; ?>>Simple</option>
                  <option value="data_tile" <?= $data->template=='data_tile' ?'selected':''; ?>>Tile</option>
               </select>
               <p class="description">Default template</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-tpl_title">Title</label></th>
            <td>
               <input name="content-egg_Youtube[tpl_title]" id="label-tpl_title" value="<?= $data->tpl_title; ?>" class="regular-text">
               <p class="description">Templates may use title on data output.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
            <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Youtube[set_local_redirect]" id="label-set_local_redirect" checked="checked" value="1" <?php echo isset($data->set_local_redirect) ?'checked':'' ?>> Make links with local 301 redirect</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-api_key">API Key <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_Youtube[api_key]" id="label-api_key" value="<?= $data->api_key; ?>" class="regular-text">
               <p class="description">API access key. You can get in Google <a href="http://code.google.com/apis/console">API console</a>.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page">Results</label></th>
            <td>
               <input name="content-egg_Youtube[entries_per_page]" id="label-entries_per_page" value="<?= $data->entries_per_page; ?>" class="regular-text">
               <p class="description">Number of results for a single query</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page_update">Results for autoblogging </label></th>
            <td>
               <input name="content-egg_Youtube[entries_per_page_update]" id="label-entries_per_page_update" value="<?= $data->entries_per_page; ?>" class="regular-text">
               <p class="description">Number of results for autoblogging.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-order">Sorting</label></th>
            <td>
               <select name="content-egg_Youtube[order]" id="label-order" value="relevance">
                  <option value="date"  <?= $data->order=='date' ?'selected':''; ?>>Date</option>
                  <option value="rating" <?= $data->order=='rating' ?'selected':''; ?>>Rating</option>
                  <option value="relevance" <?= $data->order=='relevance' ?'selected':''; ?>>Relevance</option>
                  <option value="title" <?= $data->order=='title' ?'selected':''; ?>>Title</option>
                  <option value="viewCount" <?= $data->order=='viewCount' ?'selected':''; ?>>Views</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-license">Type of license</label></th>
            <td>
               <select name="content-egg_Youtube[license]" id="label-license" value="any">
                  <option value="any" <?= $data->license=='any' ?'selected':''; ?>>Any license</option>
                  <option value="creativeCommon" <?= $data->license=='creativeCommon' ?'selected':''; ?>>Creative Commons license</option>
                  <option value="youtube" <?= $data->license=='youtube' ?'selected':''; ?>>Standard license</option>
               </select>
               <p class="description">Many videos on Youtube have Creative Commons license. <a href="http://www.google.com/support/youtube/bin/answer.py?answer=1284989">Know more</a>.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-description_size">Trim description</label></th>
            <td>
               <input name="content-egg_Youtube[description_size]" id="label-description_size" value="<?= $data->description_size; ?>" class="regular-text">
               <p class="description">Description size in characters (0 - do not cut)</p>
            </td>
         </tr>
      </tbody>
   </table>
<?php submit_button(); ?>
</form>