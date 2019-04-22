<?php


/*I want to search for news articles that mention a specific topic or keyword */
    class googlebooks {

      public function getdata($query,$startIndex=0) {
        $endpoint="https://www.googleapis.com/books/v1/volumes?";
        $param=[
            'q'=>$query."+inauthor:keyes",
            'key'=>'AIzaSyB6CZOuDc6CqIQhKO-VQIC86SAhlAmzHNo',
            'startIndex'=>$startIndex,
            'maxResults'=>5
        ];
      $url=$endpoint.http_build_query($param);
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
  
      $headers = [
      'Content-Type: application/json'
      ];  
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

      $json = curl_exec($ch);

      curl_close($ch);

      $array = json_decode($json);
      
      return $array;     
      }

      public function parseResult($results)
      {
        $data=array();
        $totalItems=$results->totalItems;
        if(!empty($results->items)){
          foreach($results->items as $k=>$value){
            $key=md5(microtime().rand());
            if(isset($value->volumeInfo->imageLinks->thumbnail))
              $data[$key]['thumbnail']=$value->volumeInfo->imageLinks->thumbnail;
            else
              $data[$key]['thumbnail']='';

              $data[$key]['title']=$value->volumeInfo->title;
              if(isset($value->volumeInfo->description))
                $data[$key]['description']=$value->volumeInfo->description;
              else
                $data[$key]['description']='';
          }
       }
          return array($data,$totalItems);
      }
      function preparehtml($results,$totalItems,$query='',$startIndex=0){
              $html='';
             if(is_array((array)$results) && !empty($results)){
              foreach($results as $key=>$value){
                   
                  $html .='<div class="row copy_div" id=googlebooks_'.$key.'>'; 
                  if($value['thumbnail']!=''){
                    $html .= '<div class="col-sm-1 img_box"><img class="img-fluid " src="'.$value['thumbnail'].'" alt=""></div>';
                  }
                  else{
                    $html .= '<div class="col-sm-1 img_box"><img width="20px" height="20px" alt=""></div>';
                  }  

                  
                  $html .='<div class="col-sm-11 txt_box">';
                  $html .='<p><b>'.$value['title'].'</b><br>';
                  if($value['description']!='')
                    $html.=strlen($value['description']) > 200 ? substr($value['description'],0,200)."..." : $value['description']."</p>";
                  else
                    $html .="</p>";
                  
                  $html .='</div>';
                  $html .='</div>';
              }
            }
            else{
				$html .="<p>No Item Found!!</p>";
				}
					
				
              if($startIndex+5<$totalItems)
              {
						$nextIndex=$startIndex+5;
					$html .="<p id='googlebooks_load'><button class='btn btn-default' onclick='get_more(`googlebooks`,`".$nextIndex."`,`".$query."`,this)'>Load More</button></p>";
				}
			
              return $html;
      }
      public function showsaved($data)
      {
        global $post;
          $html='';
                      foreach($data as $key=>$value){

                      $html .='<div class="row" id=googlebooks_'.$key.'>'; 
                      if($value['thumbnail']!=''){
                      $html .= '<div class="col-sm-1"><img width="20px" height="20px" src="'.$value['thumbnail'].'" alt=""></div>';
                      }
                      else{
                      $html .= '<div class="col-sm-1"><img width="20px" height="20px" alt=""></div>';
                      }  


                      $html .='<div class="col-sm-11">';
                      $html .='<h4>'.$value['title'].'</h4>';
                      if($value['description']!=''){
                      $html .='<p>'.$value['description'].'</p>';
                      }
                      $html .='<button type="button" onclick="remove_meta(`googlebooks`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
                      $html .='</div>';
                      $html .='</div>';
                      }
                      return $html;
      }

      //return to ajax call method for showing the saved content with remove button
      public function getsinglerecord($key,$value,$post_id)
      {
         $html='';
                      

                      $html .='<div class="row" id=googlebooks_'.$key.'>'; 
                      if($value['thumbnail']!=''){
                      $html .= '<div class="col-sm-1"><img width="20px" height="20px" src="'.$value['thumbnail'].'" alt=""></div>';
                      }
                      else{
                      $html .= '<div class="col-sm-1"><img width="20px" height="20px" alt=""></div>';
                      }  


                      $html .='<div class="col-sm-11">';
                      $html .='<h4>'.$value['title'].'</h4>';
                      if($value['description']!=''){
                      $html .='<p>'.$value['description'].'</p>';
                      }
                      $html .='<button type="button" onclick="remove_meta(`googlebooks`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
                      $html .='</div>';
                      $html .='</div>';
                      
                      return $html;
      }
      public function get_template_frontend($module_setting,$content_meta)
        {
          $html='';
              foreach($content_meta as $key=>$value){
                   if(array_key_exists('status', $value)){
                    $html .='<div class="row " id=googlebooks_'.$key.'>'; 
                    if($value['thumbnail']!=''){
                      $html .= '<div class="col-sm-1"><img width="20px" height="20px" src="'.$value['thumbnail'].'" alt=""></div>';
                    }
                    else{
                      $html .= '<div class="col-sm-1"><img width="20px" height="20px" alt=""></div>';
                    }  

                    
                    $html .='<div class="col-sm-11">';
                    $html .='<h4>'.$value['title'].'</h4>';
                    if($value['description']!=''){
                      $html .='<p>'.$value['description'].'</p>';
                    }
                    
                    $html .='</div>';
                    $html .='</div>';
                }
              }
              return  $html;
        }

}

/* q parameter is a search string */  
?>
