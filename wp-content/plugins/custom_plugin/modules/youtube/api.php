<?php

class Youtube {
	
	function getdata($searchQuery,$nextpagetoken='')
	{
		$param=[
			'q'=>urlencode($searchQuery),
			'maxResults'=>5,
			'part'=>'snippet',
			'key'=>'AIzaSyBSRjMixAMRkcCAS3ge7KX1bYSnWj7T4K0'
		];
		if(!empty($nextpagetoken))
				$param['pageToken']=$nextpagetoken;
				
		$endpoint="https://www.googleapis.com/youtube/v3/search?";
		$url=$endpoint.http_build_query($param);
		//~ $url ="https://www.googleapis.com/youtube/v3/search?q=".urlencode($searchQuery)."&maxResults=5&part=snippet&key=AIzaSyBSRjMixAMRkcCAS3ge7KX1bYSnWj7T4K0";



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
		return $results;;
	}
	public function parseResult($results)
	{
		$data=array();
		//~ print_r($results);die;
		$nextpagetoken=$results->nextPageToken;
		foreach ($results->items as $key => $value)
		{
			$key=md5(microtime().rand());
			if(isset($value->id->videoId))
				$data[$key]['videoId']=$value->id->videoId;
			else
				$data[$key]['videoId']='';
			$data[$key]['title']=$value->snippet->title;
			$data[$key]['description']=$value->snippet->description;
		}
		return array($data,$nextpagetoken);
		# code...
	}
	public function preparehtml($items,$nextpagetoken,$query='',$pageno=1)
	{
		$html='';
		if(is_array($items) && !empty($items))
		{
				foreach($items as $key=>$item)
				{
					//~ echo '<pre>';print_r($item);die;
					if(array_key_exists('videoId',$item)){
							if($item['videoId']!=''){
							
							$videoId=$item['videoId'];
							
							$html .="<div class='row copy_div' id=youtube_".$key.">";
							$html.="<div class='col-md-6'>";
							$html.="<iframe  width='100%' height='180' src='https://www.youtube.com/embed/".$videoId."' frameborder='0' allowfullscreen='' ></iframe>";
							$html.="</div>";
							$html.="<div class='col-md-6'>";
							$html.="<p><b>".$item['title']."</b><br>";
							$html.=$item['description']."</p>";
							$html.="</div>";
							$html.="</div>";

							}
					}
				}
				$html .="<p id='youtube_load'><button class='btn btn-default' onclick='get_more(`youtube`,`".$nextpagetoken."`,`".$query."`,this)'>Load More</button></p>";
		}
		else{
					$html.="<p>No Item Found !!</p>";
			}
		

		return $html;
	}
	public function showsaved($data)
	{
		global $post;
		$html='';
		foreach($data as $key=>$item)
		{
		//echo '<pre>';print_r();die;

			if(isset($item['videoId'])){

			$videoId=$item['videoId'];

			$html.="<div class='row ' id=youtube_".$key.">";
			$html.="<div class='col-md-4'>";
			$html.="<iframe  width='100%' height='180' src='https://www.youtube.com/embed/".$videoId."' frameborder='0' allowfullscreen='' ></iframe>";
			$html.="</div>";
			$html.="<div class='col-md-8'>";
			$html.="<h3>".$item['title']."</h3>";
			$html.="<p>".$item['description']."</p>";
			$html .='<button type="button" onclick="remove_meta(`youtube`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
			$html.="</div>";
			$html.="</div>";

			}
		}


		return  $html;
	}
	//return to ajax call method for showing the saved content with remove button
      public function getsinglerecord($key,$item,$post_id)
      {
      		$html='';
			if(isset($item['videoId'])){

			$videoId=$item['videoId'];

			$html.="<div class='row ' id=youtube_".$key.">";
			$html.="<div class='col-md-4'>";
			$html.="<iframe  width='100%' height='180' src='https://www.youtube.com/embed/".$videoId."' frameborder='0' allowfullscreen='' ></iframe>";
			$html.="</div>";
			$html.="<div class='col-md-8'>";
			$html.="<h3>".$item['title']."</h3>";
			$html.="<p>".$item['description']."</p>";
			$html .='<button type="button" onclick="remove_meta(`youtube`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
			$html.="</div>";
			$html.="</div>";

			}
		


		return  $html;

      }
      public function item_lookup($id)
    {
        $this->operation = "ItemLookup";
        $this->itemID = $id;

        $url = $this->build_url();

        $ch = curl_init();  

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $output = curl_exec($ch);

        curl_close($ch);

        $this->xml = simplexml_load_string($output);
        return $this;
    }
     public function get_template_frontend($module_setting,$content_meta)
      {
      	$html="<div class='container'>";
			foreach ($content_meta as $key => $item) {
				if(array_key_exists('status', $item)){
						if(isset($item['videoId'])){

							$videoId=$item['videoId'];

							$html .="<div class='row'>";
							$html.="<div class='col-sm-12'>";
							$html.="<iframe  width='100%' height='250' src='https://www.youtube.com/embed/".$videoId."' frameborder='0' allowfullscreen='' ></iframe>";
							$html.="</div>";
							$html.="<div class='col-sm-12'>";
							$html.="<h3>".$item['title']."</h3>";
							$html.="<p>".$item['description']."</p>";
							$html.="</div>";
							$html.="</div>";
						}

					}
					
			}
			$html .="</div>";
			return  $html;
      }

}
// $amazon = new AmazonAPI("associate-id", "access-key", "secret-key");
// $item = $amazon->item_lookup("ASIN")->get_item_data();
?>
