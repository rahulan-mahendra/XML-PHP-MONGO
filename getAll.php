<?php
require 'collect.php';
$news = $collection->find([]);

foreach($news as $new) {
    echo "<tr>";
    echo "<td>".$new->title."</td>";
    echo "<td>".$new->description."</td>";
    echo "<td>".$new->from."</td>";
    if($new->link != null){
    $link = trim($new->link);
    
    echo "<td><a href='$link' target='_blank' class='link-primary'>Link to the content...</a></td>";
    
    echo "<td>".$new->pubDate."</td>";
    }
    echo "<td>";
    echo "<a href='edit.php?id=".$new->_id."' class='btn btn-warning me-2'>Edit</a>";
    echo "<a href='delete.php?id=".$new->_id."' class='btn btn-danger'>Delete</a>";
    echo "</td>";
    echo "</tr>";
};
?>