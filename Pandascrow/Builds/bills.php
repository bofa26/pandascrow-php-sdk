<?php  
namespace Pandascrowsdk\Pandascrow\Builds;
use Pandascrowsdk\Pandascrow\App\Scrow;

/**
 * 
 */
class Bills
{
	/**
	 * 
	 * 
	 * 	@var Scrow
	 * 
	 * 
	 */
	public Scrow $scrow;

	function __construct(Scrow $scrow)
	{
		$this->scrow = $scrow;
	}

	public function lists(array $data)
	{
		$this->scrow->logger->log("notice", "initializing Bills List process...");
		$resp = $this->scrow->httpBuilder('/bill/lists/', "GET", $body);
		$this->scrow->logger->log("notice", "finished Bills List process...");
		return $resp;
	}
}