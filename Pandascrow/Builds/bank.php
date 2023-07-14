<?php  
namespace Pandascrow\Builds;

use Pandascrow\Scrow;
use Pandascrow\Helpers\Validate;

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
	private static Scrow $scrow;
	/**
	 * 
	 * 
	 * 	@var Validate
	 * 
	 * 
	 */
	private static Validate $validate;

	private static function initSelf()
	{
		self::$scrow = new Scrow(config());
		self::$validate = new Validate(self::$scrow->logger);
	}

	public static function lists(string $country)
	{
		self::initSelf();

		self::$scrow->logger->log("notice", "initializing Fetch Banks process...");
		$body = ['country' => $country];
		$data = self::$validate->sortPathData('/bank/list/', $body);
		$resp = self::$scrow->httpBuilder('/bank/list/', "GET", $data);
		self::$scrow->logger->log("notice", "finished Fetch Banks process...");
		return $resp;
	}

	public static function resolve(array $body)
	{
		self::initSelf();

		self::$scrow->logger->log("notice", "initializing Validate Nuban process...");
		$data = self::$validate->sortPathData("/bank/resolve/", $body);
		$resp = self::$scrow->httpBuilder("/bank/resolve/", "GET", $data);
		self::$scrow->logger->log("notice", "finished Validate Nuban process");
		return $resp;
	}
}