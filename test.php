<?php  
use Pandascrow\Scrow;

require_once'Pandascrow/App/config.php';
require_once'autoload.php';
require'vendor/autoload.php';

try {
	 $scrow = new Scrow(config());
	 $resp = $scrow->get('/bank/list/', 'Nigeria');
	 echo $resp;
} catch (Exception $e) {
	echo $e->getMessage();
}



