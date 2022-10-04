<?php

api_expose('drm_all_categories');

function drm_all_categories($params=false){


DB::beginTransaction();
try {

	$client = new \GuzzleHttp\Client();
	
	$response = $client->request('GET', 'http://165.227.134.199/api/v1/catalogs/categories',[
		'headers'	=> [
			'content-type' => 'application/json',
			'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYmMyMTc2NzlkZjZhOTdhMzU3ZjQwMzdlMjNmMjM3YTYyY2I1M2FiNGJjYmQwNDNiYTNhOTEwYzI2OTU2NzYzMTBiZWE0ZDY2NDg4NjQyYzAiLCJpYXQiOjE2MDM1MjI2NDcsIm5iZiI6MTYwMzUyMjY0NywiZXhwIjoxNjM1MDU4NjQ3LCJzdWIiOiI2MiIsInNjb3BlcyI6W119.Ky6P1ldQPb6Hlv_GucNZw5rEkk40-2jqctI9i3IuraGpoTPXtHVQl-0fvkItzd8gW6hNhM-9cO-mxLGyFWxAoaiopVAqxqrXc_f6Dfz2lbGXpYYFlRgNEQZrWRRHMeZr6kZgPszf8IWCcvcV6J7MGjlB-EOQbJ922ATnJdsizRnA0lOpt4q_VDRoGpIER7nRjs68Kbss2RHQ-zoHUk24S1mSR-ulRBFv8eASWvXjyGWp0i4Pp5I0ATRB5cRltH_GuZ690_QNfMZfaGi0KQZRSNTp_T0GuNdCtagYabljSQKZPWWNHesOdd6bUIA7rz_FGWRC0lIKRSSYOGC2oPWVQ6ESn_IbabFTTmUptJBaRCtcQdQzhf3Fv4eIUewB8DIrWvy0oC_T_s-oPJI0G8EThDdkrf-tKvaMna3LWArxiv9DOCmS5Df8leF1HwgJ9U07cfdjCWDwa8d11UANxxdUVrwYdSZjjqPkY3fjInZ-151fY90DssVrWpUMrG5QSuFgCH3ZeqzZtGk8k0G8wtSboVNzJMUa5__9dxWnMIEXKe8LdW2PZxS0P_MVqpuXlgw-CYooZLk402G_zV0loQaolax7ZWdXSGwjUsPMLv-i4X875oeb-txcV8_DdFvL7JWjwcsQWfRTPzRhSlne7N-9OAYc91-cPO8oZaQ-2GVVVpI',
			
		],
		
		'query' => [
			'country' => 1,
		]
	]);

	if($response->getStatusCode() == 200){
		$categories = json_decode($response->getBody()->getContents());

		dd($categories);

		if($categories){


			foreach ($categories as $categorie) {
				dd($categorie);
			}

		}


	}

    DB::commit(); // all good
}
catch (\Exception $e) {
    DB::rollback(); // something went wrong


    $e->getMessage();
}



}



