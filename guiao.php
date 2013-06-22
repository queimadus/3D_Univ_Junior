<?php
$title = "Guião - ";
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

if(!$ajax){
	require("top.php"); 
	require("header.php");
}

require("guiao-c.php");

if(!$ajax)
	require("bottom.php");

?>