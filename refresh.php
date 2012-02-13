<?php require('includes/db.php'); ?>
<?php require('includes/custom.php'); ?>
<?php

$id = "0";

if(isset($_POST['id'])) {

	$id = $_POST['id'];
	$result = DEBASER::select("SELECT daterefreshed FROM postings WHERE id=$id");
	$lastrefresh = $result->fetchColumn();

	$timestamp = strtotime($lastrefresh);

	if($timestamp < (time() - 24 * 60 * 60)) //more than a day ago
		DEBASER::write("UPDATE postings SET refreshed=refreshed+1 WHERE id=$id");

	DEBASER::disconnect();
}

?>