<?php

class Pixabay {
	
	function getdata($searchQuery,$pageNumber=1)
	{
		$query=urlencode($searchQuery);
		$param=[
				'key'=>'11035004-d1fe0aacbc3d8755d6afb2463',
				'q'=>$query,
				'image_type'=>'photo',
				'per_page'=>5,
				'page'=>$pageNumber
		];
		$endpoint="https://pixabay.com/api/?";
		$url=$endpoint.http_build_query($param);
		//~ $url ="https://pixabay.com/api/?key=11035004-d1fe0aacbc3d8755d6afb2463&q=".$query."&image_type=photo&per_page=5";

		//echo $url;die;

// create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);  
		$results=json_decode($output);
		return $results;
	}
	public function parseResult($results)
	{
		$data=array();
		//~ print_r($results);die;
		$totalResults=$results->total;
		foreach($results->hits as $item){
			$key=md5(microtime().rand());
			$data[$key]['img_url']=$item->webformatURL;
		}
		return array($data,$totalResults);
	}
	public function preparehtml($results,$totalResults,$query='',$pageno=1)
	{
		$html="<div class='container'>";
			
		if(!empty($results)){	
			$html.="<ul>";
			foreach($results as $key=>$item){
			
				$html.="<li class='copy_div img_full' id=pixabay_".$key.">";
				$html.="<div class='box_images img_full'>";
				$html.="<img width='100%'  src='".$item['img_url']."' frameborder='0' allowfullscreen='' >";
				$html .="<div class='img_hover'><p>test</p></div>";
				$html.="</div>";
				$html.="</li>";
			}
			$html.="</ul>";
		}
		else{
				$html .="<p>No Item Found!!</p>";
			}
		
				if($pageno*5<$totalResults)
					{
					$html .="<p id='pixabay_load'><button class='btn btn-default' onclick='get_more(`pixabay`,`".++$pageno."`,`".$query."`,this)'>Load More</button></p>";
					}
		
		$html .="</div>";
		return $html;
	}
	public function showsaved($data)
	{
		global $post;
		$html ='<div class="container">';
		foreach($data as $key=>$v){
				$html .='<div class="row" id="pixabay_'. $key.'">';
					$html .='<div class="col-sm-6">';
					$html .='<img class="img-fluid"  src="'.$v['img_url'].'" alt="img">';
					$html .='</div>';
					$html .='<div class="col-sm-6">';
					$html .='<button type="button" onclick="remove_meta(`pixabay`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
					$html .='</div>';
				$html .="</div>";
				
		}
		$html .='</div>';
		return $html;
	}
	//return to ajax call method for showing the saved content with remove button
      public function getsinglerecord($key,$v,$post_id)
      {
      	$html ='<div class="container">';
				$html .='<div class="row" id="pixabay_'. $key.'">';
					$html .='<div class="col-sm-6">';
					$html .='<img class="img-fluid"  src="'.$v['img_url'].'" alt="img">';
					$html .='</div>';
					$html .='<div class="col-sm-6">';
					$html .='<button type="button" onclick="remove_meta(`pixabay`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
					$html .='</div>';
				$html .="</div>";
				
		
		$html .='</div>';
		return $html;
      }
      public function get_template_frontend($module_setting,$content_meta)
      {
		$html='<div class="container">';
		$html.="<div class='row'>";
		$html.="<div class='col-sm-12 pixabay_box'>";
				foreach($content_meta as $key=>$item){
					if(array_key_exists('status', $item)){
						
						$html.="<img width='100%'  src='".$item['img_url']."' frameborder='0' allowfullscreen='' >";
						
					}
				}
		$html.="</div>";
		$html.="</div>";
		$html .="</div>";
					return   $html;
      }
}

// $youtube=new Pixabay;
// $results=$youtube->getResults('whiskey');
// echo $results;


?>
