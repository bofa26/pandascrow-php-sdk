<?php  
namespace Pandascrow\Http;

use Pandascrow\Exception\RequestException;
/**
 * 
 */
class Request
{
	/**
	 * 
	 * 	@var array
	 * 
	 * 
	 */
	private array $headers = [];
	/**
	 * 
	 *	@var ?array
	 * 
	 * 
	 */
	public ?array $body = null;
	/**
	 * 
	 * 	@var string
	 * 
	 * 
	 */
	public string $method = "GET";
	/**
	 * 
	 * 	@var ?Response
	 * 
	 * 
	 */
	public ?Response $response = null;
	/**
	 * 
	 * 	@var string
	 * 	
	 * 
	 */
	public string $url = "";

	public $scrow = null;

	function __construct($scrow)
	{
		$this->scrow = $scrow;
		$this->response = new Response($scrow->logger);

	}

	public function baseUrl()
	{
		if ($this->scrow->getEnvironment() === 'production') {
			$this->url = 'https://api.pandascrow.io/index/';
			return;
		}
		$this->url = 'https://api.pandascrow.io/sandbox/index/';
	}

	public function addEndpoint(string $endpoint)
	{
		$this->url .= $endpoint;
	}

	public function addHeader(string $name, string $value)
	{
		$this->headers[$name] = $value;
	}

	public function addMethod(string $method)
	{
		$this->method = $method;
	}

	public function build_query(array $query, $seperator = '&'){
		$params = "";
		foreach ($query as $k => $v) {
			$params .= \urlencode($k)."=".\urlencode($v).$seperator;
		}
		$index = strlen($params) - 1;
		if ($params[$index] === $seperator) {
			$params[$index] = ' ';
			$params = rtrim($params);
		}
		return $params;
	}

	public function getUrl()
	{
		if (is_array($this->body) && $this->method == "GET") {
			$params = $this->build_query($this->body);
			$this->url .= $params;
		}
		return $this->url;
	}

	public function send()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->getUrl());
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
		switch ($this->method) {
			case 'POST':
				if ($this->body === null || empty($this->body)) {
					$this->scrow->logger->log("error", "Post request body can not be empty");				
					throw new RequestException("Post request body can not be empty");
				}
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->body));
				break;
			
			default:
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
				break;
		}
		$response = curl_exec($curl);
		$this->response->setResponse($response);
	}

}