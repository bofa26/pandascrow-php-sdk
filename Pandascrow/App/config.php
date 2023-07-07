<?php 

/**
 * 
 *This file handles the configurations needed.
 *Some of these configurations were set by default. 
 * 
 * 
 * 
 */

function config():stdclass
{
    return (object)[
                        'secret_key' => 'SK_2334992HDJSJHJFH',
                        'version' => '2.0.0',
                        'app_name' => 'selecao',
                        'app_id'   => '253389',
                        'environment' => 'sandbox'// use 'production' when going live
                   ];
}


 ?>