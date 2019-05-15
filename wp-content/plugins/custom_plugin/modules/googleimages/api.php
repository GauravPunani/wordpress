<?php

class googleimages{

	public function getdata($query,$startIndex='1')
	{
		$param=[
				'key'=>'AIzaSyDgtYclZ-9q4JgZuuBINSpyiunbhxgprrs',
				'cx'=>'000347656224470431937:c4xfhtwlvsu',
				'searchType'=>'image',
				'q'=>$query,
				'start'=>$startIndex

		];
		$query=http_build_query($param);
		$results=file_get_contents('https://www.googleapis.com/customsearch/v1?'.$query);
		return json_decode($results);
	}

	public function parseResult($results)
	{
		$data=array();
		$totalResults=$results->searchInformation->totalResults;
		if(!empty($results->items)){
			foreach ($results->items as $key => $value) {
						$key=md5(microtime().rand());
						$data[$key]['link']=$value->link;
						$data[$key]['title']=$value->title;
			}
		}
		return array($data,$totalResults);
	}
	public function preparehtml($data,$totalResults,$query='',$startIndex=0)
	{
		$results ="<div class='container'>";
		$results .="<div class='row'>";
		if(!empty($data)){
			foreach ($data as $key => $value) {

				
				$results .="<div class='col-sm-6 copy_div img_full' id='googleimages_".$key."'>";
				$results .="<img class='img-fluid' src=".$value['link']." alt='#'>";
				$results .="<div class='img_hover'><p>".$value['title']."</p></div>";
				$results .="</div>";
				
			}
		}
		else{
				
				$results .="<p>No Item Found!!</p>";
				
			}
		$results .="</div>";
		if($startIndex+10<$totalResults)
              {
						$nextIndex=$startIndex+10;
					$results .="<p id='googleimages_load'><button class='btn btn-default' onclick='get_more(`googleimages`,`".$nextIndex."`,`".$query."`,this)'>Load More</button></p>";
			  }
		$results .="</div>";
		return $results;
	}
	public function showsaved($data)
	{
		global $post;
		$results ='<div class="container">';
		foreach ($data as $key => $value) {

			$results .="<div class='row' id='googleimages_".$key."'>";
			$results .="<div class='col-sm-6'>";
			$results .="<img class='img-fluid' src=".$value['link']." alt='#'>";
			$results .="</div>";
			$results .="<div class='col-sm-6'>";
			$results .='<button type="button" onclick="remove_meta(`googleimages`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
			$results .="</div>";
			$results .="</div>";
		}
		$results .="</div>";

		return $results;
	}
	//return to ajax call method for showing the saved content with remove button
	public function getsinglerecord($key,$data,$post_id)
	{
		$results ='<div class="container">';
			$results .="<div class='row' id='googleimages_".$key."'>";
			$results .="<div class='col-sm-6'>";
			$results .="<img class='img-fluid' src=".$data['link']." alt='#'>";
			$results .="</div>";
			$results .="<div class='col-sm-6'>";
			$results .='<button type="button" onclick="remove_meta(`googleimages`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
			$results .="</div>";
			$results .="</div>";
		$results .="</div>";

		return $results;
	}
	public function get_template_frontend($module_setting,$content_meta)
	{
		$results ='<div class="container">';
				foreach ($content_meta as $key => $value) {
						if(array_key_exists('status', $value)){
							$results .="<div class='row ' id='googleimages_".$key."'>";
							$results .="<div class='col-sm-12'>";
							$results .="<img class='img-fluid' src=".$value['link']." alt='#'>";
							$results .="</div>";
							$results .="</div>";
					}
				}
			$results .="</div>";
			return   $results;
	}
}
