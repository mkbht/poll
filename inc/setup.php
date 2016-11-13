<?php
$c = new mysqli('localhost', 'root', '', 'poll');
	if($c->connect_error) {
		die($c->connect_error);
	}
	if(isSigned()) {
		$user = getUser($_SESSION['username']);
	}
	if(!isset($_COOKIE['uid'])) {
		setcookie("uid",md5($_SERVER['REMOTE_ADDR'].uniqid()),time()+31556926);
	}