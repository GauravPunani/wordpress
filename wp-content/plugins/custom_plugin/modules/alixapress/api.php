<?php
class alixapress{
		private $client_id='XLNIJQKVZAIUJIVY';
		public function getdata($query,$scrollIdentifier=''){
					
				$ch = curl_init();
				$param=array(
				'text'=>$query,
				'limit'=>5,
				'sort'=>'BEST_MATCH',
				'scrollPagination'=>true
				
				);
				if(!empty($scrollIdentifier)){
				$param['scrollIdentifier']=$scrollIdentifier;
				}
				$data=array('X-Api-Client-Id:'.$this->client_id.'','Content-Type: application/json');
				//~ $data=json_encode($data);
				curl_setopt($ch, CURLOPT_URL,"https://api.aliseeks.com/v1/search");
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER,$data);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($param));

				// In real life you should use something like:
				// curl_setopt($ch, CURLOPT_POSTFIELDS, 
				//          http_build_query(array('postvar1' => 'value1')));

				// Receive server response ...
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$server_output = curl_exec($ch);

				curl_close ($ch);
				return json_decode($server_output);
				
			}
			
			
			public function parseResult($results)
			{
					$scrollIdentifier=$results->aggregation->scrollIdentifier;
					if(!empty($results->items)){
						foreach($results->items as $k=>$val){
								$key=md5(microtime().rand());
								
								$data[$key]['detailUrl']=$val->detailUrl;
								$data[$key]['imageUrl']=$val->imageUrl;
								$data[$key]['title']=$val->title;
								$data[$key]['currency']=$val->price->currency;
								$data[$key]['value']=$val->price->value;		
								$data[$key]['seller']=$val->seller->storeName;		
						}
					}
					return array($data,$scrollIdentifier);
			
			}
			public function preparehtml($data=array(),$scrollIdentifier='',$query='')
			{
				$html="<div class='container'>";
				if(!empty($data)){
					foreach ($data as $key => $value) {
							$html .="<div class='row copy_div' id='alixapress_".$key."'>";
								$html.="<div class='col-sm-1 img_box'>";
								$html .="<img class='img-fluid' src=".$value['imageUrl']." alt='#'>";
								$html.="</div>";
								$html .="<div class='col-sm-11 txt_box'>";
								$html .="<p><b>".$value['title']."</b></p>";
								$html .="<p> Seller ".$value['seller']."</p>";
								$html .="<p>".$value['currency']." ".$value['value']."</p>";
								$html .="</div>";
							$html .="</div>";

					}
				}
				else
				{
						$html .="<p>No Item Found!!</p>";
				}
					if(!empty($scrollIdentifier))
							$html .="<p id='alixapress_load'><button class='btn btn-default' onclick='get_more(`alixapress`,`".($scrollIdentifier)."`,`".$query."`,this)'>Load More</button></p>";
							
				$html.="</div>";
				return $html;
			}	
			
			public function showsaved($data)
			{
				global $post;
				$html="<div class='container'>";
				
					foreach ($data as $key => $value) {
						$html .="<div class='row' id='alixapress_".$key."'>";
							$html.="<div class='col-sm-1 img_box'>";
							$html .="<img class='img-fluid' src=".$value['imageUrl']." alt='#'>";
							$html.="</div>";
							$html .="<div class='col-sm-11 txt_box'>";
							$html .="<p><b>".$value['title']."</b></p>";
							$html .="<p> Seller ".$value['seller']."</p>";
							$html .="<p>".$value['currency']." ".$data['value']."</p>";
							$html .='<button type="button" onclick="remove_meta(`alixapress`,`'.$key.'`,this,'.$post->ID.')" class="btn btn-danger">Remove</button>';
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
									$html .="<img class='img-fluid' src=".$data['imageUrl']." alt='#'>";
									$html.="</div>";
										$html .="<div class='col-sm-11 txt_box'>";
										$html .="<p><b>".$data['title']."</b></p>";
										$html .="<p> Seller ".$data['seller']."</p>";
										$html .="<p>".$data['currency']." ".$data['value']."</p>";
										$html .="</div>";
											$html .='<button type="button" onclick="remove_meta(`alixapress`,`'.$key.'`,this,'.$post_id.')" class="btn btn-danger">Remove</button>';
								$html .="</div>";
						$html .="</div>";
				$html .='</div>';
				return  $html;
			}
			public function get_template_frontend($module_setting,$content_meta){
				
				$html= '<div class="container">';
				$html .='<div class="card-columns">';
				foreach ($content_meta as $key => $value) {
						if(array_key_exists('status', $value)){
							
							$html .='<div class="card">';
							$html .='<img class="card-img-top" src="'.$value['imageUrl'].'" alt="Card image">';
							$html .='<h4 class="card-title">'.$value['title'].'</h4>';
							$html .='<p class="card-text">'.$value['currency'].' '.$value['value'].'</p>';
							$html .='<a href="'.$value['detailUrl'].'" class="btn btn-primary">Buy Now</a>';
							$html .='</div>';
						}
			}
				$html .='</div>';
				$html .='</div>';
				return $html;
		}
}
