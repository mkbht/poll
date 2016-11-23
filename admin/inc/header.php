<?php
  $sitename = "Poll"; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$sitename?> Admin Panel <?=isset($title)?' - '.$title:'';?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="../dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="../dist/css/flat-ui.min.css" rel="stylesheet">

    <!-- loading data table -->
    <link rel="stylesheet" type="text/css" href="../dist/css/jquery.bootgrid.min.css">

    <!-- font awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- loading custom stylesheet -->
    <style type="text/css">
      table {
        /*font-size: 16px*/
      }
    </style>

    <link href="../dist/css/style.css" rel="stylesheet">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/vendor/html5shiv.js"></script>
      <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<header>
<!-- navigation bar -->
  <nav class="navbar navbar-inverse navbar-fixed-top navbar-lg" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
          <span class="sr-only">Toggle navigation</span>
        </button>
        <a class="navbar-brand" href="index.php"><?=$sitename?> Admin Dashboard</a>
      </div>
      <!-- menu items -->
      <div class="collapse navbar-collapse" id="navbar-collapse-01">
        <ul class="nav navbar-nav navbar-right">

          <?php if(isSigned()): ?>
            <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$user->username?> <b class="caret"></b></a>
                  <span class="dropdown-arrow"></span>
                  <ul class="dropdown-menu">
                    <li><a href="../index.php">Back to site</a></li>
                    <li class="divider"></li>
                    <li><a href="../logout.php">Logout</a></li>
                  </ul>
                </li>
          <?php endif;?>
         </ul>
         <!-- search form -->
          <div class="navbar-text"></div>
      </div><!-- /.navbar-collapse -->
    </nav><!-- /navbar -->
  </header>

  <main>
    <div class="container-fluid">
    <?php include('inc/leftpanel.php') ?>
      
