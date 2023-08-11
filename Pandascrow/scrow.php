<?php  
namespace Pandascrow;

use Pandascrow\Exception\AppException;
use Pandascrow\Exception\RequestException;
use Pandascrow\Logger\Logger;
use Pandascrow\Router;
use Pandascrow\Http\Request;

/**
 * 
 */
class Scrow
{
	/**
	 * 
	 * 
	 * 
	 * @var string 
	 * 
	 * 
	 * 
	 */
	private string $secret_key = '';
	/**
	 * 
	 * 
	 * 
	 * @var string 
	 * 
	 *
	 */
	private string $version = '2.0.0';
	/**
	 * 
	 * 
	 * 
	 * @var string 
	 * 
	 *
	 */
	private string $app_name = '';
	/**
	 * 
	 * 
	 * 
	 * @var string 
	 * 
	 *
	 */
	private string $app_id = '';
	/**
	 * 
	 * 
	 * 
	 * @var string 
	 * 
	 *
	 */
	private string $environment = '';
	/**
	 * 
	 *	@var ?Logger 
	 * 
	 * 
	 * 
	 */
	private ?Logger $logger = null;
	/**
	 * 
	 * 
	 * 
	 *
	 *	@throws AppException
	 * 
	 */

	function __construct($config)
	{
		$this->logger = new Logger();
		foreach ($config as $k => $v) {
			if ($k === 'secret_key') {
				if (! is_string($v) || substr($v, 0, 3) != "SK_") {
					$this->logger->log("notice", "A valid Pandascrow secret key must begin with SK_");
					throw new AppException("A valid Pandascrow secret key must begin with SK_");
				}
			}
			$this->$k = $v;
		}
	}
	/**
	 * 
	 * 
	 * 	@return string
	 * 
	 * 
	 */
	private function getSecretKey():string
	{
		return $this->secret_key;
	}
	/**
	 * 
	 * 
	 * 	@return string
	 * 
	 * 
	 * 
	 */
	private function getVersion():string
	{
		return $this->version;
	}
	/**
	 * 
	 * 
	 * 	@return string
	 * 
	 * 
	 * 
	 */
	private function getAppName():string
	{
		return $this->app_name;
	}
	/**
	 * 
	 * 
	 * 	@return string
	 * 
	 * 
	 * 
	 */
	private function getAppId():string
	{
		return $this->app_id;
	}
	/**
	 * 
	 * 
	 * 	@return string
	 * 
	 * 
	 * 
	 */
	public function getEnvironment():string
	{
		return $this->environment;
	}
	/**
	 * 
	 * 
	 * 	@param string
	 * 	@param string
	 * 	@param ?array
	 * 
	 * 
	 */
	public function httpBuilder(string $endpoint, string $method, array $body = [])
	{	
		$request  = new Request($this);
		$request->body = $body;
		$request->addHeader('Content-Type', 'application/json');
		$request->addHeader('Authorization', $this->getSecretKey());
		$request->addHeader('version', $this->getVersion());
		$request->addHeader('AppId', $this->getAppId());
		$request->addMethod($method);
		$request->baseUrl();
		$request->addEndpoint($endpoint);
		$request->send();

		if ($request->response->has_error) {
			return $request->response->error_message;
		}
		return $request->response->getBody();
	}
	/**
	 * 
	 * 	@param string
	 *  @param string
	 *	@param array
	 * 	@return array 
	 * 
	 */
	public function multiRequest(string $endpoint, string $method, array $body)
	{

		$response = array();
		foreach ($body as $name => $data) {
			if (! is_array($data)) {
		 		$this->logger->log("error", "Data for multiple request should be type array");
				throw new RequestException("Data for multiple request should be type array");
			}
			$response[$name] = ($method === "GET") ? $this->get($endpoint, $data) : $this->post($endpoint, $data);
		}
		return $response;
	}
	/**
	 * 
	 * 	@param string
	 * 	@param array|string
	 * 	@return Callable
	 * 
	 */
	public function get(string $endpoint, array|string $params)
	{
		$callable = Router::getPath($endpoint, "get");

		return call_user_func($callable, $params);
	}	
	/**
	 * 
	 * 	@param string
	 * 	@param array
	 * 	@return Callable
	 * 
	 */
	public function post(string $endpoint, array $params)
	{
		$callable = Router::getPath($endpoint, "post");

		return call_user_func($callable, $params);
	}
}