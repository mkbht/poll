<?php
require 'inc/db.php';
$siteurl = $_SERVER['HTTP_HOST'];
if(isset($_POST['submit'])) {
	$email = $c->escape_string(trim($_POST['email']));
	$q = $c->query("SELECT * FROM users WHERE email='$email'");
	$count = $q->num_rows;
	if(empty($email)) {
		$msg = "<b class='text-danger'>Field is empty</b>";
	}
	elseif($count == 0) {
		$msg = "<b class='text-danger'>Email does not exists.</b>";
	}
	elseif($count == 1) {
		$u = (object) $q->fetch_assoc();
		$h = $c->query("SELECT * FROM reset_password WHERE user='$u->username'");
		$result = (object) $h->fetch_assoc();
		$hash = $h->num_rows == 0 ? md5(uniqid()): $result->hash;
		if($h->num_rows == 0) {
			$stmt = $c->prepare("INSERT INTO reset_password (hash, user) VALUES(?,?)");
			$stmt->bind_param('ss', $hash, $u->username);
			$stmt->execute();
		}
		// mailing
		$to = $u->email;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: ".siteName()."<".strtolower(siteName())."@".$siteurl.">" . "\r\n";

		$subject = "Reset your password";
		$url = 'http://'.$siteurl.'/reset.php?key='.$hash;
		$msg = file_get_contents('http://'.$siteurl.'/inc/mail/resetPassword.html');
		$message = str_replace(['{{sitename}}', '{{username}}', '{{action_url}}'],
								[siteName(), $u->username, $url]);
		// $message = "Hello $u->username, <br>
		// 			Please click on the link to reset your password. <br>
		// 			<a href='http://{$siteurl}/reset.php?key=$hash'>http://{$siteurl}/reset.php?key=$hash</a>
		// 			<br>
		// 			Regards ".siteName();
		mail($to, $subject, $message, $headers);
		$msg = $message;
		//$msg = "A reset link has been sent to email. Follow the link to reset your password.";
	}
	else {
		"<b class='text-danger'>Unknown error occurred.</b>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=siteName()?> - Forgot password</title>
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
		  			<div class="login-heading"><i class="fui-question-circle"></i> FORGOT PASSWORD</div>
		  			<div class="login-form">
		  			<!-- error display -->
		  			<?=isset($msg) ? '<div class="alert alert-info">' . $msg . '</div>' : '';?>

		  				<form method="post" action="lost-password.php">
				            <div class="form-group">
				              <input required type="email" class="form-control login-field" value="" placeholder="Email" id="email" name="email" />
				              <label class="login-field-icon fui-mail" for="email"></label>
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