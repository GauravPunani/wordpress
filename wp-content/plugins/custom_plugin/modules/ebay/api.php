<?php
class ebay{
	function __construct()
	{
		
	}
	public function getdata($q="",$pagenumber=1)
	{
		$param=[
			'SortOrderType'=>'BestMatch',
			'OPERATION-NAME'=>'findItemsByKeywords',
			'SERVICE-VERSION'=>'1.0.0',
			'SECURITY-APPNAME'=>'contente-contente-PRD-560b9b3c7-fcd7ae00',
			'GLOBAL-ID'=>'EBAY-US',
			'keywords'=>$q,
			'paginationInput.entriesPerPage'=>'5',
			'paginationInput.pageNumber'=>$pagenumber
		];
		$param=http_build_query($param);
		$data=file_get_contents('http://svcs.ebay.com/services/search/FindingService/v1?'.$param);
		return $data;
	}
	public function parseResult($data)
	{
		$result = new SimpleXMLElement($data);
		$temp=array();
		$pageoffset=$result->paginationOutput->totalEntries;
		foreach ($result->searchResult->item as $key => $value) {
			$i=md5(microtime().rand());
			$temp[$i]['title']=(string)$value->title;
			$temp[$i]['currentPrice']=(string)$value->sellingStatus->currentPrice;
			$temp[$i]['galleryURL']=(string)$value->galleryURL;
		}
		return array($temp,$pageoffset);
	}
	public function preparehtml($data,$totalpages,$query='',$currentpage=1)
	{
		$temp='';
		if(is_array($data) && !empty($data)){
			foreach ($data as $key => $value) {
				
					$temp .='<div class="container copy_div '.$totalpages.'" id="ebay_'.$key.'">
							<div class="row">
							<div class="col-sm-1 img_box"><img src='.$value['galleryURL'].' alt="" > </div>
							<div class="col-sm-11 txt_box">
							<p><b>'.$value['title'].'
							<br>USD '. $value['currentPrice'].'</b> <img src="https://www.google.com/s2/favicons?domain=ebay.com" /> <span style="color:grey;">ebay.com</span</p>
							</div>
							</div>';
					$temp .='</div>';
				
			}
		}
		if($currentpage<$totalpages)
					$temp .="<p id='ebay_load'><button class='btn btn-default' onclick='get_more(`ebay`,`".++$currentpage."`,`".$query."`,this)'>Load More</button></p>";
			
		
		
		return $temp;
	}

	public function showsaved($data)
	{
		global $post;
		$temp='';
		foreach($data as $key=>$value)
		{

		$temp .='<div class="container" id="ebay_'.$key.'">';
		$temp .='<div class="row">';
		$temp .='<div class="col-sm-1"><img src="'.$value["galleryURL"].'" alt="" width="50px" height="50px"></div>';
		$temp .='<div class="col-sm-11">';
		$temp .='<p><b>'.$value['title'].'</b></p>';
		$temp .='<p><b>USD'. $value['currentPrice'].'</b></p>';
		$temp .='</div>';
		$temp .='<button type="button" onclick="remove_meta(`ebay`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
		$temp .='</div>';
		$temp .='</div>';
		}
		return  $temp;
	}
	public function getsinglerecord($key,$data,$post_id)
	{
		$temp='';
		$temp .='<div class="container" id="ebay_'.$key.'">';
		$temp .='<div class="row">';
		$temp .='<div class="col-sm-1"><img src="'.$data["galleryURL"].'" alt="" width="50px" height="50px"></div>';
		$temp .='<div class="col-sm-11">';
		$temp .='<h4>'.$data['title'].'</h4>';
		$temp .='<p><b>Price </b> USD'. $data['currentPrice'].'</p>';
		$temp .='</div>';
		$temp .='<button type="button" onclick="remove_meta(`ebay`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
		$temp .='</div>';
		$temp .='</div>';
		
		return  $temp;
	}
	
	public function get_template_frontend($module_setting,$content_meta){
				
				$html= '<div class="container">';
				foreach ($content_meta as $key => $value) {
						if(array_key_exists('status', $value)){
							
							$html .='<div class="row">';
								$html .='<div class="col-sm-3">';
								$html .='<img src="'.$value['galleryURL'].'" alt="">';
								$html .='</div>';
									$html .='<div class="col-sm-9">';
									$html .='<h3>'.$value['title'].'</h3>';
									$html .='<p><b>USD</b>'.$value['currentPrice'].'</p>';
									$html .='</div>';
							$html .='</div>';

						}
			}
				$html .='</div>';
				return $html;
		}
}


// title
// currentPrice
// galleryURL
