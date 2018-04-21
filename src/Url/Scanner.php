<?php
namespace Zeayal\Scan\Url;

use GuzzleHttp\Client;

class Scanner {

	/**
	 * @var array 一个由 url 组成的数组
	 *
	 **/
	protected $urls;

	/**
	 * @var \GuzzleHttp\Client
	 */
	protected $httpClient;

	/**
	 * 构造方法
	 * @param array $urls 一个需要被扫描的 url 数组
	 */
	public function __construct(array $urls)
	{
		$this->urls = $urls;
		$this->httpClient = new Client(); 
	}

	public function getInvalidUrls()
	{
		$invalidUrls = [];
		foreach($this->urls as $url) {
			$statusCode = $this->getStatusCodeForUrl($url);
			if ($statusCode >= 400) {
				# code...
				array_push($invalidUrls, $url);
			}
		}
		return $invalidUrls;
	}

	public function getStatusCodeForUrl($url)
	{
		$statusCode;
		try {
			$statusCode = $this->httpClient->request('OPTIONS', $url)->getStatusCode();
		} catch (\Exception $e) {
			$statusCode = 500;
		}
		return $statusCode;
	}
}