<?php 

/**
 * 
 *This file handles the configurations needed.
 *Some of these configurations were set by default. 
 * 
 * 
 * 
 */

function config()
{
    return (object)[
                        'secret_key' => 'SK_2334992HDJSJHJFH',
                        'app_name' => 'selecao',
                        'app_id'   => '253389',
                        'environment' => 'sandbox'// use 'production' when going live
                   ];
}


defined('LOG_PATH') OR define('LOG_PATH', dirname(dirname(__DIR__)).'/Log/');


 ?>