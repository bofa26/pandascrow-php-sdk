<?php  
namespace Pandascrow\Http;

use Pandascrow\Exception\ResponseException;
/**
 * 
 */
class Response
{
	/**
	 * 
	 * @var bool
	 * 
	 * 
	 */	
	public bool $has_error = false;
	/**
	 * 
	 * 	@var string
	 * 
	 * 
	 */
	public ?string $error_message = null;
	/**
	 * 
	 * 	@var status
	 * 
	 * 
	 */
	public $status = '';
	/**
	 * 
	 * 	
	 * 
	 * 
	 */
	public $data = null;
	/**
	 * 
	 * 	
	 * 
	 * 
	 */
	public $body = null;


	private $logger = null;

	function __construct($logger){
		$this->logger = $logger;
	}
	/**
	 * 
	 * @param string|boolean
	 * 
	 * 
	 */
	public function jsonDecode($resp = false)
	{
		$this->body = json_decode($resp);
		if ($this->body == null) {
			$error_message = "The API returned this response'''' ";
			$this->logger->log("error", $error_message);
			throw new ResponseException($error_message);
		}
	}
	/**
	 * 
	 * @param string|boolean
	 * 
	 * 
	 */
	public function setResponse($response = false)
	{
		$this->jsonDecode($response);
		$this->status = $this->body->status;
		$this->data = $this->body->data;
		if ($this->status != 200) {
			$this->has_error = true;
			$this->error_message = $this->data->message;
		}
	}

	public function getBody()
	{
		return $this->data;
	}

}