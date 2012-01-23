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
function display_tagcloud($linkid) 
{
    $result = mysql_query("SELECT tags FROM postings");
    
    $tags = array();

    while($row = mysql_fetch_array($result)) {
        $tags = array_merge($tags, explode(" ", $row['tags']));
    }

    $tags = array_unique_compact($tags);

    for($i=0;$i<count($tags);$i++) {
        echo "<A href='?tags=".$tags[$i]."'>".$tags[$i]."</A> ";
    }
}

// print $offset postings starting from $start using the mysql connection $dbconnection, filtering by $species and $tags if needed
// returns the next offset based on $offset and $amount
function display_postings($species, $tags, $offset, $amount, $dbconnection) 
{

    $sql1 = "SELECT * FROM postings ";
    $sql_tags = "WHERE tags LIKE '% ".$tags." %' OR tags LIKE '".$tags ."%' OR tags LIKE '% ".$tags."' OR tags = '".$tags."' ";
    $sql2 = "ORDER BY daterefreshed DESC LIMIT ".$offset.",".$amount;

    if(!$offset)
        $offset = 0;

    if(!$tags)
        $sql = $sql1.$sql2;
    else
        $sql = $sql1.$sql_tags.$sql2;

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

    return $offset + $amount;
}
?>