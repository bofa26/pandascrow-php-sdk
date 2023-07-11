<?php  
use Pandascrowsdk\Pandascrow\Exception\AppException;
use Pandascrowsdk\Pandascrow\Exception\RequestException;
use Pandascrowsdk\Pandascrow\Logger\Logger;
use Pandascrowsdk\Pandascrow\App\Scrow;
use Pandascrowsdk\Pandascrow\Http\Response;
use Pandascrowsdk\Pandascrow\Http\Request;
use Pandascrowsdk\Pandascrow\Builds\Bank;

require'Pandascrow/Exception/appexception.php';
require'Pandascrow/Exception/requestexception.php';
require'Pandascrow/App/config.php';
require'Pandascrow/Logger/logger.php';
require'Pandascrow/App/scrow.php';
require'Pandascrow/Http/response.php';
require'Pandascrow/Http/request.php';
require'Pandascrow/Builds/bank.php';


$scrow    = new Scrow(config());
$bank     = new Bank($scrow);


try {
	$bank->fetchBanks('Nigeria');
} catch (Exception $e) {
	echo $e->getMessage();
}