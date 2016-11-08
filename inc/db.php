<?php
	session_start();
	include 'inc/functions.php';
	// global $c;
	$c = new mysqli('localhost', 'root', '', 'poll');
	if($c->connect_error) {
		die($c->connect_error);
	}
	if(isSigned()) {
		$user = getUser($_SESSION['username']);
	}
?>