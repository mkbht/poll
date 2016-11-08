<?php $row = featured_poll();
	if(count((array) $row) > 0):
?>
<br><br>
<div class="panel panel-default tile">
	<div class="panel-body">
	<img src="dist/img/icons/svg/ribbon.svg" alt="ribbon" class="tile-hot-ribbon">
	<!-- <div class="tile-hot-ribbon">hello</div> -->
		<div class="center">
			<form method="post" action="vote.php?id=<?=$row->pid?>">
				<h6><?=$row->question?></h6>
				<hr>
				<ul class="options">
				<?php $options = $c->query("SELECT * FROM poll_options WHERE pid='{$row->pid}'");
				if(!$row->multiple) {
					while($option = $options->fetch_assoc()) {
						echo <<<HTML
						<li>
							<label class="radio">
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
							<label class="checkbox">
								<input type="checkbox" name="options[]" value="{$option['opid']}"> {$option['answer']}
							</label>
						</li>
HTML;
					}
				}
				?>
				</ul>
				<hr>
				<button type="submit" name="submit" class="btn btn-wide btn-primary">Vote</button>
				<a href="vote.php?id=<?=$row->pid?>" class="btn btn-wide btn-inverse">View Result</a>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>