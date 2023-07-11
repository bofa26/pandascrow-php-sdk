<?php  
namespace Pandascrowsdk\Pandascrow\App;

use Pandascrowsdk\Pandascrow\Exception\AppException;
use Pandascrowsdk\Pandascrow\Exception\RequestException;
use Pandascrowsdk\Pandascrow\Logger\Logger;
use Pandascrowsdk\Pandascrow\Http\Response;
use Pandascrowsdk\Pandascrow\Http\Request;

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
	public ?Logger $logger = null;
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
				if (! is_string($v) || ! substr($v, 0, 3) === "SK_") {
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
	public function getSecretKey():string
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
	public function getVersion():string
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
	public function getAppName():string
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
	public function getAppId():string
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
	public function httpBuilder(string $endpoint, string $method, ?array $body = null)
	{	
		$response = new Response($this);
		$request  = new Request($response, $this);

		$request->body = $body;
		$request->addHeader('Content-Type', 'application/json');
		$request->addHeader('Authorization', $this->getSecretKey());
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

	public function multiRequest(string $endpoint, string $method, array $body)
	{
		$response = array();
		foreach ($body as $name => $data) {
			if (! is_array($data) && ! $data == null) {
				$this->logger->log("error", "Array data for multiple request should be type array or null");
				throw new RequestException("Array data for multiple request should be type array or null");
			}
			$response[$name] = $this->httpBuilder($endpoint, $method, $data);
		}
		return $response;
	}
}