<?php
require('inc/db.php');
$id = isset($_GET['id'])?$_GET['id']:'';
if(count(getUserById($id)) > 0) {
	if(getUserById($id)->username == $_SESSION['username']) {
		echo 'You cannot delete yourself.';
	}
	else {
		$stmt = $c->prepare("DELETE FROM users WHERE user_id=?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		echo 'User deleted successfully';
	}
}
else {
	echo "Operation Failed!";
}
?>