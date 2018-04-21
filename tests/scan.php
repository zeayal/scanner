<?php
// 1.使用 composer 自动加载器 
require('vendor/autoload.php');

use League\Csv\Reader;
use GuzzleHttp\Client;

// 2.实例化 Guzzle HTTP 客户端
$client = new Client();

// 3.打开并迭代处理 csv 文件，扫描死链


$csv = Reader::createFromPath($argv[1], 'r');

foreach ($csv as $csvRow) {
    //do something here
   	$url = $csvRow[0];
   	try {
	   	// 4.发送 Http OPTIONS请求
	   	$httpResponse = $client->request('OPTIONS', $url);
	   	// 5.检查 HTTP 响应的状态码
	   	if ($httpResponse->getStatusCode() >= 400) {
	   		# throw exception
	   		throw new \Exception();
	   	}
   	} catch (\Exception $e) {
   		// 6.把死链接发给标准输出
   		echo $url . PHP_EOL;
   	}
}

