<?php  
namespace Pandascrowsdk\Pandascrow\Builds;
use Pandascrowsdk\Pandascrow\App\Scrow;

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

	function __construct(Scrow $scrow)
	{
		$this->scrow = $scrow;
	}

	public function fetchBanks(string $country)
	{
		$body = ['country' => $country];
		$resp = $this->scrow->httpBuilder('/bank/list/', "GET", $body);
	}
}