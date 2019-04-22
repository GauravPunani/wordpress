<?php

class envato {
	
	function getdata($searchQuery,$page=1)
	{
		$query=urlencode($searchQuery);
		$param=[
				'term'=>$query,
				'page_size'=>5,
				'page'=>$page
				
		];
		$endpoint="https://api.envato.com/v1/discovery/search/search/item?";
		$url=$endpoint.http_build_query($param);
		//~ $url ="https://api.envato.com/v1/discovery/search/search/item?term=".$query."&page_size=10";



// create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		   
		    'Authorization: Bearer 1wwreJYXO0f74qSV5KAVwCTWfpSFX0bN'
		));


        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);  
		$results=json_decode($output);

		return $results;
		

	}
	public function parseResult($results){
		$result=array();
		$totalItems=$results->total_hits;
			foreach($results->matches as $item)
				{
					$key=md5(microtime().rand());
					if(isset($item->previews->thumbnail_preview->large_url))
							$result[$key]['img_url']=$item->previews->thumbnail_preview->large_url;	
					else if(isset($item->previews->icon_with_audio_preview->icon_url))
						$result[$key]['img_url']=$item->previews->icon_with_audio_preview->icon_url;
					else if(isset($item->previews->icon_with_square_preview->icon_url))
						$result[$key]['img_url']=$item->previews->icon_with_square_preview->icon_url;
					else if(isset($item->previews->icon_with_video_preview->landscape_url))
						$result[$key]['img_url']=$item->previews->icon_with_video_preview->landscape_url;

					$result[$key]['name']=	$item->name;
					$result[$key]['description']=$item->description;
					$result[$key]['price']=($item->price_cents/100);
					$result[$key]['site_thumb']=$item->site;
					$result[$key]['url']=$item->url;
					
				}
				return array($result,$totalItems);

	}
	public function  preparehtml($items,$totalItems,$query='',$currentPage=1)
	{
		$html="<div class='container'>";
		
		foreach($items as $key=>$item)
		{
			
			$imagearray='';
			if($item['img_url']!='')
			{
				$imagearray=$item['img_url'];
			}
			$html.="<div class='row copy_div' id=envato_".$key.">" ;
			$html.="<div class='col-md-1 img_box'>";
			$html.="<img class='img-fluid' width='100%'  src='".$imagearray."'  >";
			$html.="</div>";

			$html.="<div class='col-md-11 txt_box'>";
			$html.="<p><b>".$item['name']."</b><br>";
			$html.=strlen($item['description']) > 200 ? substr($item['description'],0,200)."..." : $item['description']."</p>";
	
			$html.="<p><b>USD ".$item['price']." </b>";
			if($item['site_thumb']=='graphicriver.net')
				$html.='<img src="https://www.google.com/s2/favicons?domain=graphicriver.net" /> graphicriver.net</p>';
			else
				$html.='<img src="https://www.google.com/s2/favicons?domain=videohive.net" />  videohive.net</p>';
			$html.="</div>";
			$html.="</div>";
			
		}
		 if($currentPage*5<$totalItems)
              {
					$html .="<p id='envato_load'><button class='btn btn-default' onclick='get_more(`envato`,`".++$currentPage."`,`".$query."`,this)'>Load More</button></p>";
				}
		
		$html.="</div>";

		return $html;
	}
	
	public function showsaved($data)
	{
		$html="<div class='container'>";
		
		foreach($data as $key=>$item)
		{
			global $post;
			$imagearray='';
			if($item['img_url']!='')
			{
				$imagearray=$item['img_url'];
			}
			$html .="<div class='row' id=envato_".$key.">" ;
			
			$html.="<div class='col-md-2'>";
			$html.="<img class='img-fluid' width='100%'  src='".$imagearray."'  >";
			$html.="</div>";

			$html.="<div class='col-md-10'>";
			$html.="<h3>".$item['name']."</h3>";
			$html.="<p>".$item['description']."</p>";
			$html.="<p>USD ".$item['price']."</p>";
			$html .='<button type="button" onclick="remove_meta(`envato`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
			$html.="</div>";

			$html.="</div>";
			
		}
		
		$html.="</div>";

		echo  $html;
	}
	public function getsinglerecord($key,$data,$post_id)
	{
		$html="<div class='container'>";
			$imagearray='';
			if($data['img_url']!='')
			{
				$imagearray=$data['img_url'];
			}
			$html .="<div class='row' id=envato_".$key.">" ;
			
			$html.="<div class='col-md-2'>";
			$html.="<img class='img-fluid' width='100%'  src='".$imagearray."'  >";
			$html.="</div>";

			$html.="<div class='col-md-10'>";
			$html.="<h3>".$data['name']."</h3>";
			$html.="<p>".$data['description']."</p>";
			$html.="<p>USD ".$data['price']."</p>";
			$html .='<button type="button" onclick="remove_meta(`envato`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
			$html.="</div>";

			$html.="</div>";
			
		
		
		$html.="</div>";

		echo  $html;
	}
	public function get_template_frontend($module_setting,$content_meta)
	{
		$html="<div class='container'>";
		$i=0;
		$html.="<div class='row'>" ;
		foreach($content_meta as $key=>$item)
		{
			if(array_key_exists('status', $item)){
			$imagearray='';
			if($item['img_url']!='')
			{
				$imagearray=$item['img_url'];
			}
				$html.="<div class='col-sm-4'>";
					$html .='<div class="card">';
							$html .='<div class="card-header">';
							$html.="<img width='100%'  src='".$imagearray."'  >";
							$html.="</div>";

							$html .='<div class="card-body">';
							$html .='<p style="color:grey;">'.$item['name'].'</p>';
							$html .='<p><b>$'.(float)$item['price'].'</b></p>';
							$html .='<p><button class="btn btn-default"><a target="_blank" href='.$item['url'].'>Buy Now</a></button></p>';
							$html .='</div>';
					$html .="</div>";
				$html .="</div>";
			

			// $html.="</div>";

			// $html.="<div class='col-sm-12'>";
			// $html.="<h3>".$item['name']."</h3>";
			// $html.="<p>".$item['description']."</p>";
	
			// $html.="<p>USD ".$item['price']."</p>";
			// $html.="</div>";
			// $html.="</div>";
			}
			
		}
		$html .="</div>";
		$html.="</div>";

		return   $html;
	}
}
