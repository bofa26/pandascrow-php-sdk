<?php  
namespace Pandascrowsdk\Pandascrow\Http;

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
	public string $error_message = '';
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

	public function jsonDecode($resp = null)
	{
		if ($resp == null) {
			$this->has_error = true;
			$this->error_message = "The API returned this response'''' ";
			return;
		}
		return json_decode($resp);
	}

	public function setResponse($response = null)
	{
		$resp = $this->jsonDecode($response);
		if ($resp->status != 200) {
			$this->has_error = true;
			$this->error_message = $resp->message;
		}else{
			foreach($response as $resp => $v){
				$this->$resp = $v;
			}
			$this->body = (object)[
									'status' => $this->status,
									'data'   => $this->data
								  ];
		}
	}

	public function getBody()
	{
		return $this->body;
	}


}