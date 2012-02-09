<?php @ require_once ('includes/settings.php'); ?>
<?php @ require_once ('includes/custom.php'); ?>
<?php

$db = new Debaser($DBhost, $DBuser, $DBpass, $DBname);
$db->connect();

// check our gets
$offset = 0;

if(isset($_POST['tags']))
	$tags = $_POST['tags'];
else
	$tags = Array();

//display_postings($tags, $offset, 25, $linkid);
get_postings_data($tags, 0, 25, $db);

// close connection
$db->disconnect();

?>