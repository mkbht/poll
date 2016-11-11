<?php
	session_start();
	error_reporting(0);
	include '../inc/functions.php';
	include '../inc/setup.php';
	if(!isSigned() || !isAdmin()) {
		echo "You cannot access this page.";
		die;
	}
	
?>