<?php 
require 'inc/db.php';
$q = isset($_GET['q'])?$c->escape_string(trim($_GET['q'])):'';
$title = isset($q)? $q .' - Search': 'Search';
include 'inc/header.php';
?>
<h5>Search Results: <?=$q?></h5>
<div class="jumbotron">
<?php
if(empty($q)) {
		echo "<h4 class='text-danger text-center'>Search keyword is empty.</h4>";
	}
else {
	// source inclusion
	require_once 'pagination/Pagination.class.php';

	// determine page (based on <_GET>)
	$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

	// instantiate; set current page; set number of records
	$pagination = (new Pagination());
	$pagination->setCurrent($page);
	
	$q = trim($c->escape_string($_GET['q']));
	$offset = ($page*-1)*10;
	$query = "SELECT user_id as id, username as text , 'user' as type FROM users WHERE username LIKE '%$q%'
		UNION SELECT pid as id, question as text , 'poll' as type FROM poll_list WHERE question LIKE'%$q%' 
		ORDER BY type,text LIMIT 0,10";
	$result = $c->query($query);
	if($result->num_rows == 0) {
		echo "<h4 class='text-danger text-center'>No results found.</h4>";
	} else {
		$pagination->setTotal($result->num_rows);

		// grab rendered/parsed pagination markup
		$markup = $pagination->parse();
	while($rows = $result->fetch_assoc()) {
		if($rows['type'] == 'user') {
			echo "<h5><a href='profile.php?user=".$rows['text']."'>".$rows['text']."</a></h5>";
			echo "<label class='label label-danger'>user</label><hr>";
		}
		else {
			echo "<h5><a href='vote.php?id=".$rows['id']."'>".$rows['text']."</a></h5>";
			echo "<label class='label label-info'>poll</label><hr>";
		}
	}
	echo $markup;
}
}
?>
</div>
<?php include 'inc/footer.php';?>