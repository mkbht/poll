<?php
$title = "Home";
	include('inc/db.php');
	include('inc/header.php');
?>
  			<div class="panel panel-default">
  			<!-- <div class="panel-heading">
  				<h4 class="panel-title">Create a Poll</h4>
  			</div> -->
  				<div class="panel-body">
  				<h4>Create a Poll</h4>
          <?=isset($_SESSION["flash_msg"])?'<div class="alert alert-danger">'.$_SESSION["flash_msg"].'</div>': '';unset($_SESSION["flash_msg"]); ?>
  					<form action="create-poll.php" method="post" enctype="multipart/form-data">
  						<div class="input-group">
  						  <span class="input-group-addon">?</span>
  						  <input required type="text" class="form-control" placeholder="Type your question here" name="question" />
  						</div>
  						<h5>Options <small class="text-primary">(Separated with commas)</small></h5>
  						<div class="tagsinput-primary">
  							<input name="options" class="tagsinput" data-role="tagsinput" />
  						</div>
              or
              <!-- file input -->
              <input type="file" name="files[]" id="uploadform" multiple="multiple">

  						<label class="radio">
  							<input type="radio" name="type" value="0" checked> No duplication checking
  						</label>
  						<label class="radio">
  							<input type="radio" name="type" value="1"> IP duplication checking
  						</label>
  						<label class="radio">
  							<input type="radio" name="type" value="2"> Browser duplication checking
  						</label>
            <?php if(isSigned()): ?>
  						<label class="radio">
  							<input type="radio" name="type" value="3"> Signin Checking
  						</label>
  						<hr>
  						<label>
  							<b>Enable Comments:</b> <input type="checkbox" data-toggle="switch" name="comments" value="1">
  						</label>
            <?php endif; ?>
  						<hr>
  						<label class="checkbox">
  							<input type="checkbox" name="spam" value="1"> Improve spam prevention
  						</label>
  						<label class="checkbox">
  							<input type="checkbox" name="multiple" value="1"> Enable multiple answer
  						</label>
            <?php if(isSigned()): ?>
  						<label class="checkbox">
  							<input checked type="checkbox" name="isvisible" value="1"> Show on my profile
  						</label>
            <?php endif; ?>
  						<hr>
  						<!-- submit -->
  						<button type="submit" name="submit" class="btn btn-primary btn-wide">Create</button>
  						<button type="reset" class="btn btn-inverse btn-wide">Save Draft</button>
  						
  					</form>
  				</div>
  			</div>

  			<?php include('inc/featured.php');?>
<?php include('inc/footer.php'); ?>