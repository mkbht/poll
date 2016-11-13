<?php
require 'inc/db.php';
$sitename = siteName();
/*if(isSigned()) {
header("Location: index.php");
die;
}
 */

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$sitename?> - Sign In</title>
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
		  			<div class="login-heading"><i class="fui-exit"></i> SIGN IN</div>
		  			<div class="login-form">
		  			<!-- error display -->
		  			<?=isset($_SESSION['flash_msg']) ? '<small class="text-danger">' . $_SESSION['flash_msg'] . '</small>' : '';
unset($_SESSION['flash_msg']);?>

		  				<form method="post" action="loginHandler.php">
				            <div class="form-group">
				              <input type="text" class="form-control login-field" value="" placeholder="Username" id="login-name" name="username" />
				              <label class="login-field-icon fui-user" for="login-name"></label>
				            </div>

				            <div class="form-group">
				              <input type="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" name="password" />
				              <label class="login-field-icon fui-lock" for="login-pass"></label>
				            </div>

				            <button class="btn btn-danger btn-lg btn-block" type="submit" name="submit">Log in</button>
				            <a class="login-link" href="lost-password.php">Lost your password?</a>
				        </form>
		  			</div>
		  			<div class="login-footer">
		  				<a class="login-link" href="signup.php">Signup for free</a>
		  			</div>
	  			</div>
	  		</div>
	  	</div>
	</main>
	<footer class="text-center">
		&copy; <?=date('Y')?> <?=siteName()?><br>
		All rights reserved
	</footer>
</body>
</html>