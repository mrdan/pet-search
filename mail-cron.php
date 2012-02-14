<?php require('includes/db.php'); ?>
<?php

	$starttime = time();
	echo "-----------------------------",PHP_EOL;
	echo "Mail Cron - ".date("d-m-Y H:i:s").PHP_EOL;
	echo "-----------".PHP_EOL;

	$our_address 	= "noreply@pet-search.ie";
	$subject 		= "Message from pet-search.ie concerning your ad";
	$body			= "Hi, a user on pet-search.ie has sent you this message: ";
	$body2			= "Please either reply to this message or email the user at ";

	echo "Looking for messages to process...".PHP_EOL;
	$result = DEBASER::select("SELECT messages.id,postings.email, content, sender FROM messages, postings WHERE (postings.id = postingid)");

	// check $result to make sure we got something
	if($result) {
		foreach($result as $row) {
			$messageid = $row['id'];
			$content = $row['content'];
			$headers = 'From: $our_address' . "\r\n" .'Reply-To: $row["sender"]' . "\r\n" .'X-Mailer: PHP/' . phpversion();
			$message = $body.$content.$body2.$row['sender'];

			echo "Message [".$messageid."] From [".$row['sender']."] To [".$row['email']."] sent and deleted from database".PHP_EOL;

			// if(mail($to, $subject, $message, $headers))
			/*if(true)
				DEBASER::write("DELETE FROM messages WHERE id=$messageid"); //TODO: check result
			else
				continue;*/
		}
	} else
		echo "none".PHP_EOL;

	echo PHP_EOL."Looking for orphaned messages...".PHP_EOL;
	// Garbage collection, in which we find messages whose post doesn't exist any more and remove them
	$result2 = DEBASER::select("SELECT id FROM messages WHERE (SELECT COUNT(id) FROM postings WHERE id = messages.postingid) = 0");
	// check $result2 to make sure we got something
	if($result2) {
		foreach ($result2 as $row) {
			$id = $row['id'];
			DEBASER::write("DELETE FROM messages WHERE id=$id"); //TODO: check result
		}
	} else
		echo "none".PHP_EOL;

	$endtime = time();
	$totaltime = $endtime - $starttime;
	echo "-----------".PHP_EOL;
	echo "Processing time -  ".$totaltime." seconds".PHP_EOL;
	echo "-----------------------------".PHP_EOL;
	echo PHP_EOL;
?>