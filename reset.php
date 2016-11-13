<?php
require 'inc/db.php';
if(isset($_GET['key'])) {
	$key = $c->escape_string(trim($_GET['key']));
	$q = $c->query("SELECT * FROM reset_password WHERE hash='$key'");
	$count = $q->num_rows;
	if(empty($key)) {
		echo "<h3 class='text-danger'>Invalid request</h3>";
		die;
	}
	elseif($count == 0) {
		echo "<h3 class='text-danger'>Invalid key request</h3>";
		die;
	}
	elseif($count == 1) {
		$u = (object) $q->fetch_assoc();
		if(isset($_POST['submit'])) {
			$password = $_POST['password'];
			$confirm = $_POST['confirm'];
			if(strlen($password) < 6) {
				$msg = "<b class='text-danger'>Password must be at least 6 characters long.</b>";
			}
			elseif($password != $confirm) {
				$msg = "<b class='text-danger'>Confirm password mismatched.</b>";
			}
			else {
				$stmt = $c->prepare("UPDATE users set password=? WHERE username=?");
				$stmt->bind_param('ss', password_hash($password, PASSWORD_DEFAULT), $u->user);
				$stmt->execute();
				$c->query("DELETE FROM reset_password WHERE hash='$key'");
				$_SESSION['flash_msg'] = "Password updated successfully.";
				unset($_SESSION['username']);
				header("Location: signin.php");
				die;
			}
		}
	}
	else {
		"<b class='text-danger'>Unknown error occurred.</b>";
		die;
	}
}
else {
	echo "<h3>Invalid Page</h3>";
	die;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=siteName()?> - Reset password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="dist/css/flat-ui.min.css" rel="stylesheet">

    <!-- loading custom stylesheet -->

    <link href="dist/css/style.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/vendor/html5shiv.js"></script>
      <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<header>
		<div class="text-center">
			<h3 class="site-title"><?=siteName()?></h3>
		</div>
	</header>
	<main>
	  	<div class="container-fluid">
	  		<div class="col-md-4 col-md-offset-4">
	  			<div class="signin">
		  			<div class="login-heading"><i class="fui-question-circle"></i> RESET PASSWORD</div>
		  			<div class="login-form">
		  			<!-- error display -->
		  			<?=isset($msg) ? '<div class="alert alert-info">' . $msg . '</div>' : '';?>

		  				<form method="post" action="reset.php?key=<?=$key?>">
				            <div class="form-group">
				              <input required type="password" class="form-control login-field" value="" placeholder="Enter Password" id="password" name="password" />
				              <label class="login-field-icon fui-lock" for="password"></label>
				            </div>
				             <div class="form-group">
				              <input required type="password" class="form-control login-field" value="" placeholder="Confirm Password" id="cpassword" name="confirm" />
				              <label class="login-field-icon fui-lock" for="cpassword"></label>
				            </div>
				            <button class="btn btn-danger btn-lg btn-block" type="submit" name="submit">RESET</button>
				        </form>
		  			</div>
		  			<div class="login-footer">
		  				<a class="login-link" href="signin.php">Sign in</a>
		  			</div>
	  			</div>
	  		</div>
	  	</div><br>
	</main>
	<footer class="text-center">
		&copy; <?=date('Y')?> <?=siteName()?><br>
		All rights reserved
	</footer>
</body>
</html>