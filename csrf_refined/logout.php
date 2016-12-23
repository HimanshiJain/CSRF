<?php 
	include_once("include/header.php");
	$username = $_COOKIE['username'];
	setcookie('username', "", time() - 3600,"/");
	setcookie('id', "", time() - 3600,"/");
	$db->update_cookie_in_database("",$username);
	header("Location: index.php");
	exit();	
?>