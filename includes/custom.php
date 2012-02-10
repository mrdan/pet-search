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

function display_tagcloud_js() {
    $result = DEBASER::select("SELECT tag FROM tags");
    foreach ($result as $row)
        echo "<A class='tag' href='#".$row['tag']."'>".$row['tag']."</A> ";
}

function get_postings_data($tags, $offset, $amount){

    $sql1 = "SELECT * FROM postings ";    
    $sql2 = "ORDER BY daterefreshed DESC LIMIT ".$offset.",".$amount;

    if(!$offset)
        $offset = 0;
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

    $result = DEBASER::select($sql);
    // jquery error plz
    $rows = Array();
    foreach ($result as $r) {
        $rows[] = $r;
    }
    echo json_encode($rows);

    return $offset + $amount;    
}

function delete_posting() {
    
}
?>