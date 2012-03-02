<?php require('includes/db.php'); ?>
<?php require('includes/custom.php'); ?>
<?php

$success_string = 'all done. bye bye.';
//check honeypot
if(isset($_POST['username']))
{
    echo $success_string; // pretend it worked
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
        $check_sql = "SELECT * FROM tags WHERE tag='$tags_arr[$i]' LIMIT 1";
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
    
    echo $success_string;
    $old = "/var/www/pet-search/tmp/".$photo;
    $new = "/var/www/pet-search/uploads/".$photo;
    rename($old, $new); //TODO: file not found? user must have dawdled and the tmp file got deleted. make them reupload.
    DEBASER::disconnect();
}
?>
<HTML>
<HEAD><TITLE>Add Pet</TITLE>
<meta http-equiv="content-script-type" content="text/javascript">
<LINK type="text/css" rel="stylesheet" href="includes/style.css" />
<LINK type="text/css" rel="stylesheet" href="includes/addpet.css" />
<LINK type="text/css" rel="stylesheet" href="includes/imgareaselect-default.css" />
</HEAD>
<BODY>
<DIV class='newpostform'>    
    <FORM id="pet_add" method="post">
        <DIV id="header">Choose Tags</DIV><DIV id="content">
            <DIV id="tag_category"><?php display_tag_cat('species'); display_tagcloud('species'); ?></DIV>
        </DIV>
        <DIV id="header">Enter Email Address</DIV><DIV id="content"><INPUT type="text" class='newText' id='email' title="Type in your email address" name="email" /></DIV>
        <DIV id="header">Upload Photo</DIV>
        <DIV id='photobox'>
            <IMG id='thumb' src=''/> <BR />
            Click and drag on the photo to select the area you wish to use
        </DIV>
        <DIV id="content"><BUTTON type="file" id="imageUpload">select file to upload</BUTTON></DIV>
        <DIV id='username'>You're not supposed to see this, so leave it alone: <INPUT type="text" name="username" value="" /></DIV>
        <INPUT type="hidden" id="sub_tags" name="sub_tags" value="" />
        <INPUT type="hidden" id="photo_name" name="photo_name" value="0" />
        <BUTTON type="button" class='pet_add_submit' name="pet_add_submit" value="Submit">Submit</BUTTON>
    </FORM>
</DIV>
<SCRIPT type="text/javascript" src="includes/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/ajaxupload.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/jquery.imgareaselect.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/toolshed.js"></SCRIPT>
<SCRIPT type="text/javascript" src="includes/addpet.js"></SCRIPT>
</BODY></HTML>