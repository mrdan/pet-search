<?php require('includes/db.php'); ?>
<?php

//check honeypot
if(isset($_POST['username']))
{
    echo "lol";
    var_dump($_POST['username']);
    die();
}

//check and process $_POST
if(isset($_POST["tags"]) && isset($_POST["email"]) && isset($_POST["photo"]) && !isset($_POST['username'])) {
	$tags = $_POST["tags"];
	$tags_arr  = explode(" ", $_POST["tags"]);
	$photo = $_POST["photo"];

    // clean the email address and check it
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        echo "Email fail"; 
        die();
    }

    //put any new tags into tags table
    for ($i=0; $i < count($tags_arr); $i++) { 
        $check_sql = "SELECT * FROM tags WHERE tag='$tags_arr[$i]' LIMIT 1"; //TODO: Limit SELECT
        $exists = DEBASER::select($check_sql);
        if(!$exists) {
    	   $tagsql = "INSERT INTO tags(tag) VALUES ('$tags_arr[$i]')";
    	   DEBASER::write($tagsql);
       }
    }

    //TODO: sanitise / check vars
	//
    $sql = "INSERT INTO postings(tags,photo,email) VALUES('$tags', '$photo', '$email')";
   
	DEBASER::write($sql);
    
    echo 'all done. bye bye.';
    $old = "/var/www/pet-search/tmp/".$photo;
    $new = "/var/www/pet-search/uploads/".$photo;
    rename($old, $new); //TODO: file not found? user must have dawdled and the tmp file got deleted. make them reupload.
    DEBASER::disconnect();
}
?>