<?php
	session_start();
	include '../inc/functions.php';
	include '../inc/setup.php';
	if(!isSigned() || !isAdmin()) {
		echo "You cannot access this page.";
		die;
	}
	
?>