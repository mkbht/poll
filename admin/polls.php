<?php
require 'inc/db.php';
$title = "Poll Lists";
include 'inc/header.php';
?>
<div id="message"></div>
<table id="grid-poll" class="table table-condensed table-hover table-striped">
    <thead>
	    <tr>
	        <th data-column-id="id" data-identifier="true" data-type="numeric" data-width="60">ID</th>
	        <th data-column-id="username" data-order="asc">Question</th>
	        <th data-column-id="name">Created by</th>
	        <th data-column-id="link" data-formatter="link" data-sortable="false">Actions</th>
	    </tr>
	</thead>
	<tbody>
	<?php
		$result = $c->query("SELECT poll_list.*,users.username as username FROM poll_list LEFT JOIN users on `users`.user_id=`poll_list`.uid");
		while($row = $result->fetch_assoc()):
	?>
	    <tr data-row-id="<?=$row['pid'];?>">
	    	<td><?=$row['pid'];?></td>
	        <td><?=$row["question"]?></td>
	        <td><?=isset($row["username"])?$row["username"]:'ANONYMOUS'?></td>
	    </tr>
	<?php endwhile; ?>
	</tbody>
</table>
<?=count(array(array(), array()), COUNT_RECURSIVE)?>
<?php include 'inc/footer.php'; ?>