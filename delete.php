<?php require('includes/db.php'); ?>
<?php

$id = "0";
$user = "";

if(isset($_POST['id']) && isset($_POST['user'])) {

	$postid = $_POST['id'];
	$supplied_email = $_POST['user'];
	$result = DEBASER::select("SELECT id,email FROM postings WHERE id=$postid LIMIT 1");
	
	//check if email matches id
	$actual_email = $result[0]["email"];
	echo strcmp($actual_email, $supplied_email)." [".$supplied_email."][".$actual_email."]";
	if (strcmp($actual_email, $supplied_email) == 0) {
		$w_result = DEBASER::write("DELETE FROM postings WHERE id=$postid");
		if($w_result == 1) {
			echo "succesful delete";
		} else {
			echo "delete fail";
		}
	} else {
		echo "email mismatch";
	}

	DEBASER::disconnect();
}

?>