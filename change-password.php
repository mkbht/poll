<?php
require 'inc/db.php';
if(!isSigned()) {
	header('Location: index.php');
	die;
}
$title = "Change password";
if(isset($_POST['submit'])) {
	$oldpassword = $_POST['oldpassword'];
	$newpassword = $_POST['newpassword'];
	$confirmpassword = $_POST['confirmpassword'];
	if(strlen($newpassword) < 6) {
		$_SESSION['flash'] = "<b class='text-danger'>Password must be at least 6 characters long.</b>";
		header("Location: change-password.php");
		die;
	}
	if(password_verify($oldpassword, $user->password)) {
		if($newpassword == $confirmpassword) {
			$stmt = $c->prepare("UPDATE users SET password=? WHERE username=?");
			$stmt->bind_param('ss', password_hash($newpassword,PASSWORD_DEFAULT), $user->username);
			$stmt->execute();
			$_SESSION['flash'] = "Password updated successfully.";
			header("Location: change-password.php");
			die;
		}
		else {
			$_SESSION['flash'] = "<b class='text-danger'>Confirm password do not match.</b>";
			header("Location: change-password.php");
			die;
		}
	}
	else {
		$_SESSION['flash'] = "<b class='text-danger'>Password do not match.</b>";
		header("Location: change-password.php");
		die;
	}
}
include('inc/header.php');
?>
<div class="jumbotron">
	<?=isset($_SESSION['flash'])?'<div class="alert alert-info">'.$_SESSION['flash'].'</div>':'';
	unset($_SESSION['flash']);?>
	<form method="post" action="change-password.php">
		<label>Old Password</label>
		<input required type="password" class="form-control" name="oldpassword" placeholder="Enter your old password..">
		<label>New Password</label>
		<input required type="password" class="form-control" name="newpassword" placeholder="Enter your new password..">
		<label>Confirm Password</label>
		<input required type="password" class="form-control" name="confirmpassword" placeholder="Renter your password..">
		<br>
		<button type="submit" name="submit" class="btn btn-inverse">Update</button>
	</form>
	<br>
	<a href="profile.php">Back to profile</a>
</div>
<?php include('inc/footer.php'); ?>
