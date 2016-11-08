<?php
require('inc/db.php');
if(isSigned()) {
	if(isset($_POST['submit'])) {
		$pid = $_POST['pid'];
		$comment = htmlspecialchars($_POST['comment']);
		if(empty($_POST['comment'])) {
			$_SESSION['comment_flash'] = "Empty comment!";
			header("Location: vote.php?id=$pid#comment");
			die;
		}
		
		$user_id = $user->user_id;
		if(pollExists($pid)) {
			$stmt = $c->prepare("INSERT INTO comments(comment,pid,user) VALUES(?,?,?)");
			$stmt->bind_param('sii', $comment, $pid, $user);
			$stmt->execute();
			$_SESSION['comment_flash'] = "Comment posted successfully";
			header("Location: vote.php?id=$pid#comment");
		}
		else {
			print_r($_POST);
			//header("Location: index.php");
		}
	}
	else {
		die("Access denied");
	}
}
else {
	die("Access denied");
}