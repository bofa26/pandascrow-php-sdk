<?php  
use Pandascrowsdk\Pandascrow\Exception\AppException;
use Pandascrowsdk\Pandascrow\Exception\RequestException;
use Pandascrowsdk\Pandascrow\App\Scrow;
use Pandascrowsdk\Pandascrow\Http\Response;
use Pandascrowsdk\Pandascrow\Http\Request;
use Pandascrowsdk\Pandascrow\Builds\Bank;


require'Pandascrow/App/config.php';
require'Pandascrow/App/scrow.php';
require'Pandascrow/Http/response.php';
require'Pandascrow/Http/request.php';
require'Pandascrow/Builds/bank.php';

$response = new Response();
$request  = new Request($response);
$scrow    = new Scrow(config());
$bank     = new Bank($scrow);


print_r($bank->fetchBanks('Nigeria'));
echo $request->getUrl();