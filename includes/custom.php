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

function display_tag_category($category) {

    if ($category == NULL | $category == '')
        $sql = "SELECT tag FROM tags WHERE category IS NULL AND approved=1 ORDER BY tag ASC";
    else
        $sql = "SELECT tag FROM tags WHERE category='$category' AND approved=1 ORDER BY tag ASC";

    $result = DEBASER::select($sql);
    if(count($result)==0){
        echo "<SPAN id='greyed'>No tags found for category </SPAN>";
        return;
    }
    
    foreach ($result as $row) {
        $tag = $row['tag'];
        $sql_tagcount = "SELECT COUNT(*) FROM postings WHERE (tags LIKE '$tag' OR tags LIKE '%$tag%' OR tags LIKE '%$tag' OR tags LIKE '$tag%')";
        $result_tagcount = DEBASER::select($sql_tagcount);
        $actual_tagcount = $result_tagcount->fetchColumn();
        echo "<SPAN class='tag'>".$row['tag']." </SPAN> <SPAN id='greyed'>($actual_tagcount)</SPAN> ";
    }
}

function display_tag_pending() {
    
    $sql = "SELECT tag FROM tags WHERE approved=0";
    $result = DEBASER::select($sql);
    if(count($result)==0){
        echo "<SPAN id='greyed'>No tags pending </SPAN>";
        return;
    }
    foreach ($result as $row)
        echo "<SPAN class='tag'>".$row['tag']."</SPAN> ";
}

// $exclude is a string name of a category you don't want the cloud to include
function display_tagcloud_js($exclude) {
    $result = DEBASER::select("SELECT tag FROM tags WHERE category != '$exclude' OR category IS NULL"); //mysql filters NULL even if it doesn't match the query
    foreach ($result as $row)
        echo "<A class='tag' href='#".$row['tag']."'>".$row['tag']."</A> ";
}

function delete_posting() {
    
}
?>