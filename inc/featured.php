<?php $row = featured_poll();
	if(count((array) $row) > 0):
?>
<div class="col-md-8 col-md-offset-2 panel panel-default jumbotron tile" style="text-align:left">
	<div class="panel-body">
	<img src="dist/img/icons/svg/ribbon.svg" alt="ribbon" class="tile-hot-ribbon">
	<!-- <div class="tile-hot-ribbon">hello</div> -->
		<div>
			<form method="post" action="vote.php?id=<?=$row->pid?>">
				<h6><?=$row->question?></h6>
				<hr>
				<ul class="options">
				<?php $options = $c->query("SELECT * FROM poll_options WHERE pid='{$row->pid}'");
				if(!$row->multiple) {
					while($option = $options->fetch_assoc()) {
						echo <<<HTML
						<li>
							<label class="radio pull-left">
								<input type="radio" name="options[]" value="{$option['opid']}"> {$option['answer']}
							</label>
						</li>
HTML;
					}
				}
				else {
					while($option = $options->fetch_assoc()) {
						echo <<<HTML
						<li>
							<label class="checkbox pull-left">
								<input type="checkbox" name="options[]" value="{$option['opid']}"> {$option['answer']}
							</label>
						</li>
HTML;
					}
				}
				?>
				<li class="clearfix"></li>
				</ul>
				<hr>
				<div class="col-md-10 col-md-offset-1">
					<button type="submit" name="submit" class="col-md-6 text-center btn btn-wide btn-primary">Vote</button>
					<a href="vote.php?id=<?=$row->pid?>" class="col-md-6 btn btn-wide btn-inverse">View Result</a>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>
