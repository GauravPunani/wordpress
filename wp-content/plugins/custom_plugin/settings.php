<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if($_SERVER['REQUEST_METHOD']=='POST'){
   // echo "<pre>";print_r($_POST);die;
   $data=$_POST['contentegg_options'];
   if(is_array($data) && !empty($data)){
      $data=json_encode($data);
      global $wpdb;
      $wpdb->query($wpdb->prepare("UPDATE `wp_custom_plugin` SET meta_value=%s WHERE meta_key=%s",$data,'general'));
      // echo "Data saved";
   } 
}
global $wpdb;

 $result = $wpdb->get_results ( "
    SELECT * 
    FROM  wp_custom_plugin
        WHERE  meta_key= 'general'
" );
$data=json_decode($result[0]->meta_value);
include_once  dirname(__FILE__)."/header.php"; 

?>
<h3>General Settings</h3>

<form action="" method="post">
<table>
  <tr>
    <th>
    Website language
    </th>
    <td><select name="contentegg_options[lang]">
        <option value="eng">English (en)</option>
    </select></td>
  </tr>
  <tr>
    <th>Post Types</th>
    <td>  
      <div class="cegg-checkbox"><label for="label-post_types-post"><input type="checkbox" name="contentegg_options[post_types][post]" id="label-post_types-post"  value="post" <?php echo isset($data->post_types->post) ?'checked':'' ?>>post</label></div>
      <div class="cegg-checkbox"><label for="label-post_types-page"><input type="checkbox" name="contentegg_options[post_types][page]" id="label-post_types-page"  value="page" <?php echo isset($data->post_types->page) ?'checked':'' ?>>page</label></div>
    </td>
  </tr>
  <tr>
    <th>From Name</th>
    <td><input name="contentegg_options[from_name]" id="label-from_name" value="<?= $data->from_name; ?>" class="regular-text">
    <p class="description">This name will appear in the From Name column of emails sent from CE plugin.</p></td>
  </tr>
  <tr>
    <th>From Email</th>
    <td><input name="contentegg_options[from_email]" id="label-from_email" value="<?= $data->from_email; ?>" class="regular-text">
    <p class="description">Customize the From Email address. To avoid your email being marked as spam, it is recommended your "from" match your website.</p></td>
  </tr>
  <tr>
    <th></th>
    <td></td>
  </tr>
  <tr>
    <th></th>
    <td></td>
  </tr>
  <tr>
    <th></th>
    <td></td>
  </tr>
  <tr>
    <th></th>
    <td></td>
  </tr>
</table>
<button class="button button-primary">Save Changes</button>
</form>