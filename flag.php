<?php @ require_once ('includes/custom.php'); ?>
<?php

// 0 = default, -1 = protected (ie an admin allowed it), >0 = number of times reported
$id = "0";

if(isset($_POST['id'])) {

	$id = $_POST['id'];

	//check if id already exists
	$exists = DEBASER::select("SELECT * FROM flagged WHERE id=$id");
	
	if($exists->fetchColumn()) {
		//if it does check is protected
		foreach($exists as $post) {
			if($post['protected'] == 0)
				DEBASER::write("UPDATE flagged SET flags=flags+1 WHERE id=$id"); //if unprotected add 1 to flags
			echo "exists";
		}
	} else {
		echo "doesnt exist";
		//if it doesn't add it and add 1 to flags
		DEBASER::write("INSERT INTO flagged(id,flags) VALUES($id, 1)");
	}
	DEBASER::disconnect();
}

?>