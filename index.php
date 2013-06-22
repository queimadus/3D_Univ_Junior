<?php
$title = "";
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

if(!$ajax){
	include("top.php"); 
	include("header.php");
}

include("index-c.php");

if(!$ajax)
	include("bottom.php");

?>