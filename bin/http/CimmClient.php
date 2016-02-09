<?php

/**
 * CIMM HTTP Client Class
 */
require_once 'autoloader.php';

use GuzzleHttp\Client;

class CimmClient {
	
	const GOOGLE_CURR_EP = "https://www.google.com/finance/converter";
	
	public function sendRequest($baseURI) {
		$client = new Client();
		$response = $client->get($baseURI);
		$body = $response->getBody();
		echo $body;
	}
}

$a = $_GET['a'];
$from = $_GET['from'];
$to = $_GET['to'];
$cimm = new CimmClient();
$url = $cimm::GOOGLE_CURR_EP . '?a='.$a .'&from='.$from .'&to='.$to;
$cimm->sendRequest($url);