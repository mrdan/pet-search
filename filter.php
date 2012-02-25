<?php require('includes/db.php'); ?>
<?php

function get_postings_data($tags){

    $sql1 = "SELECT * FROM postings ";    
    $sql2 = "ORDER BY daterefreshed DESC";

    if(!$tags)
        $sql = $sql1.$sql2;
    else
    {
        $sql_tags1 = "WHERE ";
        for ($i=0; $i < count($tags); $i++) { 
            $sql_tags2 = "(tags LIKE '% ".$tags[$i]." %' OR tags LIKE '".$tags[$i] ." %' OR tags LIKE '% ".$tags[$i]."' OR tags = '".$tags[$i]."') ";
            if($i < (count($tags) - 1))
                $sql_tags2 = $sql_tags2."AND ";
            $sql_tags1 = $sql_tags1.$sql_tags2;
        }
        $sql = $sql1.$sql_tags1.$sql2;
    }

    $result = DEBASER::select($sql); //TODO: check $result
    // jquery error plz
    return $result;
}

function get_post_data($id) {
    $sql = "SELECT * FROM postings WHERE id=$id LIMIT 1";
    $result = DEBASER::select($sql); //TODO: check $result
    return $result;
}

// check our post
$id = "0";
$amount = 21;
$perma = "0";
$tags = Array();
$output = Array();

// we only want one post cause it's a permalink
if(isset($_POST['perma'])) {
    $perma = $_POST['perma'];
    $data = get_post_data($perma);
    $output[] = $data[0];

    $final = json_encode($output);
    echo $final;

    // close connection
    DEBASER::disconnect();
    return;
}

// handles everything else, even if tags is empty
if(isset($_POST['tags']))
	$tags = $_POST['tags'];

if(isset($_POST['id']))
	$id = $_POST['id'];
//display_postings($tags, $amount);
$data = get_postings_data($tags);

//filter it, we want only the rows after $id (unless $id == 0, then we want it aaaall)
$counter = 0;
$havefoundid = false;

if (strcmp($id,"0") == 0)
	$havefoundid = true;
foreach ($data as $row) {
	if(strcmp($row['id'], $id) == 0) {
		$havefoundid = true;
		continue; //skip the matching entry
	}
	if($havefoundid == true) {
		//start using rows
		$output[] = $row;
		$counter++;
	}
	if($counter == $amount)
		break;
}


$final = json_encode($output);
echo $final;

// close connection
DEBASER::disconnect();



?>