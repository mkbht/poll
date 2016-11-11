<?php
$c = new mysqli('localhost', 'root', 'dadagiri2', 'poll');
	if($c->connect_error) {
		die($c->connect_error);
	}
	if(isSigned()) {
		$user = getUser($_SESSION['username']);
	}