<?php if($row->comments == 1): ?>
	<?php if(isSigned()): ?>
		<!-- paging -->
		<?php

		    // source inclusion
		    require_once 'pagination/Pagination.class.php';

		    // determine page (based on <_GET>)
		    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

		    // instantiate; set current page; set number of records
		    $pagination = (new Pagination());
		    $pagination->setCurrent($page);
		    $pagination->setTotal(count(getComments($row->pid)));

		    // grab rendered/parsed pagination markup
		    $markup = $pagination->parse();
		    ?>
		<div id="comment" class="well">
			<?=isset($_SESSION['comment_flash'])?'<span class="text-danger">'.$_SESSION['comment_flash'].'</span>':'';unset($_SESSION['comment_flash']); ?>
		<!-- </div> -->
		<!-- comment form -->
		<form method="post" action="post-comment.php">
			<div class="input-group">
	         	<input type="text" name="comment" class="form-control" placeholder="Write comment...">
				<input type="hidden" name="pid" value="<?=$row->pid?>">
	        	<span class="input-group-btn">
	        		<button class="btn btn-primary" type="submit" name="submit"><i class="fui-new"></i></button>
	        	</span>
	        </div>
	    </form>
	</div>

	    <!-- comment list -->
	    <div class="list-group">
	    <?php
	    $comments = getComments($row->pid,($page-1)*10,10);
	    foreach($comments as $comment): ?>
	    	<div class="list-group-item">
	    		<a class="text-primary" href="profile.php?user=<?=$comment['username']?>"><?=$comment['username']?></a>
	    		<blockquote class="text-midnight"><?=$comment['comment']?></blockquote>
	    		<p class="small text-grey">Posted on: <?=date('Y-m-d H:i a', time($comment['created_at']))?></p>
	    	</div>
		<?php endforeach; ?>
		<center><?=$markup?></center>
		</div>

	<?php else: ?>
	Please <a href="signin.php">Signin</a> or <a href="signup.php">Signup</a> to view and post comments.
<?php endif; ?>
<?php else: ?>
<?php endif; ?>