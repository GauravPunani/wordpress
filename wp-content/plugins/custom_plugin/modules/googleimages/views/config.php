<?php  
//    error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_GoogleImages'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['cx']!='' && $data['key']!=''){
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'googleimages'));
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
        WHERE  meta_key= 'googleimages'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>Google Images settings                
 </h3>
<form action="" method="POST">                              
   <table class="form-table">
      <tbody>
         <tr>
            <th scope="row"><label for="label-is_active">Enable module</label></th>
            <td><label for="label-is_active"><input type="checkbox" name="content-egg_GoogleImages[is_active]" id="label-is_active" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-embed_at">Add</label></th>
            <td>
               <select name="content-egg_GoogleImages[embed_at]" id="label-embed_at" value="post_bottom">
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
               <input name="content-egg_GoogleImages[priority]" id="label-priority" value="<?= $data->priority ? $data->priority :'10'; ?>" class="regular-text">
               <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-template">Template</label></th>
            <td>
               <select name="content-egg_GoogleImages[template]" id="label-template" value="data_image">
                  <option value="data_image" <?= $data->template=='data_image' ?'selected':''; ?>>Image</option>
                  <option value="data_justified_gallery" <?= $data->template=='data_justified_gallery' ?'selected':''; ?>>Gallery</option>
                  <option value="data_simple" <?= $data->template=='data_simple' ?'selected':''; ?>>Simple</option>
               </select>
               <p class="description">Default template</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-tpl_title">Title</label></th>
            <td>
               <input name="content-egg_GoogleImages[tpl_title]" id="label-tpl_title" value="<?= $data->tpl_title; ?>" class="regular-text">
               <p class="description">Templates may use title on data output.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-featured_image">Featured image</label></th>
            <td>
               <select name="content-egg_GoogleImages[featured_image]" id="label-featured_image" value="">
                  <option value=""  <?= $data->featured_image=='' ?'selected':''; ?>>Don't set</option>
                  <option value="first" <?= $data->featured_image=='first' ?'selected':''; ?>>First image</option>
                  <option value="second" <?= $data->featured_image=='second' ?'selected':''; ?>>Second image</option>
                  <option value="rand" <?= $data->featured_image=='rand' ?'selected':''; ?>>Random image</option>
                  <option value="last" <?= $data->featured_image=='last' ?'selected':''; ?>>Last image</option>
               </select>
               <p class="description" <?= $data->featured_image=='data_image' ?'selected':''; ?>>Automatically set Featured image for post</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-set_local_redirect">Redirect</label></th>
            <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_GoogleImages[set_local_redirect]" id="label-set_local_redirect" value="1" <?php echo isset($data->set_local_redirect) ?'checked':'' ?>> Make links with local 301 redirect</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-cx">Search engine ID <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_GoogleImages[cx]" id="label-cx" value="<?= $data->cx; ?>" class="regular-text">
               <p class="description">The custom <a target="_blank" href="https://support.google.com/customsearch/answer/2649143">search engine ID</a>. Don't forget to <a target="_blank" href="https://support.google.com/customsearch/answer/2630972">enable image search</a>.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-key">API Key <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_GoogleImages[key]" id="label-key" value="<?= $data->key; ?>"" class="regular-text">
               <p class="description">API access key. You can get in Google <a href="http://code.google.com/apis/console">API console</a>.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page">Results</label></th>
            <td>
               <input name="content-egg_GoogleImages[entries_per_page]" id="label-entries_per_page" value="<?= $data->entries_per_page; ?>"" class="regular-text">
               <p class="description">Number of results for one query. Can not be more than 8.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page_update">Results for updates</label></th>
            <td>
               <input name="content-egg_GoogleImages[entries_per_page_update]" id="label-entries_per_page_update" value="<?= $data->entries_per_page_update; ?>"" class="regular-text">
               <p class="description">Number of results for autoblogging.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-rights">Type of license</label></th>
            <td>
               <select name="content-egg_GoogleImages[rights]" id="label-rights" value="">
                  <option value="" <?= $data->rights=='' ?'selected':''; ?>>Any license</option>
                  <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial|cc_nonderived)" <?= $data->rights=='(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial|cc_nonderived)' ?'selected':''; ?>>Any Creative Commons</option>
                  <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_nonderived).-(cc_noncommercial)" <?= $data->rights=='(cc_publicdomain|cc_attribute|cc_sharealike|cc_nonderived).-(cc_noncommercial)' ?'selected':''; ?>>With Allow of commercial use</option>
                  <option value="(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial).-(cc_nonderived)" <?= $data->rights=='(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial).-(cc_nonderived)' ?'selected':''; ?>>Allowed change</option>
                  <option value="(cc_publicdomain|cc_attribute|cc_sharealike).-(cc_noncommercial|cc_nonderived)" <?= $data->rights=='(cc_publicdomain|cc_attribute|cc_sharealike).-(cc_noncommercial|cc_nonderived)' ?'selected':''; ?>>Commercial use and change</option>
               </select>
               <p class="description">Filters based on licensing. (<a target="_blank" href="https://support.google.com/websearch/answer/29508">Read more</a>).</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-imgSize">Size</label></th>
            <td>
               <select name="content-egg_GoogleImages[imgSize]" id="label-imgSize" value="">
                  <option value="" <?= $data->imgSize=='' ?'selected':''; ?>>Any size</option>
                  <option value="icon" <?= $data->imgSize=='icon' ?'selected':''; ?>>Icon</option>
                  <option value="small" <?= $data->imgSize=='small' ?'selected':''; ?>>Small</option>
                  <option value="medium" <?= $data->imgSize=='medium' ?'selected':''; ?>>Medium</option>
                  <option value="large" <?= $data->imgSize=='large' ?'selected':''; ?>>Large</option>
                  <option value="xlarge" <?= $data->imgSize=='xlarge' ?'selected':''; ?>>XLarge</option>
                  <option value="xxlarge" <?= $data->imgSize=='xxlarge' ?'selected':''; ?>>XXLarge</option>
                  <option value="huge" <?= $data->imgSize=='huge' ?'selected':''; ?>>Huge</option>
               </select>
               <p class="description">Returns images of a specified size.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-imgColorType">Color type</label></th>
            <td>
               <select name="content-egg_GoogleImages[imgColorType]" id="label-imgColorType" value="">
                  <option value="" <?= $data->imgColorType=='' ?'selected':''; ?>>Any</option>
                  <option value="color" <?= $data->imgColorType=='color' ?'selected':''; ?>>Color</option>
                  <option value="gray"> <?= $data->imgColorType=='gray' ?'selected':''; ?>Gray</option>
                  <option value="mono" <?= $data->imgColorType=='mono' ?'selected':''; ?>>Mono</option>
               </select>
               <p class="description">Returns black and white, grayscale, or color images.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-imgDominantColor">Dominant color</label></th>
            <td>
               <select name="content-egg_GoogleImages[imgDominantColor]" id="label-imgDominantColor" value="">
                  <option value="" <?= $data->imgDominantColor=='' ?'selected':''; ?>>Any</option>
                  <option value="black"  <?= $data->imgDominantColor=='black' ?'selected':''; ?>>Black</option>
                  <option value="blue"  <?= $data->imgDominantColor=='blue' ?'selected':''; ?>>Blue</option>
                  <option value="brown"  <?= $data->imgDominantColor=='brown' ?'selected':''; ?>>Brown</option>
                  <option value="gray"  <?= $data->imgDominantColor=='gray' ?'selected':''; ?>>Gray</option>
                  <option value="green" <?= $data->imgDominantColor=='green' ?'selected':''; ?>>Green</option>
                  <option value="pink" <?= $data->imgDominantColor=='pink' ?'selected':''; ?>>Pink</option>
                  <option value="purple" <?= $data->imgDominantColor=='purple' ?'selected':''; ?>>Purple</option>
                  <option value="teal" <?= $data->imgDominantColor=='teal' ?'selected':''; ?>>Teal</option>
                  <option value="white" <?= $data->imgDominantColor=='white' ?'selected':''; ?>>White</option>
                  <option value="yellow" <?= $data->imgDominantColor=='yellow' ?'selected':''; ?>>Yellow</option>
               </select>
               <p class="description">Returns images of a specific dominant color.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-imgType">Type</label></th>
            <td>
               <select name="content-egg_GoogleImages[imgType]" id="label-imgType" value="">
                  <option value="" <?= $data->imgType=='' ?'selected':''; ?>>Any</option>
                  <option value="face" <?= $data->imgType=='face' ?'selected':''; ?>>Faces</option>
                  <option value="photo" <?= $data->imgType=='photo' ?'selected':''; ?>>Photo</option>
                  <option value="clipart" <?= $data->imgType=='clipart' ?'selected':''; ?>>Clip-art</option>
                  <option value="lineart" <?= $data->imgType=='lineart' ?'selected':''; ?>>B/w pictures</option>
                  <option value="news" <?= $data->imgType=='news' ?'selected':''; ?>>News</option>
               </select>
               <p class="description">Returns images of a type.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-safe">Safe search</label></th>
            <td>
               <select name="content-egg_GoogleImages[safe]" id="label-safe" value="medium">
                  <option value="high" <?= $data->imgType=='high' ?'selected':''; ?>>Highest level</option>
                  <option value="medium" <?= $data->imgType=='medium' ?'selected':''; ?>>Moderate</option>
                  <option value="off" <?= $data->imgType=='off' ?'selected':''; ?>>Disabled</option>
               </select>
               <p class="description">Search safety level.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-siteSearch">Search</label></th>
            <td>
               <input name="content-egg_GoogleImages[siteSearch]" id="label-siteSearch" value="<?= $data->siteSearch; ?>"" class="regular-text">
               <p class="description">Limit search to only that domain. For example ask: photobucket.com</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-save_img">Save images</label></th>
            <td><label for="label-save_img"><input type="checkbox" name="content-egg_GoogleImages[save_img]" id="label-save_img" value="1" <?php echo isset($data->save_img) ?'checked':'' ?>> Save images on server</label></td>
         </tr>
      </tbody>
   </table>
   <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>