<?php  
namespace Pandascrowsdk\Pandascrow\Builds;

use Pandascrowsdk\Pandascrow\App\Scrow;
use Pandascrowsdk\Pandascrow\Helpers\Validate;

/**
 * 
 */
class Bank
{
	/**
	 * 
	 * 
	 * 	@var Scrow
	 * 
	 * 
	 */
	public Scrow $scrow;
	/**
	 * 
	 * 
	 * 	@var Validate
	 * 
	 * 
	 */
	public Validate $validate;

	function __construct(Scrow $scrow)
	{
		$this->scrow = $scrow;
		$this->validate = new Validate($scrow);
	}

	public function fetchBanks(string $country)
	{

		$this->scrow->logger->log("notice", "initializing Fetch Banks process...");
		$body = ['country' => $country];
		$data = $this->validate->sortPathData('/bank/list/', $body);
		$resp = $this->scrow->httpBuilder('/bank/list/', "GET", $data);
		$this->scrow->logger->log("notice", "finished Fetch Banks process...");
		return $resp;
	}

	public function validateNuban(array $body)
	{
		$this->scrow->logger->log("notice", "initializing Validate Nuban process...");
		$data = $this->validate->sortPathData("/bank/resolve/", $body);
		$resp = $this->scrow->httpBuilder("/bank/resolve/", "GET", $data);
		$this->scrow->logger->log("notice", "finished Validate Nuban process");
		return $resp;
	}
}