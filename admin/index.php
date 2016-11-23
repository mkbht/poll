<?php
require 'inc/db.php';
$title = "Admin Panel Home";
include 'inc/header.php';
?>
<div id="message"></div>
<table id="grid" class="table table-condensed table-hover table-striped">
    <thead>
	    <tr>
	        <th data-column-id="id" data-identifier="true" data-type="numeric" data-width="60">ID</th>
	        <th data-column-id="username" data-order="asc">Username</th>
	        <th data-column-id="name">Name</th>
	        <th data-column-id="email">Email</th>
	        <th data-column-id="gender">Gender</th>
	        <th data-column-id="country">Country</th>
	        <th data-column-id="link" data-formatter="link" data-sortable="false">Actions</th>
	    </tr>
	</thead>
	<tbody>
	<?php
		$result = $c->query("SELECT * FROM users WHERE username!='admin'");
		while($row = $result->fetch_assoc()):
	?>
	    <tr data-row-id="<?=$row['user_id'];?>">
	        <td><?=$row["user_id"]?></td>
	        <td><?=$row["username"]?></td>
	        <td><?=$row["first_name"]." ".$row["last_name"]?></td>
	        <td><?=$row["email"]?></td>
	        <td><?=$row["gender"]?></td>
	        <td><?=$row["country"]?></td>
	    </tr>
	<?php endwhile; ?>
	</tbody>
</table>

<?php include 'inc/footer.php'; ?>