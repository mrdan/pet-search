<?php require('includes/db.php'); ?>
<?php

//send a generic message for now
if(isset($_POST['id']) && isset($_POST['from']) && isset($_POST['content'])) {

	$id = $_POST['id'];
	$message = $_POST['content'];

	$from = filter_var($_POST["from"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($from, FILTER_VALIDATE_EMAIL)) { 
        echo "mail fail"; 
        return;
    }

	$result = DEBASER::write("INSERT INTO messages(postingid,content,sender) VALUES ($id,'$message','$from')");

	//check $result ( should be number of affected rows; 1 in this case)
	if($result != 1) {
		echo "mail fail";
		return;
	}
	else
		echo "I added an email to [".$to."] from [".$from."] saying [".$message."] to the db" ;

} else
	echo "mail fail";

DEBASER::disconnect();
?>