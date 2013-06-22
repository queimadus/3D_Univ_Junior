<?php
$title = "Contactos - ";
define('XHR', (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));

if(!XHR){
	include("top.php"); 
	include("header.php");
}

include("contactos-c.php");

if(!XHR)
	include("bottom.php");

?>