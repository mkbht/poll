<?php
require('inc/db.php');
$id = isset($_GET['id'])?$_GET['id']:'';
if(count(getPoll($id)) > 0) {
		$stmt1 = $c->prepare("DELETE FROM poll_list WHERE pid=?");
		$stmt1->bind_param('i', $id);
		$stmt1->execute();
		$stmt2 = $c->prepare("DELETE FROM poll_options WHERE pid=?");
		$stmt2->bind_param('i', $id);
		$stmt2->execute();
		$stmt3 = $c->prepare("DELETE FROM comments WHERE pid=?");
		$stmt3->bind_param('i', $id);
		$stmt3->execute();
		echo 'Poll deleted successfully';
	}
else {
	echo "Operation Failed!";
}
?>