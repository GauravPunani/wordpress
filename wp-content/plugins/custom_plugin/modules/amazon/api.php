<?php

class amazon{
	private $attribute_count;
	public function getdata($query,$pageoffset='1')
	{
		$AWS_ACCESS_KEY_ID = "AKIAJGVMCO7YHNHESBNA";
		$AWS_SECRET_ACCESS_KEY = "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";

		$base_url = "http://ecs.amazonaws.com/onca/xml?";
		$url_params = array('Operation'=>"ItemSearch",'Service'=>"AWSECommerceService",
		'AWSAccessKeyId'=>$AWS_ACCESS_KEY_ID,'AssociateTag'=>"shahnawa-20",
		'Version'=>"2006-09-11",'Availability'=>"Available",'Condition'=>"All",
		'ItemPage'=>$pageoffset,'ResponseGroup'=>"Images,ItemAttributes,EditorialReview,Offers",
		'Keywords'=>urlencode($query),'SearchIndex'=>'All');

		// Add the Timestamp
		$url_params['Timestamp'] = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());

		// Sort the URL parameters
		$url_parts = array();
		foreach(array_keys($url_params) as $key)
		$url_parts[] = $key."=".$url_params[$key];
		sort($url_parts);

		// Construct the string to sign
		$string_to_sign = "GET\necs.amazonaws.com\n/onca/xml\n".implode("&",$url_parts);
		$string_to_sign = str_replace('+','%20',$string_to_sign);
		$string_to_sign = str_replace(':','%3A',$string_to_sign);
		$string_to_sign = str_replace(';',urlencode(';'),$string_to_sign);
		$string_to_sign = str_replace(',', '%2C', $string_to_sign);

		// Sign the request
		$signature = hash_hmac("sha256",$string_to_sign,$AWS_SECRET_ACCESS_KEY,TRUE);

		// Base64 encode the signature and make it URL safe
		$signature = base64_encode($signature);
		$signature = str_replace('+','%2B',$signature);
		$signature = str_replace('=','%3D',$signature);


