<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RetailController extends Controller
{
    public function send(Request $request)
    {
		$apiKey = 'QlnRWTTWw9lv3kjxy1A8byjUmBQedYqb';
		$dataApi = [
			'url' => 'https://superposuda.retailcrm.ru',
			'requestType' => '/api/v5/store/products',
			'method' => 'GET',
		];
		$queryProd = [
			'filter[manufacturer]' => $request->input('manufacturer'), 
			'apiKey' => $apiKey,
		];
		
		$products = $this->apiConnect($dataApi,$queryProd,$request);
		$product = $products['content'];
		
		$key = array_search($request->input('article'), array_column($product['products'], 'article'));
		
		$dataApi['requestType'] = '/api/v5/orders/create';
		$dataApi['method'] = 'POST';
		$fio = explode(" ", $request->input('name'));
		$queryOrd = [
			'order[status]' => 'trouble',
			'order[orderType]' => 'fizik',
			'site' => 'test',
			'order[orderMethod]' => 'test',
			'order[number]' => '1041995',
			
			'order[customer][firstName]' => $fio[0],
			'order[customer][lastName]' => $fio[1],
			'order[customer][patronymic]' => $fio[2],
			'order[customerComment]' => $request->input('message'),
			'order[items][0][productName]' => str_replace(' '.$request->input('article').' '.$request->input('manufacturer'), '', $product['products'][$key]['name']),
			'order[items][0][offer][id]' => $product['products'][$key]['offers'][0]['id'], 
			'apiKey' => $apiKey,
		];
		
		$newOrder = $this->apiConnect($dataApi,$queryOrd,$request);
		$status = $newOrder['status'];
		
		if($status == 200){
			echo $status;
		}else{
			var_dump($newOrder);
		}
		
    }
	
    public function apiConnect($dataApi,$query,$request)
    {
        $endpoint = $dataApi['url'].$dataApi['requestType'];
		$client = new \GuzzleHttp\Client();

		$response = $client->request($dataApi['method'], $endpoint, ['query' => $query]);

		$statusCode = $response->getStatusCode();
		$content = json_decode($response->getBody(), true);
				
		return array('status' => $statusCode, 'content' => $content);
    }
}
