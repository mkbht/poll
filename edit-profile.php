<?php
require 'inc/db.php';
if(!isSigned()) {
	header('Location: index.php');
	die;
}
$title = "Edit Profile";
if(isset($_POST['submit'])) {
	$fname = htmlspecialchars($_POST['fname']);
	$lname = htmlspecialchars($_POST['lname']);
	$gender = htmlspecialchars($_POST['gender']);
	if(empty($fname) || empty($lname)) {
		$msg = "<b class='text-danger'>Fields cannot be empty.</b>";
	}
	else {
		$stmt = $c->prepare("UPDATE users SET first_name=?,last_name=?,gender=? WHERE username=?");
		$stmt->bind_param('ssss', $fname, $lname, $gender, $user->username);
		$stmt->execute();
		$msg = "Profile updated successfully";
	}
}
include('inc/header.php');
?>
<div class="jumbotron">
	<?=isset($msg)?'<div class="alert alert-info">'.$msg.'</div>':''?>
	<form method="post" action="edit-profile.php">
		<label>First Name</label>
		<input type="text" class="form-control" name="fname" value="<?=$user->first_name?>">
		<label>Last Name</label>
		<input type="text" class="form-control" name="lname" value="<?=$user->last_name?>">

		<label class="radio">
			<input type="radio" name="gender" value="male" <?=$user->gender=='male'?'checked': ''?>> Male
		</label>
		<label class="radio">
			<input type="radio" name="gender" value="female" <?=$user->gender=='female'?'checked': ''?>> Female
		</label>
		<button type="submit" name="submit" class="btn btn-inverse">Update</button>
	</form>
	<br>
	<a href="profile.php">Back to profile</a>
</div>
<?php include('inc/footer.php'); ?>
