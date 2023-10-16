<?php  
namespace Pandascrow\Builds;

use Pandascrow\Scrow;
use Pandascrow\Helpers\Validate;
use Pandascrow\Logger\Logger;

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
		self::$scrow = new Scrow();
		self::$validate = new Validate(self::$scrow->logger);
	}

	public static function lists(array $body)
	{
		self::initSelf();

		self::$scrow->logger->log("notice", "initializing Fetch Banks process...");
		$data = self::$validate->validation($body, ['country' => 'required']);
		$resp = self::$scrow->httpBuilder('/bank/list/', "GET", $data);
		self::$scrow->logger->log("notice", "finished Fetch Banks process...");
		return $resp;
	}

	public static function resolve(array $body)
	{
		self::initSelf();

		self::$scrow->logger->log("notice", "initializing Validate Nuban process...");
		$data = self::$validate->validation($body, ['account_number' => 'required|numeric', 'bank_code' => 'required|numeric']);
		$resp = self::$scrow->httpBuilder("/bank/resolve/", "GET", $data);
		self::$scrow->logger->log("notice", "finished Validate Nuban process");
		return $resp;
	}
}