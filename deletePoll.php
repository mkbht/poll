<?php
require('inc/db.php');
$id = isset($_GET['id'])?$_GET['id']:'';
if(count(getPoll($id)) > 0) {
		$stmt2 = $c->prepare("DELETE FROM poll_options WHERE pid=?");
		$stmt2->bind_param('i', $id);
		$stmt2->execute();
		$stmt3 = $c->prepare("DELETE FROM comments WHERE pid=?");
		$stmt3->bind_param('i', $id);
		$stmt3->execute();
		$stmt4 = $c->prepare("DELETE FROM typecheck WHERE pid=?");
		$stmt4->bind_param('i', $id);
		$stmt4->execute();
		$stmt1 = $c->prepare("DELETE FROM poll_list WHERE pid=?");
		$stmt1->bind_param('i', $id);
		$stmt1->execute();
		$_SESSION['flash'] = 'Poll deleted successfully';
		header("Location: profile.php");
		die;
	}
else {
	$_SESSION['flash'] = 'Operation Failed';
		header("Location: profile.php");
		die;
}
?>