<?php
include 'inc/db.php';
if(!isset($_GET['id'])) {
	header("Location: index.php");
}

$id = $_GET['id'];
$row = getPoll($id);
$userid = isSigned()?getUser($_SESSION['username'])->user_id: NULL;
if(isset($_POST['submit']) && isset($_POST['options'])) {
  if($row->type != 0) {
    switch($row->type) {
      case 1: if(ipCheck($row->pid)) {
              $_SESSION['flash'] = "<b class='text-danger'>You have already voted the poll from this IP</b>";
              header("Location: vote.php?id=$id");
              die;
            }
              break;
      case 2: if(cookieCheck($row->pid)) {
              $_SESSION['flash'] = "<b class='text-danger'>You have already voted the poll.</b>";
              header("Location: vote.php?id=$id");
              die;
      }
            break;
      case 3: if(!isSigned()) {
              $_SESSION['flash'] = "<b class='text-danger'>You must sign in to vote.</b>";
              header("Location: vote.php?id=$id");
              die;
            }
            elseif(userCheck($row->pid)) {
              $_SESSION['flash'] = "<b class='text-danger'>You have already voted.</b>";
              header("Location: vote.php?id=$id");
              die;
      }
              break;
    default: break;
    }
  }
  if($row->type != 0) {
    $stmt1 = $c->prepare("INSERT INTO typecheck (cookie, ip, uid, pid) VALUES(?,?,?,?)");
    $stmt1->bind_param('ssii', $_COOKIE['uid'], $_SERVER['REMOTE_ADDR'], $userid, $id);
    $stmt1->execute();
  }
	foreach($_POST['options'] as $option) {
		$stmt = $c->prepare("UPDATE poll_options SET count=count+1 WHERE opid=?");
		$stmt->bind_param('i', $option);
		$stmt->execute();
		$stmt->close();
	}
	$_SESSION['flash'] = "You have successfully voted the poll.".$c->error;
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
  			<h6><i class="fui-question-circle"></i> <?=$row->question?></h6>
        <hr>
  			<?php
        if(!(($row->type==1 && ipCheck($row->pid) ||
          ($row->type==2 && cookieCheck($row->pid)) ||
          ($row->type==3 && (!isSigned() || userCheck($row->pid))))))  {
            include('inc/voteform.php');
        }
        ?>
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
  				<small class="label label-danger"><?=getPollType($row->type)?></small><br>
          <small>Created by: <?=isset(getUserById($row->uid)->username)?'<a href="profile.php?user='.getUserById($row->uid)->username.'">'.getUserById($row->uid)->username.'</a>': "ANONYMOUS";?></small>
  				<hr>
  				<?php include('inc/comments.php'); ?>
  		</div>
	</div>
<?php endif; ?>
<?php include 'inc/footer.php';?>