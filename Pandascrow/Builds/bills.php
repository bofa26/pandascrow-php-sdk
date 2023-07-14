<?php  
namespace Pandascrow\Builds;
use Pandascrow\Scrow;

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
	private Scrow $scrow;

	private static function initSelf()
	{
		self::$scrow = new Scrow(config());
		self::$validate = new Validate(self::$scrow->logger);
	}

	public function lists(string $categories)
	{
		self::initSelf();
		
		self::$scrow->logger->log("notice", "initializing Bills List process...");
		$data = array('categories' => $categories);
		$body = self::$validate->sortPathData('/bill/lists/', $data);
		$resp = self::$scrow->httpBuilder('/bill/lists/', "GET", $body);
		self::$scrow->logger->log("notice", "finished Bills List process...");
		return $resp;
	}
}