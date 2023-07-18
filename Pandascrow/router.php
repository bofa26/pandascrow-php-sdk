<?php 
namespace Pandascrow;

use Pandascrow\Exception\AppException;

/**
 * 
 */
class Router
{
	/**
	 * 
	 * @var array 
	 *
	 * 
	 */
	private static $route = [
							 '/bank/list/'   => ['get' => ['Pandascrow\Builds\Bank', 'lists']], 
							 '/bank/resolve/' => ['get' => ['Pandascrow\Builds\Bank', 'resolve']],
							 '/bill/lists/'  => ['get' => ['Pandascrow\Builds\Bills', 'lists']],
							 '/bill/validate/phone' => ['get' => ['Pandascrow\Builds\Bills', 'validate_phone']],
							 '/bill/data/plans' => ['get' => ['Pandascrow\Builds\Bills'], 'data_plans'],
							 '/bill/data/purchase' => ['post' => ['Pandascrow\Builds\Bills'], 'data_purchase'],
							 '/bill/utility/variation' => ['get' => ['Pandascrow\Builds\Bills'], 'utility_variation'],
							 '/bill/validate' => ['get' => ['Pandascrow\Builds\Bills'], 'validate'],
							 '/lookup/bvn' => ['get' => ['Pandascrow\Builds\Kyc'], 'lookup_bvn'],
							];

	/**
	 * 
	 * @param string 
	 * @param string
	 * @throws AppException
	 * @return Callable
	 * 
	 */
	public static function getPath(string $endpoint, string $method)
	{
		if (! isset(self::$route[$endpoint][$method])) {
			throw new AppException("The $endpoint you requested can not be reached");	
		}
		return self::$route[$endpoint][$method];
	}
}