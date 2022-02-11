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
			'apiKey' => $apiKey,
		];
		$queryProd = [
			'filter[manufacturer]' => $request->input('manufacturer'), 
		];
		
		$products = $this->apiConnect($dataApi,$queryProd,$request);
		$product = $products['content'];
		
		$key = array_search($request->input('article'), array_column($product['products'], 'article'));
		
		$dataApi['requestType'] = '/api/v5/orders/create';
		$dataApi['method'] = 'POST';
		$fio = explode(" ", $request->input('name'));
		$order = [
				'number' => '1041995',
				'orderMethod' => 'test',
				'status' => 'trouble',
				'orderType' => 'fizik',
				'customerComment' => $request->input('message'),
				'customer' => [
					'firstName' =>$fio[0],
					'lastName' => (!empty($fio[1])) ? $fio[1] : '',				
					'patronymic' => (!empty($fio[2])) ? $fio[2] : '',				
				],
				'items' => [
					0 => [
						'productName' => str_replace(' '.$request->input('article').' '.$request->input('manufacturer'), '', $product['products'][$key]['name']),
						'offer' => [
							'id' => $product['products'][$key]['offers'][0]['id']
							]
						]
				]
			];
		$queryOrd = [
			'site' => 'test',
			'order' => $order,
		];
		
		$newOrder = $this->apiConnect($dataApi,$queryOrd,$request);
		$status = $newOrder['status'];
		
		if($status == 200 || $status == 201){
			echo $status;
		}else{
			var_dump($newOrder);
		}
		
    }
	
    public function apiConnect($dataApi,$query,$request)
    {
        $endpoint = $dataApi['url'].$dataApi['requestType'];
		$client = new \GuzzleHttp\Client();

		if($dataApi['method'] != 'POST'){
			$query['apiKey'] = $dataApi['apiKey'];
			$response = $client->request($dataApi['method'], $endpoint, ['query' => $query]);
		}else{
			$response = $client->post(
				$endpoint.'?apiKey='.$dataApi['apiKey'],[
					'json' => [
						'site' => $query['site'],
						'order' => json_encode($query['order']),
						]
				]
			);
			//$response = $requests;
		}
		
		
		$statusCode = $response->getStatusCode();
		$content = json_decode($response->getBody(), true);
				
		return array('status' => $statusCode, 'content' => $content);
    }
}
