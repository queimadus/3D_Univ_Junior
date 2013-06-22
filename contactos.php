<?php
$title = "Contactos - ";
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

if(!$ajax){
	include("top.php"); 
	include("header.php");
}

include("contactos-c.php");

if(!$ajax)
	include("bottom.php");

?>