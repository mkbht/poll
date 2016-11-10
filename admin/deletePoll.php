<?php
require('inc/db.php');
$id = isset($_GET['id'])?$_GET['id']:'';
if(count(getPoll($id)) > 0) {
		$stmt = $c->prepare("DELETE FROM poll_list WHERE pid=?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt = $c->prepare("DELETE FROM poll_options WHERE pid=?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		echo 'Poll deleted successfully';
	}
else {
	echo "Operation Failed!";
}
?>