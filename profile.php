<?php
require('inc/db.php');
$title = isset($_GET['user'])?$_GET['user']: "Profile";
$username = isset($_GET['user'])?$c->escape_string($_GET['user']): "";

		    // source inclusion
		    require_once 'pagination/Pagination.class.php';

		    // determine page (based on <_GET>)
		    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

		    // instantiate; set current page; set number of records
		    $pagination = (new Pagination());
		    $pagination->setCurrent($page);

include('inc/header.php');
if(!isSigned() && !isset($_GET['user'])): ?>
	<div class="jumbotron">
		<center>
			<h3>Profile Not Found</h3>
		</center>
	</div>
	<?php include('inc/featured.php')?>
<?php elseif(!isset($_GET['user']) || $_GET['user'] == @$_SESSION['username']): ?>
	<?=isset($_SESSION['flash'])?'<div class="alert alert-info">'.$_SESSION['flash'].'</div>':'';
	unset($_SESSION['flash']); ?>
	<div class="jumbotron">
		<h3><?=$user->username?></h3>
		<hr>
		<p>Name: <?=$user->first_name.' '.$user->last_name?></p>
		<p>Gender: <?=$user->gender?></p>
		<p>Email: <?=$user->email?></p>
		<p>Country: <?=$user->country?></p>

		<a href="edit-profile.php" class='btn btn-danger btn-sm'>Edit profile</a>
		<a href="change-password.php" class='btn btn-inverse btn-sm'>Change password</a>
	</div>

	<b class="lead text-danger">My Polls</b>
	<div class="list-group">

	<?php
		$offset = ($page-1)*10;
		$query = $c->query("SELECT * FROM poll_list where uid='$user->user_id' LIMIT $offset,10");
		$count = $query->num_rows;
		    $pagination->setTotal($count);

		    // grab rendered/parsed pagination markup
		    $markup = $pagination->parse();
		    if($count == 0) {
		    	echo "<div class=\"lead center thumbnail\">No Polls</div>";
		    }
		while($polls = $query->fetch_assoc()):
	?>
		<div class="list-group-item">
			<a href="vote.php?id=<?=$polls['pid']?>"><?=$polls['question']?></a><br>
			<a href="deletePoll.php?id=<?=$polls['pid']?>" class="btn btn-danger btn-xs">Remove</a>
		</div>
	<?php endwhile; ?>
	</div>
	<?=$markup?>
<?php else: ?>
	<?php $u = getUser($username);
	if(count($u) == 0): ?>
		<div class="jumbotron">
			<center>
				<h3>Profile Not Found</h3>
			</center>
		</div>
		<?php include('inc/featured.php')?>
	<?php else:?>
	<div class="jumbotron">
		<h3><?=$u->username?></h3>
		<hr>
		<p>Name: <?=$u->first_name.' '.$u->last_name?></p>
		<p>Gender: <?=$u->gender?></p>
		<p>Country: <?=$u->country?></p>
	</div>

	<b class="lead text-danger"><?=$username?>'s Polls</b>
	<div class="list-group">
	<?php
		$offset = ($page-1)*10;
		$query = $c->query("SELECT * FROM poll_list where uid='$u->user_id' AND isvisible=1 LIMIT $offset,10");
		$count = $query->num_rows;
		$pagination->setTotal($count);

		    // grab rendered/parsed pagination markup
		    $markup = $pagination->parse();
		    if($count == 0) {
		    	echo "<div class=\"lead center thumbnail\">No Polls</div>";
		    }
		while($polls = $query->fetch_assoc()):
	?>
		<div class="list-group-item">
			<a href="vote.php?id=<?=$polls['pid']?>"><?=$polls['question']?></a>
		</div>
	<?php endwhile; ?>
	</div>
	<?=$markup?>
<?php endif; ?>
<?php endif; ?>
<?php include('inc/footer.php');?>