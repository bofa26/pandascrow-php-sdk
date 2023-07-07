<?php  
namespace Pandascrowsdk\Pandascrow\App;

//use Pandascrowsdk\Pandascrow\Exception\AppException;
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
	 * 
	 * 
	 *
	 *	@throws AppException
	 * 
	 */
	function __construct($config)
	{
		foreach ($config as $k => $v) {
			if ($k === 'secret_key') {
				if (! is_string($k)) {
					throw new \Exception("A valid Pandascrow secret key must begin with SK_");
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
		$response = new Response();
		$request = new Request($response);

		$request->body = $body;
		$request->addHeader('Content-Type', 'application/json');
		$request->addHeader('Authorization', $this->getSecretKey());
		$request->addHeader('AppId', $this->getAppId());
		$request->addMethod($method);
		$request->baseUrl($this);
		$request->addEndpoint($endpoint);
		$request->send();

		if ($request->response->has_error) {
			return $request->response->error_message;
		}
		return $request->response->getBody();
	}
}