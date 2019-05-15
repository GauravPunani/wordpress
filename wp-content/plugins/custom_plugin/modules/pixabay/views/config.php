<?php  
//    error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['content-egg_Pixabay'];
   if(is_array($data) && !empty($data)){
      $key=true;
      if(array_key_exists('is_active', $data)){
             if($data['key']!=''){
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
            $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'pixabay'));
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
        WHERE  meta_key= 'pixabay'
" );
 // echo "<pre>";
 // print_r($result[0]->meta_value);
 $data=json_decode($result[0]->meta_value);
 // print_r($data);
?>
<h3>PixaBay Settings </h3>
<form action="" method="POST">
   <table class="form-table">
      <tbody>
         <tr>
            <th scope="row"><label for="label-is_active">Enable module</label></th>
            <td><label for="label-is_active"><input type="checkbox" name="content-egg_Pixabay[is_active]" id="label-is_active" value="1" <?php echo isset($data->is_active) ?'checked':'' ?>></label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-embed_at">Add</label></th>
            <td>
               <select name="content-egg_Pixabay[embed_at]" id="label-embed_at" value="post_bottom">
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
               <input name="content-egg_Pixabay[priority]" id="label-priority" value="<?= $data->priority ? $data->priority :'10'; ?>" class="regular-text">
               <p class="description">Priority sets order of modules in post. 0 - is the most highest priority. Also it applied to price sorting.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-template">Template</label></th>
            <td>
               <select name="content-egg_Pixabay[template]" id="label-template">
                  <option value="data_image" <?= $data->template=='data_image' ?'selected':''; ?>>Image</option>
                  <option value="data_justified_gallery" <?= $data->template=='data_justified_gallery' ?'selected':''; ?>> Gallery</option>
               </select>
               <p class="description">Default template</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-tpl_title">Title</label></th>
            <td>
               <input name="content-egg_Pixabay[tpl_title]" id="label-tpl_title" value="<?= $data->tpl_title; ?>" class="regular-text">
               <p class="description">Templates may use title on data output.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-featured_image">Featured image</label></th>
            <td>
               <select name="content-egg_Pixabay[featured_image]" id="label-featured_image" value="">
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
            <td><label for="label-set_local_redirect"><input type="checkbox" name="content-egg_Pixabay[set_local_redirect]" id="label-set_local_redirect" value="1" <?php echo isset($data->set_local_redirect) ?'checked':'' ?>> Make links with local 301 redirect</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-key">API Key <span class="cegg_required">*</span></label></th>
            <td>
               <input name="content-egg_Pixabay[key]" id="label-key" value="<?= $data->key; ?>" class="regular-text">
               <p class="description">Key access to Pixabay API. You can get <a href="https://pixabay.com/api/docs/">here</a> (you need to have account).</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page">Results</label></th>
            <td>
               <input name="content-egg_Pixabay[entries_per_page]" id="label-entries_per_page" value="<?= $data->entries_per_page; ?>" class="regular-text">
               <p class="description">Number of results for a single query.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-entries_per_page_update">Results for autoblogging </label></th>
            <td>
               <input name="content-egg_Pixabay[entries_per_page_update]" id="label-entries_per_page_update" value="<?= $data->entries_per_page_update; ?>" class="regular-text">
               <p class="description">Number of results for autoblogging.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-image_size">Size</label></th>
            <td>
               <select name="content-egg_Pixabay[image_size]" id="label-image_size" value="_640">
                  <option value="_180" <?= $data->image_size=='_180' ?'selected':''; ?>>180px</option>
                  <option value="_340" <?= $data->image_size=='_340' ?'selected':''; ?>>340px</option>
                  <option value="_640" <?= $data->image_size=='_640' ?'selected':''; ?>>640px</option>
                  <option value="_960" <?= $data->image_size=='_960' ?'selected':''; ?>>960px</option>
               </select>
               <p class="description">Height size of image</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-image_type">Type of image</label></th>
            <td>
               <select name="content-egg_Pixabay[image_type]" id="label-image_type" value="all">
                  <option value="all" <?= $data->image_type=='all' ?'selected':''; ?>>All</option>
                  <option value="photo" <?= $data->image_type=='photo' ?'selected':''; ?>>Photo</option>
                  <option value="illustration" <?= $data->image_type=='illustration' ?'selected':''; ?>>Illustration</option>
                  <option value="vector" <?= $data->image_type=='vector' ?'selected':''; ?>>Vector</option>
               </select>
               <p class="description">A media type to search within.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-orientation">Orientation</label></th>
            <td>
               <select name="content-egg_Pixabay[orientation]" id="label-orientation" value="all">
                  <option value="all" <?= $data->orientation=='all' ?'selected':''; ?>>All</option>
                  <option value="horizontal" <?= $data->orientation=='horizontal' ?'selected':''; ?>>Horizontal</option>
                  <option value="vertical" <?= $data->orientation=='vertical' ?'selected':''; ?>>Vertical</option>
               </select>
               <p class="description">Whether an image is wider than it is tall, or taller than it is wide.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-category">Category </label></th>
            <td>
               <select name="content-egg_Pixabay[category]" id="label-category" value="">
                  <option value="" <?= $data->category=='vertical' ?'selected':''; ?>>All</option>
                  <option value="fashion" <?= $data->category=='fashion' ?'selected':''; ?>>Fashion</option>
                  <option value="nature" <?= $data->category=='nature' ?'selected':''; ?>>Nature</option>
                  <option value="backgrounds" <?= $data->category=='backgrounds' ?'selected':''; ?>>Backgrounds</option>
                  <option value="science" <?= $data->category=='science' ?'selected':''; ?>>Science</option>
                  <option value="education" <?= $data->category=='education' ?'selected':''; ?>>Education</option>
                  <option value="people" <?= $data->category=='people' ?'selected':''; ?>>People</option>
                  <option value="feelings" <?= $data->category=='feelings' ?'selected':''; ?>>Feelings</option>
                  <option value="religion" <?= $data->category=='religion' ?'selected':''; ?>>Religion</option>
                  <option value="health" <?= $data->category=='health' ?'selected':''; ?>>Health</option>
                  <option value="places" <?= $data->category=='places' ?'selected':''; ?>>Places</option>
                  <option value="animals" <?= $data->category=='animals' ?'selected':''; ?>>Animals</option>
                  <option value="industry" <?= $data->category=='industry' ?'selected':''; ?>>Industry</option>
                  <option value="food" <?= $data->category=='food' ?'selected':''; ?>>Food</option>
                  <option value="computer" <?= $data->category=='computer' ?'selected':''; ?>>Computer</option>
                  <option value="sports" <?= $data->category=='sports' ?'selected':''; ?>>Sports</option>
                  <option value="transportation" <?= $data->category=='transportation' ?'selected':''; ?>>Transportation</option>
                  <option value="travel" <?= $data->category=='travel' ?'selected':''; ?>>Travel</option>
                  <option value="buildings" <?= $data->category=='buildings' ?'selected':''; ?>>Buildings</option>
                  <option value="business" <?= $data->category=='business' ?'selected':''; ?>>Business</option>
                  <option value="music" <?= $data->category=='music' ?'selected':''; ?>>Music</option>
               </select>
               <p class="description">Filter images by category.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-editors_choice">Choose editor</label></th>
            <td><label for="label-editors_choice"><input type="checkbox" name="content-egg_Pixabay[editors_choice]" id="label-editors_choice" value="1" <?php echo isset($data->editors_choice) ?'checked':'' ?>> Select images that have received an Editor's Choice award.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-safesearch">Safe search</label></th>
            <td><label for="label-safesearch"><input type="checkbox" name="content-egg_Pixabay[safesearch]" id="label-safesearch" value="1"  <?php echo isset($data->safesearch) ?'checked':'' ?>> A flag indicating that only images suitable for all ages should be returned.</label></td>
         </tr>
         <tr>
            <th scope="row"><label for="label-order">Sorting</label></th>
            <td>
               <select name="content-egg_Pixabay[order]" id="label-order" value="popular">
                  <option value="popular" <?= $data->order=='popular' ?'selected':''; ?>>Popular</option>
                  <option value="latest" <?= $data->order=='latest' ?'selected':''; ?>>Latest</option>
               </select>
               <p class="description">How the results should be ordered.</p>
            </td>
         </tr>
         <tr>
            <th scope="row"><label for="label-save_img">Save images</label></th>
            <td><label for="label-save_img"><input type="checkbox" name="content-egg_Pixabay[save_img]" id="label-save_img"  value="1" <?php echo isset($data->save_img) ? 'checked':'' ?>> Save images to your server. Hotlinking is prohibited by Pixabay. If you don't save images to your server, external pixabay links will be valid only 24 hours.</label></td>
         </tr>
      </tbody>
   </table>
   <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>