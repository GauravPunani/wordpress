<?php  
//    error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_GoogleBooks'];
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'googlebooks'));
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
        WHERE  meta_key= 'googlebooks'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>Google Books Settings</h3>
<form action="" method="POST">                                
   <table class="form-table">
      <tbody>
         <tr>
            <th scope="row"><label for="label-is_active">Enable module</label></th>
            <td><label for="label-is_active"><input type="checkbox" name="content-egg_GoogleBooks[is_active]" id="label-is_active" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-embed_at">Add</label></th>
            <td>
               <select name="content-egg_GoogleBooks[embed_at]" id="label-embed_at" value="post_bottom">
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
               <input name="content-egg_GoogleBooks[priority]" id="label-priority" value="<?= $data->priority ? $data->priority :'10'; ?>" class="regular-text">
               <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-template">Template</label></th>
            <td>
               <select name="content-egg_GoogleBooks[template]" id="label-template" value="data_simple">
                  <option value="data_simple" <?= $data->template=='data_simple' ?'selected':''; ?>>Simple</option>
               </select>
               <p class="description">Default template</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-tpl_title">Title</label></th>
            <td>
               <input name="content-egg_GoogleBooks[tpl_title]" id="label-tpl_title" value="<?= $data->tpl_title; ?>" class="regular-text">
               <p class="description">Templates may use title on data output.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
            <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_GoogleBooks[set_local_redirect]" id="label-set_local_redirect" value="1" <?= isset($data->set_local_redirect) ?'checked':'' ?>> Make links with local 301 redirect</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-api_key">API Key <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_GoogleBooks[api_key]" id="label-api_key" value="<?= $data->api_key; ?>" class="regular-text">
               <p class="description">API access key. You can get it in Google <a href="http://code.google.com/apis/console">API console</a>.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page">Results</label></th>
            <td>
               <input name="content-egg_GoogleBooks[entries_per_page]" id="label-entries_per_page" value="<?= $data->entries_per_page; ?>" class="regular-text">
               <p class="description">Number of results for a single query</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page_update">Results for autoblogging </label></th>
            <td>
               <input name="content-egg_GoogleBooks[entries_per_page_update]" id="label-entries_per_page_update" value="<?= $data->entries_per_page_update; ?>" class="regular-text">
               <p class="description">Number of results for autoblogging.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-country">Country</label></th>
            <td>
               <input name="content-egg_GoogleBooks[country]" id="label-country" value="<?= $data->country; ?>" class="regular-text">
               <p class="description">The appropriate <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">2 letter</a> code represent the country which you are wanting to search from.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-save_img">Save images</label></th>
            <td><label for="label-save_img"><input type="checkbox" name="content-egg_GoogleBooks[save_img]" id="label-save_img" value="<?= isset($data->save_img) ?'checked':'' ?>"> Save images on server</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-description_size">Trim description</label></th>
            <td>
               <input name="content-egg_GoogleBooks[description_size]" id="label-description_size" value="<?= $data->description_size; ?>" class="regular-text">
               <p class="description">Description size in characters (0 - do not cut)</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-orderby">Sorting</label></th>
            <td>
               <select name="content-egg_GoogleBooks[orderby]" id="label-orderby" value="relevance">
                  <option value="relevance" <?= $data->orderby=='relevance' ?'selected':''; ?>>Relevance</option>
                  <option value="newest" <?= $data->orderby=='newest' ?'selected':''; ?>>Newness</option>
               </select>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-printType">Publication type</label></th>
            <td>
               <select name="content-egg_GoogleBooks[printType]" id="label-printType" value="all">
                  <option value="all" <?= $data->printType=='all' ?'selected':''; ?>>Any</option>
                  <option value="books" <?= $data->printType=='books' ?'selected':''; ?>>Books</option>
                  <option value="magazines" <?= $data->printType=='magazines' ?'selected':''; ?>>Magazines</option>
               </select>
            </td>
         </tr>
      </tbody>
   </table>
   <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>