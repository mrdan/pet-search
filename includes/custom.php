<?php
// remove duplicate tags from an array
function array_unique_compact($a) 
{
  $tmparr = array_unique($a);
  $i=0;
  foreach ($tmparr as $v) {
    $newarr[$i] = $v;
    $i++;
  }
  return $newarr;
}

// print all tags from postings table to the page
function output_all_tags($DBname,$linkid) 
{
    mysql_select_db($DBname,$linkid);
    $result = mysql_query("SELECT * FROM postings");
    
    $tags = array();

    while($row = mysql_fetch_array($result)) {
        $tags = array_merge($tags, explode(" ", $row['tags']));
    }

    $tags = array_unique_compact($tags);

    for($i=0;$i<count($tags);$i++) {
        echo $tags[$i];
        if($i<count($tags)-1) echo ",\n";
    }
}

// print $offset postings starting from $start using the mysql connection $dbconnection
function display_postings($offset, $amount, $dbconnection) 
{
    $sql = "SELECT * FROM postings ORDER BY daterefreshed DESC LIMIT ".$offset.",".$amount;
    $result = mysql_query($sql,$dbconnection);
    if (!$result)
        die('Error in display_postings: ' . mysql_error());
    while($row = mysql_fetch_array($result)) 
    {
        echo "<DIV class='posting'>";
            echo "<DIV class='photo'><IMG src='' /></DIV>";
            echo "<P><A href=''>".$row['email']."</A>, ".$row['daterefreshed'].", ".$row['refreshed']."</P>";
            echo "<P>".$row['species'].": ".$row['tags']."</P>";
        echo "</DIV>";
    }

}
?>