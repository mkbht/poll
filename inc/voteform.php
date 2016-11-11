		<div class="center">
			<form method="post" action="vote.php?id=<?=$row->pid?>">
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
						</li> <br>
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
			</form>
		</div>