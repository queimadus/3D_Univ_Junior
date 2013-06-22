<?php
$title = "Trabalhos - ";
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

if(!$ajax){
	require("top.php"); 
	require("header.php");
}

require("trabalhos-c.php");

if(!$ajax)
	require("bottom.php");

?>