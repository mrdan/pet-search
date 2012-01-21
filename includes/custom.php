<?php
// remove duplicate tags from an array
function array_unique_compact($a) {
  $tmparr = array_unique($a);
  $i=0;
  foreach ($tmparr as $v) {
    $newarr[$i] = $v;
    $i++;
  }
  return $newarr;
}

// print all tags from postings table to the page
function output_all_tags($DBname,$linkid) {
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

// print all the postings to the page
function print_postings($DBname, $linkid, $repeat) {
    mysql_select_db($DBname, $linkid);
    
    for($i = 0; $i < $repeat; $i++) {
        $result = mysql_query("SELECT * FROM postings");    
        while($row = mysql_fetch_array($result)) {
            echo "<DIV class='posting'>";
                echo "<DIV class='photo'><IMG src='' /></DIV>";
                echo "<A href=''>".$row['email']."</A>, ".$row['dateadded'].", ".$row['refreshed'];
//              echo "<SPAN class='tags'>".$row['tags']."</SPAN>";
            echo "</DIV>";
        }
    }
}
?>