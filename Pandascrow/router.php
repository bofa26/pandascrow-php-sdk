<?php 
namespace Pandascrow;

use Pandascrow\Exception\AppException;

/**
 * 
 */
class Router
{
	
	private static $route = [
							 '/bank/list/' => ['get' => ['Pandascrow\Builds\Bank', 'lists']],
							 '/bank/resolve/' => ['get' => ['Pandascrow\Builds\Bank', 'resolve']], 
							 '/bill/lists/' => ['get' => ['Pandascrow\Builds\Bills', 'lists']]
							];


	public static function getPath(string $endpoint, string $method)
	{
		if (! isset(self::$route[$endpoint][$method])) {
			throw new AppException("The $endpoint you requested can not be reached");	
		}
		return self::$route[$endpoint][$method];
	}
}