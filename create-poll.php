<?php
include 'inc/db.php';
include 'inc/class.uploader.php';
if(isset($_POST['submit'])) {
    //file upload
	$text = $_POST['text'];
    $file = $_FILES['file'];
    $countCaption = 0;
    $countFiles = 0;
    $allowed =  array('gif','png','jpeg','jpg');
    $success = false;
    $data['text'] = [];
    $data['image'] = [];
    for($i=0;$i<count($file['name']);$i++) {
        //count total caption
        if(!empty(trim($text[$i])) && $file['error'][$i] == 0)
            $countFiles++;
        elseif(empty(trim($text[$i])) && $file['error'][$i] == 0)
            $countFiles++;
        elseif(!empty(trim($text[$i])) && $file['error'][$i] == 4)
            $countFiles++;
        //check errors
        if($file['size'][$i] > 2000000) {
            $_SESSION['flash_msg'] = "<b class='text-danger'>File Limit exceeded. Maximum file size is 2MB</b>";
            header('Location: index.php');
            die;
        }

        if($file['error'][$i] != 0 && $file['error'][$i] != 4) {
            $_SESSION['flash_msg'] = "<b class='text-danger'>Failed to upload file. Server Error.</b>";
            header('Location: index.php');
            die;
        }

        $filename = basename($file['name'][$i]);
        $ext = pathinfo(strtolower($filename), PATHINFO_EXTENSION);
        if($file['error'][$i] == 0) {
        if(!in_array($ext, $allowed) ) {
            $_SESSION['flash'] = "<b class='text-danger'>Invalid file types. Only jpg, gif and png are allowed.</b>";
            header('Location: index.php');
            die;
        }
    }

        if(!empty($text[$i]) || $file['error'][$i] == 0) {
            $data['image'][] = $file['tmp_name'][$i];
            $data['text'][] = $text[$i];
        }

        $success = true;
    }
    // echo "<pre>";
    // print_r($data['image']);
    // die;

	$question = htmlspecialchars($_POST['question']);
	$type= $_POST['type'];
	$comments = isset($_POST['comments']) && isSigned() ? $_POST['comments'] : 0;
	$spam = isset($_POST['spam']) ? $_POST['spam']:0;
	$multiple = isset($_POST['multiple']) ? $_POST['multiple'] : 0;
	$isvisible = isset($_POST['isvisible']) && isSigned() ? $_POST['isvisible'] : 0;
	$userid = isSigned()? $user->user_id: NULL;
	if($countFiles < 2) {
            $_SESSION['flash_msg'] = "<b class='text-danger'>At least two options are required.</b>";
            header('Location: index.php');
            die;
    }
    else {
    	$options = [];
    	foreach($data['text'] as $option) {
    		array_push($options, htmlspecialchars($option));
    	}
    }
	if(empty($_POST['question'])) {
		$_SESSION["flash_msg"] = "<b class='text-danger'>Question is empty</b>";
    	header("Location: index.php");
    	die;
	}
	
	if($success==true) {
		$stmt = $c->prepare("INSERT INTO poll_list (question, type, comments, spam_prevention, multiple, isvisible, uid) VALUES(?,?,?,?,?,?,?)");
		$stmt->bind_param('siiiiii',$question, $type, $comments, $spam, $multiple, $isvisible, $userid);
		$stmt->execute();
		$stmt->close();
		$pid = $c->insert_id;
        for($i=0;$i<count($options);$i++) {
            $path = 'uploads/'.fileName(20).'.'.$ext;
            //inserting image
            if($data['image'][$i] == '')
                $option = "{$options[$i]}";
            else {
                move_uploaded_file($data['image'][$i], $path);
                $option = "<img src='$path' style='max-width:200px;max-height:200px'><br>{$options[$i]}";
            }
			$stmt = $c->prepare("INSERT INTO poll_options (answer, pid) VALUES(?,?)");
			$stmt->bind_param('si',$option, $pid);
			$stmt->execute();
		}
		header("Location: vote.php?id=$pid");
	}
}
?>