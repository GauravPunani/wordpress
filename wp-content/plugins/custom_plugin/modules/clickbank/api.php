<?php


class clickbank{

	public function getdata()
	{
			

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://api.clickbank.com/rest/1.3/orders/list");
			curl_setopt($ch, CURLOPT_HEADER, true); 
			curl_setopt($ch, CURLOPT_GET, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/xml", "Authorization: << DEVELOPER KEY >>:<< API KEY >>"));
			$result = curl_exec($ch);
			curl_close($ch);

			return  $result;
	}

}

$obj=new clickbank;
print_r($obj->getdata);