<?php  
namespace Pandascrowsdk\Pandascrow\Http;

use Pandascrowsdk\Pandascrow\Exception\RequestException;
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


	private $scrow = null;

	function __construct($scrow){
		$this->scrow = $scrow;
	}

	public function jsonDecode($resp = null)
	{
		$this->body = json_decode($resp);
		if ($this->body == null) {
			$error_message = "The API returned this response'''' ";
			$this->scrow->logger->log("error", $error_message);
			throw new RequestException($error_message);
		}
	}

	public function setResponse($response = null)
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