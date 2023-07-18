<?php  
use Pandascrow\Exception\AppException;
use Pandascrow\Exception\ValidateException;
use Pandascrow\Exception\ResponseException;
use Pandascrow\Exception\RequestException;
use Pandascrow\Logger\Logger;
use Pandascrow\Router;
use Pandascrow\Helpers\Validate;
use Pandascrow\Scrow;
use Pandascrow\Builds\Bank;
use Pandascrow\Http\Response;
use Pandascrow\Http\Request;


require_once'Pandascrow/App/config.php';
require_once'autoload.php';
require'vendor/autoload.php';

try {
	 $scrow = new Scrow(config());
	 $resp = $scrow->get('/bank/resolve/', ['account_number' => '5423950042', 'bank_code' => '045']);
	 echo $resp;
} catch (Exception $e) {
	echo $e->getMessage();
}



