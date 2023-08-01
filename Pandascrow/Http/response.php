<?php  
namespace Pandascrow\Http;

use Pandascrow\Exception\ResponseException;
use Pandascrow\Logger\Logger;
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
	public string $error_message = "";
	/**
	 * 
	 * 	@var status
	 * 
	 * 
	 */
	public $status = null;
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
	 * @param string|bool
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
	 * @param string|bool
	 * 
	 * 
	 */
	public function setResponse($resp = false)
	{
		$this->jsonDecode($resp);
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