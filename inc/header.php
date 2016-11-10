<?php
  $sitename = siteName(); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$sitename?> <?=isset($title)?' - '.$title:'';?></title>
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
<!-- navigation bar -->
  <nav class="navbar navbar-inverse navbar-lg" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
          <span class="sr-only">Toggle navigation</span>
        </button>
        <a class="navbar-brand" href="index.php"><?=$sitename?></a>
      </div>
      <!-- menu items -->
      <div class="collapse navbar-collapse" id="navbar-collapse-01">
        <ul class="nav navbar-nav navbar-right">

          <?php if(isSigned()): ?>
          <?php if(isAdmin()): ?>
            <li><a href="admin/index.php">Admin Panel</a></li>
          <?php endif; ?>
            <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$user->username?> <b class="caret"></b></a>
                  <span class="dropdown-arrow"></span>
                  <ul class="dropdown-menu">
                    <li><a href="profile.php">My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php">Logout</a></li>
                  </ul>
                </li>
          <?php else: ?>
            <li><a href="signin.php">Sign in</a></li>
            <li><a href="signup.php">Sign up</a></li>
          <?php endif;?>
            <li><button class="btn btn-danger navbar-btn" type="button" onclick="window.location='index.php'"">Create Poll</button></li>
         </ul>
         <!-- search form -->
        <form class="navbar-form" action="#" role="search">
          <div class="form-group">
            <div class="input-group">
              <input class="form-control" id="navbarInput-01" type="search" placeholder="Search">
              <span class="input-group-btn">
                <button type="submit" class="btn"><span class="fui-search"></span></button>
              </span>
            </div>
          </div>
        </form>
      </div><!-- /.navbar-collapse -->
    </nav><!-- /navbar -->
  </header>

  <main>
    <div class="container">
    <center><img src="dist/img/ad2.jpg" class="img-responsive"></center>
    <br>
      <div class="col-md-7">
      
