<?php

// db setup
$DBhost = "127.0.0.1";
$DBuser = "pet_user";
$DBpass = "234rewf2";
$DBname = "petsearch";

$linkid = mysql_connect($DBhost,$DBuser,$DBpass);
if (!$linkid) {
    die("Unable to connect to database".mysql_error());
}
mysql_select_db($DBname,$linkid);

//check and process $_POST
if(isset($_POST["tags"]) && isset($_POST["email"]) && isset($_POST["photo"])) {
	$tags = $_POST["tags"];
	$tags_arr  = explode(" ", $_POST["tags"]);
	$photo = $_POST["photo"];
	$email = $_POST["email"];

    //put any new tags into tags table
    for ($i=0; $i < count($tags_arr); $i++) { 
    	$tagsql = "INSERT INTO tags(tag) VALUES ('$tags_arr[$i]')";
    	mysql_query($tagsql,$linkid);
    }

    //TODO: sanitise / check vars
	//

    $sql = "INSERT INTO postings(tags,photo,email) VALUES('$tags', '$photo', '$email')";
   
	if (!mysql_query($sql,$linkid)) {
		echo 'Error: ' . mysql_error(). '<BR />';
    } else {
    	echo 'all done. bye bye.';
    	$old = "/var/www/pet-search/tmp/".$photo;
    	$new = "/var/www/pet-search/uploads/".$photo;
    	rename($old, $new); //TODO: file not found? user must have dawdled and the tmp file got deleted. make them reupload.
    }
}
?>