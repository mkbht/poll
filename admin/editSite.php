<?php
require 'inc/db.php';
if(isset($_POST["submit"])) {
	$sitename = $_POST["sitename"];
	$description = htmlspecialchars($_POST["description"]);
	$ad1 = $_POST["ad1"];
	$ad2 = $_POST["ad2"];
	$about = $_POST["about"];
	$privacy = $_POST["privacy"];
	$contact = $_POST["contact"];
	$stmt = $c->prepare("UPDATE site_details SET sitename=?,description=?, ad1=?, ad2=?, about=?, privacy=?, contact=?");
	$stmt->bind_param('sssssss', $sitename, $description, $ad1, $ad2, $about, $privacy, $contact);
	$stmt->execute();
	$msg = "Updated successfully";
}
?>
<?php
$title = "Edit Site";
include 'inc/header.php';
?>
<form method="post">
	<?=isset($msg)?'<div class="alert alert-info">'.$msg.'</div>':'';?>
	<label>Site Name</label>
	<input type="text" name="sitename" class="form-control" value="<?=siteName()?>" placeholder="Site Name">
	<label>Description</label>
	<textarea name="description" class="form-control"><?=siteDetails()->description?></textarea>
	<label>Ad code 1</label>
	<textarea name="ad1" class="form-control"><?=siteDetails()->ad1?></textarea>
	<label>Ad code 2</label>
	<textarea name="ad2" class="form-control"><?=siteDetails()->ad2?></textarea>
	<!-- about -->
	<label>About</label>
	<textarea name="about" class="form-control" rows="20"><?=siteDetails()->about?></textarea>
	<label>Privacy Policy</label>
	<textarea name="privacy" class="form-control" rows="20"><?=siteDetails()->about?></textarea>
	<label>Contact</label>
	<textarea name="contact" class="form-control" rows="20"><?=siteDetails()->about?></textarea>
	<br>
	<button type="submit" name="submit" class="btn btn-inverse">Update</button>
</form>
<?php include 'inc/footer.php'; ?>