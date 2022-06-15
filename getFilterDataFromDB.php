<?php
$source = $_GET["source"];
$from = $_GET['from'];
$to = $_GET['to'];

require_once __DIR__ . "/vendor/autoload.php";

    $collection = (new MongoDB\Client)->cricket->news;

    $news = $collection->find([
        'from' => $source,
        'pubDate' => array('$gte' => $from, '$lte' => $to),
    ]);
    
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