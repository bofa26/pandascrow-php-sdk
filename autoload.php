<?php  


spl_autoload_register(function ($classname)
{
	$classname = str_replace('\\', '/', $classname);
	require_once "$classname.php";
});