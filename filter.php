<?php @ require_once ('includes/custom.php'); ?>
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

// check our gets
$offset = 0;

if(isset($_POST['tags']))
	$tags = $_POST['tags'];
else
	$tags = Array();

//display_postings($tags, $offset, 25, $linkid);
get_postings_data($tags, 0, 25, $linkid);

// close connection
mysql_close($linkid);

?>