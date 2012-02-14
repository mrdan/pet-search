<?php require('includes/db.php'); ?>
<?php

$id = "0";

if(isset($_POST['id'])) {

	$id = $_POST['id'];
	$result = DEBASER::select("SELECT daterefreshed FROM postings WHERE id=$id LIMIT 1"); //TODO: Check $result
	$lastrefresh = $result[0]["daterefreshed"];

	$timestamp = strtotime($lastrefresh);

	if($timestamp < (time() - 24 * 60 * 60)) //more than a day ago
		DEBASER::write("UPDATE postings SET refreshed=refreshed+1 WHERE id=$id");

	DEBASER::disconnect();
}

?>