		$url_string = implode("&",$url_parts);
		$url = $base_url.$url_string."&Signature=".$signature;
		//~ print $url;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$xml_response = curl_exec($ch);
		$parsed_xml = simplexml_load_string($xml_response);
		return $parsed_xml;

	}
	public function parseResult($parsed_xml)
	{
		$data=array();
		$totalpages=$parsed_xml->Items->TotalPages;
		//~ echo $totalpages;die;
		foreach($parsed_xml->Items->Item as $k=>$val){
				$key=md5(microtime().rand());

					foreach($val->ItemAttributes as $index=>$test){
						foreach ((array)$test->Feature as $ghd => $abc) {
							$data[$key]['feature'][]=$abc;
						}
					}

				
				$data[$key]['count_attr']=count((array) $val->ItemAttributes);
				$data[$key]['title']=(string)$val->ItemAttributes->Title;
				$data[$key]['ean']=(string) $val->ItemAttributes->EAN;
				$data[$key]['currency_code']=(string)$val->ItemAttributes->ListPrice->CurrencyCode;
				$data[$key]['price']=(string)$val->ItemAttributes->ListPrice->FormattedPrice;
				$data[$key]['img_url']=(string)$val->LargeImage->URL;
				$data[$key]['link']=(string)$val->DetailPageURL;
				if(isset($val->OfferSummary->LowestNewPrice->FormattedPrice))
					$data[$key]['lowest_new_price']=(string) $val->OfferSummary->LowestNewPrice->FormattedPrice;
				if(isset($val->OfferSummary->LowestUsedPrice->FormattedPrice))
					$data[$key]['lowest_used_price']=(string) $val->OfferSummary->LowestUsedPrice->FormattedPrice;
				if(isset($val->OfferSummary->TotalNew))
					$data[$key]['TotalNew']=(string)$val->OfferSummary->TotalNew;
				if(isset($val->OfferSummary->TotalUsed))
					$data[$key]['TotalUsed']=(string)$val->OfferSummary->TotalUsed;
				// $data[$key]['features']='test';
		}
		//~ print_r($data);
		return array($data,$totalpages);
	}

	public function preparehtml($data=array(),$totalcount,$query='',$currentpage=1)
	{
		$html='<div class="container">';
		
		foreach ($data as $key => $value) {
				$html .="<div class='row copy_div' id='amazon_".$key."'>";
					$html.="<div class='col-sm-1 img_box'>";
					$html .="<img class='img-fluid' src=".$value['img_url']." alt='#'>";
					$html.="</div>";
					$html .="<div class='col-sm-11 txt_box'>";
					$html .="<p><b>".$value['title']."<br>";
					$html .=$value['currency_code']." ".$value['price']."</b> <img src='https://www.google.com/s2/favicons?domain=amazon.com' /> <span style='color:grey'>amazon.com</b> Attributes:".$value['count_attr']."</p>";
					$html .="</div>";
				$html .="</div>";

		}
			if($currentpage<$totalcount)
					$html .="<p id='amazon_load'><button class='btn btn-default' onclick='get_more(`amazon`,`".++$currentpage."`,`".$query."`,this)'>Load More</button></p>";
					
		$html.="</div>";
		return $html;
	}

	public function showsaved($data)
	{
		global $post;
		$temp ='<div class="container">';
		foreach($data as $key=>$value)
		{
		$temp .='<div class="row" id="amazon_'.$key.'">';
		$temp .='<div class="col-sm-2"><img class="img-fluid" src="'.$value["img_url"].'" alt="" ></div>';
		$temp .='<div class="col-sm-10">';
		$temp .='<h4>'.$value['title'].'</h4>';
		$temp .='<p><b>'.$value['currency_code'].'</b> '. $value['price'].' ';
		$temp .='<a   onclick="remove_meta(`amazon`,`'.$key.'`,this,'.$post->ID.')" class="text-danger cursor_pointer">Remove</a>';
		$temp ."</p>";
		$temp .='</div>';
		$temp .='</div>';
		}
		$temp .='</div>';
		return  $temp;
	}
	public function getsinglerecord($item_key,$value,$post_id)
	{
		$temp='';
		$temp .='<div class="container" id="amazon_'.$item_key.'">';
		$temp .='<div class="row">';
		$temp .='<div class="col-sm-2"><img class="img-fluid" src="'.$value["img_url"].'" alt="" ></div>';
		$temp .='<div class="col-sm-10">';
		$temp .='<h4>'.$value['title'].'</h4>';
		$temp .='<p><b>'.$value['currency_code'].'</b> '. $value['price'].'</p>';
		$temp .='<a   onclick="remove_meta(`amazon`,`'.$item_key.'`,this,'.$post_id.')" class="text-danger cursor_pointer">Remove</a>';
		$temp .='</div>';
		$temp .='</div>';
		$temp .='</div>';

		return  $temp;
	}
	
	public function get_template_frontend($module_settings,$content_meta_data){
		// echo "<pre>";print_r($content_meta_data);die;
			$html ='<div class="container">';
				foreach ($content_meta_data as $key => $value) {
					//get the settings field data for the module
					
						if(array_key_exists('status', $value)){

							$html .="<div class='row copy_div' id='amazon_".$key."'>";
							$html.="<div class='col-sm-6'>";
							$html .="<a rel='nofollow' target='_blank' href=".$value['link']."><img class='img-fluid' src=".$value['img_url']." alt='#'></a>";
							$html.="</div>";
							$html .="<div class='col-sm-6'>";
							$html .="<h4>".$value['title']."</h4>";
							$html .="<strike>".$value['price']."</strike>";
							
							if(array_key_exists('lowest_new_price',$value)){
								$html .="<h4>".$value['currency_code']." ".$value['lowest_new_price']."</h4>";
								$html .="<p>".$value['TotalNew']." new from ".$value['lowest_new_price']."</p>";	
							}
							if(array_key_exists('lowest_used_price', $value))
									$html .="<p>".$value['TotalUsed']." used from ".$value['lowest_used_price']."</p>";
							
							$html .="<a rel='nofollow' target='_blank' href=".$value['link']."><button class='btn btn-success'>Buy Now</button></a>";
							if(array_key_exists('feature',$value)){
								if(is_array($value['feature']) && !empty($value['feature'])){
								$html .="</div><div class='col-sm-12'>";
								$html .="<p><b>Feaures</b></p>";	
								foreach ($value['feature'] as $key => $value) {
									$html.="<p>".$value."</p>";
								}
								// $html .="</div>";
								}
						}
									

							$html .="</div>";
							$html .="</div>";

						}
				}

				$html .="</div>";
				return   $html;
		
		}
}


