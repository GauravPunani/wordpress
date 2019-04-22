<?php

class walmart{
	
		public function getdata($query,$start=1)
		{
				$endpoint="http://api.walmartlabs.com/v1/search?";
			$param=[
				'query'=>$query,
				'apiKey'=>'495tuk3jp9wnkvpd6yta6eu4',
				'lsPublisherId'=>'zashahmed',
				'numItems'=>5,
				'start'=>$start
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

			$results = json_decode($json);
				
			return $results;
		}
		public function parseResult($results)
		{
					$totalResults=$results->totalResults;
					if(!empty($results->items)){
						foreach($results->items as $k=>$val){
								$key=md5(microtime().rand());
								
								$data[$key]['thumbnailImage']=$val->thumbnailImage;
								$data[$key]['largeImage']=$val->largeImage;
								$data[$key]['title']=$val->name;
								$data[$key]['shortDescription']=$val->shortDescription;
								$data[$key]['salePrice']=$val->salePrice;
								$data[$key]['stock']=$val->stock; //Available
								$data[$key]['affiliateAddToCartUrl']=$val->affiliateAddToCartUrl;
								
								if(isset($val->longDescription))	
									$data[$key]['longDescription']=$val->longDescription;
									
								if(isset($val->msrp))
									$data[$key]['msrp']=$val->msrp;
									
								
								
								if(isset($val->customerRating))
									$data[$key]['customerRating']=$val->customerRating; 
									
								if(isset($val->numReviews))
									$data[$key]['numReviews']=$val->numReviews; 
									
								
						}
					}
					return array($data,$totalResults);
			
		}
		public function preparehtml($data=array(),$totalcount,$query='',$start=1)
		{
			$html="<div class='container'>";
			
			foreach ($data as $key => $value) {
					$html .="<div class='row copy_div' id='walmart_".$key."'>";
						$html.="<div class='col-sm-1 img_box'>";
						$html .="<img class='img-fluid' src=".$value['thumbnailImage']." alt='#'>";
						$html.="</div>";
						$html .="<div class='col-sm-11 txt_box'>";
						$html .="<p><b>".$value['title']."</b></p>";
						$html .="<p>".$value['shortDescription']."</p>";
						if(isset($value['msrp']))
							$html .="<p><b>USD</b><strike>".$value['msrp']."</strike> <b>".$value['salePrice']."</b> <img src='https://www.google.com/s2/favicons?domain=walmart.com' /> <span class='text-muted'>walmart.com</span></p>";
						else
							$html .="<p><b>USD ".$value['salePrice']."</b> <img src='https://www.google.com/s2/favicons?domain=walmart.com' /> <span class='text-muted'>walmart.com</span></p>";
						$html .="</div>";
					$html .="</div>";

			}
				if($start+5<$totalcount)
						$html .="<p id='walmart_load'><button class='btn btn-default' onclick='get_more(`walmart`,`".($start+5)."`,`".$query."`,this)'>Load More</button></p>";
						
			$html.="</div>";
			return $html;
		}
		public function showsaved($data)
		{
			$html="<div class='container'>";
			
				foreach ($data as $key => $value) {
					$html .="<div class='row' id='walmart_".$key."'>";
						$html.="<div class='col-sm-1 img_box'>";
						$html .="<img class='img-fluid' src=".$value['thumbnailImage']." alt='#'>";
						$html.="</div>";
						$html .="<div class='col-sm-11 txt_box'>";
						$html .="<p><b>".$value['title']."</b></p>";
						$html .="<p><b>USD</b><strike>".$value['msrp']."</strike> <b>".$value['salePrice']."</b> <img src='https://www.google.com/s2/favicons?domain=walmart.com' /> <span class='text-muted'>walmart.com</span></p>";
						$html .="</div>";
					$html .="</div>";

			}
			
			$html.="</div>";

			return  $html;
		}
		public function getsinglerecord($key,$data,$post_id)
		{
			//~ print_r($data);die;
			global $post;
			$html ='<div class="container">';
				$html .="<div class='row' id='walmart_".$key."'>";
						$html.="<div class='col-sm-1 img_box'>";
						$html .="<img class='img-fluid' src=".$data['thumbnailImage']." alt='#'>";
						$html.="</div>";
						$html .="<div class='col-sm-11 txt_box'>";
						$html .="<p><b>".$data['title']."</b></p>";
						$html .="<p>".$data['shortDescription']."</p>";
						if(isset($data['msrp']))
							$html .="<p><b>USD</b><strike>".$data['msrp']."</strike> <b>".$data['salePrice']."</b> <img src='https://www.google.com/s2/favicons?domain=walmart.com' /> <span class='text-muted'>walmart.com</span></p>";
						else
							$html .="<p><b>USD ".$data['salePrice']."</b> <img src='https://www.google.com/s2/favicons?domain=walmart.com' /> <span class='text-muted'>walmart.com</span></p>";
						$html .='<button type="button" onclick="remove_meta(`walmart`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
						$html .="</div>";
					$html .="</div>";
				;
			$html .='</div>';
			return  $html;
		}
		public function get_template_frontend($module_setting,$content_meta){
				
				$html= '<div class="container">';
				$html .='<div class="row">';
				foreach ($content_meta as $key => $value) {
						if(array_key_exists('status', $value)){
							$html .='<div class="col-md-4">';
								$html .='<div class="card" style="width:200px">';
									$html .='<img class="card-img-top" src="'.$value['largeImage'].'" alt="Card image">';
										$html .='<div class="card-body">';
										$html .='<img src="http://hourlylancer.com/beta/clientsdemo/steempress/wp-content/uploads/ce-logos/icon_walmart-com.png" /> <span class="text-muted">Walmart.com</span>';
										$html .='<p class="card-title">'.$value['title'].'</p>';
										
										if(isset($value['numReviews']))
											$html .='<p class="card-text">'.$value['numReviews'].'Reviews</p>';
										if(isset($value['msrp']))
											$html .='<p class="card-text"><strike>$'.$value['msrp'].'</strike> $'.$value['salePrice'];
										else
												$html .='<p class="card-text">$'.$value['salePrice'];
										if($value['stock']!='Available')
												$html .='<span class="text-danger">Out of Stock</span></p>';
										else
												$html .='</p>';
										$html .='<a target="_blank" href="'.$value['affiliateAddToCartUrl'].'" class="btn btn-primary">Buy Now</a>';
										$html .='</div>';
								$html .='</div>';
							$html .='</div>';
						}
			}
				$html .='</div>';
				$html .='</div>';
				return $html;
		}
}	

