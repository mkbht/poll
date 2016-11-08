<?php
include 'inc/db.php';
if(isset($_POST['submit'])) {
	$question = htmlspecialchars($_POST['question']);
	$type= $_POST['type'];
	$comments = isset($_POST['comments']) && isSigned() ? $_POST['comments'] : 0;
	$spam = isset($_POST['spam']) ? $_POST['spam']:0;
	$multiple = isset($_POST['multiple']) ? $_POST['multiple'] : 0;
	$isvisible = isset($_POST['isvisible']) && isSigned() ? $_POST['isvisible'] : 0;
	$options = explode(',', $_POST['options']);
	$userid = isSigned()? $user->user_id: NULL;
	if(empty($_POST['question'])) {
		echo "Question is empty";
	}
	elseif(count($options) < 2) {
		echo "At least two options are required";
	}
	else {
		$stmt = $c->prepare("INSERT INTO poll_list (question, type, comments, spam_prevention, multiple, isvisible, uid) VALUES(?,?,?,?,?,?,?)");
		$stmt->bind_param('siiiiii',$question, $type, $comments, $spam, $multiple, $isvisible, $userid);
		$stmt->execute();
		$stmt->close();
		$pid = $c->insert_id;
		foreach($options as $option) {
			$option = htmlspecialchars($option);
			$stmt = $c->prepare("INSERT INTO poll_options (answer, pid) VALUES(?,?)");
			$stmt->bind_param('si',$option, $pid);
			$stmt->execute();
		}
		header("Location: vote.php?id=$pid");
	}
}
?>