<?php  
use Pandascrow\Scrow;

require_once'autoload.php';
require'vendor/autoload.php';

try {
	 $scrow = new Scrow();
	 $resp = $scrow->get('/bank/list/', ['country'=>'Nigeria']);
	 echo $resp;
} catch (Exception $e) {
	echo $e->getMessage();
}



