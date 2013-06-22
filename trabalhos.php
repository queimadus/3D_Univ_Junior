<?php
$title = "Trabalhos - ";
define('XHR', (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));


if(!XHR){
	require("top.php"); 
	require("header.php");
}

require("trabalhos-c.php");

if(!XHR)
	require("bottom.php");

?>