<?php
include 'inc/db.php';
include 'inc/class.uploader.php';
if(isset($_POST['submit'])) {
	// uploader 
	$uploader = new Uploader();
    $data = $uploader->upload($_FILES['files'], array(
    		"limit" => 10,
    		"maxSize" => 1,
    		"extensions" => ['jpg', 'png', 'gif'],
    		"uploadDir" => "uploads/",
    		"title" => "auto"
    	));
    if($data['hasErrors']) {
    	$_SESSION['flash_msg'] = "Failed to upload files";
    	header("Location: index.php");
    	die;
    }

	$question = htmlspecialchars($_POST['question']);
	$type= $_POST['type'];
	$comments = isset($_POST['comments']) && isSigned() ? $_POST['comments'] : 0;
	$spam = isset($_POST['spam']) ? $_POST['spam']:0;
	$multiple = isset($_POST['multiple']) ? $_POST['multiple'] : 0;
	$isvisible = isset($_POST['isvisible']) && isSigned() ? $_POST['isvisible'] : 0;
	$postoptions = explode(',', $_POST['options']);
	$userid = isSigned()? $user->user_id: NULL;
	$total = count($data['data']['files']);
	if($total > 0) {
    	if($total < 2) {
    		$_SESSION['flash_msg'] = "At least two files are required";
    		unlink($data['data']['files'][0]);
    		header("Location: index.php");
    		die;
    	}
    	else {
    		$options = [];
    		foreach($data['data']['files'] as $img) {
    			array_push($options, '<img src="'.$img.'" class="img img-responsive img-rounded" style="max-width: 200px; max-height: 200px">');
    		}
    	}
    }
    else {
    	$options = [];
    	foreach($postoptions as $option) {
    		array_push($options, htmlspecialchars($option));
    	}
    }
	if(empty($_POST['question'])) {
		$_SESSION["flash_msg"] = "Question is empty";
    	header("Location: index.php");
    	die;
	}
	elseif(count($options) < 2 && $total == 0) {
		$_SESSION["flash_msg"] = "At least two options are required";
    	header("Location: index.php");
    	die;
	}
	else {
		$stmt = $c->prepare("INSERT INTO poll_list (question, type, comments, spam_prevention, multiple, isvisible, uid) VALUES(?,?,?,?,?,?,?)");
		$stmt->bind_param('siiiiii',$question, $type, $comments, $spam, $multiple, $isvisible, $userid);
		$stmt->execute();
		$stmt->close();
		$pid = $c->insert_id;
		foreach($options as $option) {
			$option = $option;
			$stmt = $c->prepare("INSERT INTO poll_options (answer, pid) VALUES(?,?)");
			$stmt->bind_param('si',$option, $pid);
			$stmt->execute();
		}
		header("Location: vote.php?id=$pid");
	}
}
?>