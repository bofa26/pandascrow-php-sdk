<?php 
namespace Pandascrow\Builds;

use Pandascrow\Scrow;
use Pandascrow\Helpers\Validate;
use Pandascrow\Logger\Logger;
/**
 * 
 */
class Kyc
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
	

	public function lookup_bvn(string $bvn)
	{
		
	}
}