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

require'Pandascrow/Exception/appexception.php';
require'Pandascrow/Exception/responseexception.php';
require'Pandascrow/Exception/requestexception.php';
require'Pandascrow/Exception/validateexception.php';
require'Pandascrow/Logger/logger.php';
require'Pandascrow/router.php';
require'Pandascrow/App/config.php';
require'Pandascrow/Helpers/validate.php';
require'Pandascrow/scrow.php';
require'Pandascrow/Builds/bank.php';
require'Pandascrow/Http/response.php';
require'Pandascrow/Http/request.php';


$scrow  = new Scrow(config());

try {
	$data = $scrow->get('/bank/list/', 'Nigeria');
} catch (Exception $e) {
	echo $e->getMessage();
} 




