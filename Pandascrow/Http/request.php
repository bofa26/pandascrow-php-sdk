<?php  
namespace Pandascrowsdk\Pandascrow\Http;

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

	function __construct(Response $response)
	{
		$this->response = $response;
	}

	public function baseUrl($scrow)
	{
		if ($scrow->getEnvironment() === 'sandbox') {
			$this->url = 'https://api.pandascrow.io/sandbox/index/';
			return;
		}
		$this->url = 'https://api.pandascrow.io/index/';
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

	public function getUrl()
	{
		if (is_array($this->body) && $this->method == "GET") {
			$params = http_build_query($this->body, '', '&');
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
					throw new \Exception("Post request body can not be empty");					
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