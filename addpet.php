<?php @ require_once ('includes/settings.php'); ?>
<?php @ require_once ('includes/db.php'); ?>
<?php

$db = new Debaser($DBhost, $DBuser, $DBpass, $DBname);
$db->connect();

//check and process $_POST
if(isset($_POST["tags"]) && isset($_POST["email"]) && isset($_POST["photo"])) {
	$tags = $_POST["tags"];
	$tags_arr  = explode(" ", $_POST["tags"]);
	$photo = $_POST["photo"];
	$email = $_POST["email"];

    //put any new tags into tags table
    for ($i=0; $i < count($tags_arr); $i++) { 
    	$tagsql = "INSERT INTO tags(tag) VALUES ('$tags_arr[$i]')";
    	$db->write($tagsql);
    }

    //TODO: sanitise / check vars
	//
    $sql = "INSERT INTO postings(tags,photo,email) VALUES('$tags', '$photo', '$email')";
   
	$db->write($sql);
    
    echo 'all done. bye bye.';
    $old = "/var/www/pet-search/tmp/".$photo;
    $new = "/var/www/pet-search/uploads/".$photo;
    rename($old, $new); //TODO: file not found? user must have dawdled and the tmp file got deleted. make them reupload.
}
$db->disconnect();
?>