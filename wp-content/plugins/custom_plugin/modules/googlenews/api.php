<?php
  class googlenews {
      public function getdata($query,$pageno=1) {
            $endpoint="https://newsapi.org/v2/everything?";
      $param=[
            'q'=>$query,
            //~ 'from'=>'2018-12-21',
            'sortBy'=>'popularity',
            'apiKey'=>'8bbc4b5306e749af86623b52e4170463',
            'pageSize'=>5,
            'page'=>$pageno
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

      public function parseResult($obj)
      {
		  //~ print_r($obj);die;
        $data=array();
         $totalResults=$obj->totalResults;
          foreach ($obj->articles as $key => $value) {
              $key=md5(microtime().rand());
              $data[$key]['title']=$value->title;
          }
          return array($data,$totalResults);
      }

      public function preparehtml($temp,$totalResults,$query='',$pageno=1)
      {
                  //  $temp='';
                  // foreach ($obj->articles as $key => $value) {
                  //             $temp[]=$value->title;
                  // }
                  $google_news="<div class='container'>";
                  if(is_array($temp) && !empty($temp)){
                  foreach ($temp as $key => $value) {
                        $google_news .="<div class='copy_div news_box' id=googlenews_".$key."><b>".$value['title']."</b></div>";
                       
                   }
                 }
                   $google_news .="</div>";
                   if($pageno*5<$totalResults)
					{
					$google_news .="<p id='googlenews_load'><button class='btn btn-default' onclick='get_more(`googlenews`,`".++$pageno."`,`".$query."`,this)'>Load More</button></p>";
					}
                   return $google_news;
      }
      public function showsaved($data)
      {
        global $post;
        $googlenews='';
          foreach ($data as $key => $value) {
            $googlenews .="<div class='row'>";
            $googlenews .="<div class='col-sm-12'>";
          $googlenews .="<li class='' id=googlenews_".$key.">".$value['title']."</li>";
          $googlenews .='<button type="button" onclick="remove_meta(`googlenews`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
          $googlenews.="</div>";
          $googlenews.="</div>";

        }
        // $googlenews.="</div>";
        return $googlenews;
      }
    //return to ajax call method for showing the saved content with remove button
      public function getsinglerecord($key,$value,$post_id)
      {
        $googlenews='';
            $googlenews .="<div class='row'>";
            $googlenews .="<div class='col-sm-12'>";
          $googlenews .="<li class='' id=googlenews_".$key.">".$value['title']."</li>";
          $googlenews .='<button type="button" onclick="remove_meta(`googlenews`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
          $googlenews.="</div>";
          $googlenews.="</div>";
        // $googlenews.="</div>";
        return $googlenews;
      }

      public function get_template_frontend($module_setting,$content_meta)
      {
            $google_news="<ul>";
            foreach ($content_meta as $key => $value) {
              if(array_key_exists('status', $value)){
                $google_news .="<li class='' >".$value['title']."</li>";
              }
            }
            $google_news .="</ul>";
            return  $google_news;
      }
}

/* q parameter is a search string */  

 
// $object1->url = "https://newsapi.org/v2/everything?q=Apple&from=2018-12-21&sortBy=popularity&apiKey=8bbc4b5306e749af86623b52e4170463";

?>   
