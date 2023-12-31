<?php  
namespace Pandascrow\Builds;

use Pandascrow\Scrow;
use Pandascrow\Helpers\Validate;
use Pandascrow\Logger\Logger;
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
		self::$scrow = new Scrow();
		self::$validate = new Validate(self::$scrow->logger);
	}

	public function lists(array $categories)
	{
		self::initSelf();
		
		self::$scrow->logger->log("notice", "initializing Bills List process...");
		$body = self::$validate->validation($categories, ['airtime' => 'alpha', 'data' => 'alpha', 'utility' => 'alpha']);
		$resp = self::$scrow->httpBuilder('/bill/lists/', "GET", $body);
		self::$scrow->logger->log("notice", "finished Bills List process...");
		return $resp;
	}

	public function validate_phone(array $data)
	{
		self::initSelf();

		self::$scrow->logger->log("notice", "initializing Bills Phone Validation process...");
		$body = self::$validate->validation($data, ['phone' => 'required|numeric', 'country' => 'required|alpha']);
		$resp = self::$scrow->httpBuilder('/bill/validate/phone/', "GET", $body);
		self::$scrow->logger->log("notice", "finished Bills Phone Validation process...");
		return $resp;
	}

	public function data_plans(array $data)
	{
		self::initSelf();
		
		self::$scrow->logger->log("notice", "initializing Bills Data Plans process...");
		$body = self::$validate->validation($data, ['networkID' => 'required|numeric']);
		$resp = self::$scrow->httpBuilder('/bill/data/plans', "GET", $body);
		self::$scrow->logger->log("notice", "finished Bills Data Plans process...");
		return $resp;
	}

	public function data_purchase(array $data)
	{
		self::initSelf();
		
		self::$scrow->logger->log("notice", "initializing Bills Data Purchase process...");
		$body = self::$validate->validation($data, 
												[
													 'phone' => 'required|numeric',
													 'plan' =>'required|numeric', 
													 'amount' => 'required|numeric',
													 'network' => 'required|alpha'
												]
										    );
		$resp = self::$scrow->httpBuilder('/bill/data/purchase', "POST", $body);
		self::$scrow->logger->log("notice", "finished Bills Data Plans process...");
		return $resp;
	}

	public function utility_variation(array $data)
	{
		self::initSelf();
		
		self::$scrow->logger->log("notice", "initializing Bills Utility Variation process...");
		$body = self::$validate->validation($data, ['phone' => 'required|numeric']);
		$resp = self::$scrow->httpBuilder('/bill/utility/variation', "GET", $body);
		self::$scrow->logger->log("notice", "finished Bills Data Plans process...");
		return $resp;
	}

	public function validate(array $data)
	{
		self::initSelf();
		
		self::$scrow->logger->log("notice", "initializing Bills Validating process...");
		$body = self::$validate->validation($data, ['serviceID' => 'required|numeric', 'customerID' => 'required|numeric', 'type' => 'required|alpha']);
		$resp = self::$scrow->httpBuilder('/bill/validate', "GET", $body);
		self::$scrow->logger->log("notice", "finished Bills Validating process...");
		return $resp;
	}
}