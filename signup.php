<?php
	require_once('inc/db.php');
	if(isset($_POST['submit'])) {
		$username 	= strtolower($_POST['username']);
		$password 	= $_POST['password'];
		$first_name	= $_POST['first_name'];
		$last_name 	= $_POST['last_name'];
		$email 		= $_POST['email'];
		$gender 	= $_POST['gender'];
		$country 	= $_POST['country'];


		$username_exists = $c->query("SELECT * FROM users WHERE username='{$c->escape_string($username)}'");
		$email_exists = $c->query("SELECT * FROM users WHERE email='{$c->escape_string($email)}'");

		if(empty($username) OR empty($password) OR empty($first_name) OR empty($last_name) OR empty($email) OR empty($gender) OR empty($country)) {
			$error = "All fields are mandatory.";
		}
		elseif(strlen($username) < 6 ) {
			$error = "Username must be at least 6 characters long.";
		}
		elseif(strlen($password) < 6 ) {
			$error = "Password must be at least 6 characters long.";
		}
		elseif(!preg_match('/^[a-z][a-z0-9\_\-]+$/', $username)) {
			$error = "Username must start with alphabet and can consist alphanumeric characters , dashes(-) and underscores(_).";
		}
		elseif($username_exists->num_rows > 0) {
			$error = "Username already exists. Please select another username.";
		}
		elseif($email_exists->num_rows > 0) {
			$error = "Email Address already in use.";
		}
		else {
			$query = $c->prepare("INSERT INTO users (username, password, first_name, last_name, email, gender, country) VALUES (?,?,?,?,?,?,?)");
			$query->bind_param('sssssss', $username, $password_hash, $first_name, $last_name, $email, $gender, $country);
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			$query->execute();
			$_SESSION['username'] = $username;
			header('Location: index.php');
			}
		}
	?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=siteName()?> - Sign Up</title>
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
		  			<div class="login-heading"><i class="fui-plus"></i> SIGN UP</div>
		  			<div class="login-form">
		  			<!-- error display -->
		  			<?=isset($error) ? '<small class="text-danger">' . $error . '</small>' : ''; ?>

		  				<form method="post">
				            <div class="form-group">
				              <input type="text" class="form-control login-field" value="" placeholder="Username" id="login-name" name="username" />
				              <label class="login-field-icon fui-user" for="login-name"></label>
				            </div>

				            <div class="form-group">
				              <input type="password" class="form-control login-field" value="" placeholder="Password" id="login-pass" name="password" />
				              <label class="login-field-icon fui-lock" for="login-pass"></label>
				            </div>

				            <div class="form-group">
				              <input type="email" class="form-control login-field" value="" placeholder="Email" id="login-email" name="email" />
				              <label class="login-field-icon fui-mail" for="login-email"></label>
				            </div>

				            <div class="form-group">
				              <input type="text" class="form-control login-field" value="" placeholder="First Name" id="login-fname" name="first_name" />
				              <label class="login-field-icon fui-new" for="login-fname"></label>
				            </div>

				            <div class="form-group">
				              <input type="text" class="form-control login-field" value="" placeholder="Last Name" id="login-lname" name="last_name" />
				              <label class="login-field-icon fui-new" for="login-lname"></label>
				            </div>

				            <b>Gender</b>
				            <label class="radio">
				            	<input type="radio" name="gender" value="male" checked> Male
				            </label>
				            <label class="radio">
				            	<input type="radio" name="gender" value="female"> Female
				            </label>

				            <div class="form-group">
				            	<select name="country" id="country" class="form-control select select-inverse select-block">
				            	  <option value="">Choose your country</option>
				            	  <option value="Nepal">Nepal</option>
				            	</select>
				              <label class="login-field-icon fui-location" style="background: #34495E" for="country"></label>
				            </div>
				            

				            <button class="btn btn-danger btn-lg btn-block" type="submit" name="submit">Signup</button>
				        </form>
		  			</div>
		  			<div class="login-footer">
		  				<a class="login-link" href="login.php">Sign In</a>
		  			</div>
	  			</div>
	  		</div>
	  	</div>
	</main>
	<br>
	<footer class="text-center">
		&copy; <?=date('Y')?> <?=siteName()?><br>
		All rights reserved
	</footer>

	<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
<script src="dist/js/vendor/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="dist/js/vendor/video.js"></script>
<script src="dist/js/flat-ui.min.js"></script>
<script src="dist/js/script.js"></script>

</body>
</html>