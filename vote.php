<?php
include 'inc/db.php';
if(!isset($_GET['id'])) {
	header("Location: index.php");
}

$id = $_GET['id'];
$row = getPoll($id);
if(isset($_POST['submit']) && isset($_POST['options'])) {
	foreach($_POST['options'] as $option) {
		$stmt = $c->prepare("UPDATE poll_options SET count=count+1 WHERE opid=?");
		$stmt->bind_param('i', $option);
		$stmt->execute();
		$stmt->close();
	}
	$_SESSION['flash'] = "You have successfully voted the poll.";
	header("Location: vote.php?id=$id");
	die;
}
?>
<?php 
	$title = isset($row->question) ? $row->question: "404 ERROR";
	include 'inc/header.php';?>

<?php if(count((array)$row) == 0): ?>
	<h3>Sorry the poll doesn't exists.</h3>
	<h4>Try this random poll instead.</h4>
	<?php include('inc/featured.php'); ?>

<?php else: ?>
	<div class="panel panel-default">
  		<div class="panel-body">
  			<?=isset($_SESSION['flash'])?'<div class="alert alert-success">'.$_SESSION['flash'].'</div>':'';unset($_SESSION['flash']); ?>
  			<h6 class="center"><?=$row->question?></h6>
  			<?php include('inc/voteform.php'); ?>
  			<h5>Statistics:</h5>
  			<hr>
  			<p>Total Votes: <?=totalVote($row->pid)->total; ?></p>
  			<?php foreach(getAllOptions($row->pid) as $option): ?>
  				<?=$option['answer']?> (<?=$option['count']?> votes)
  				<div class="progress">
  				  <div class="progress-bar" role="progressbar" aria-valuenow="<?=votePercent($option['count'],totalVote($row->pid)->total)?>"
  				  aria-valuemin="0" aria-valuemax="100" style="width: <?=votePercent($option['count'],totalVote($row->pid)->total)?>%">
  				    <?=votePercent($option['count'],totalVote($row->pid)->total)?>%
  				  </div>
  				</div>
          <br>

  			<?php endforeach; ?>
  				<hr>
  				<small class="label label-danger"><?=getPollType($row->type)?></small>
  				<hr>
  				<?php include('inc/comments.php'); ?>
  		</div>
	</div>
<?php endif; ?>
<?php include 'inc/footer.php';?>