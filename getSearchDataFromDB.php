<?php
$searchdata = $_GET["q"];
require_once __DIR__ . "/vendor/autoload.php";

    $collection = (new MongoDB\Client)->cricket->news;

    
    $result = $collection->find(array(
        '$or' => array(
            array('title' => new \MongoDB\BSON\Regex(preg_quote($searchdata), 'i')),
            array('description' => new \MongoDB\BSON\Regex(preg_quote($searchdata), 'i')),
        )
    ));

    foreach($result as $new){
        if(empty($new)){
            echo "No";
        }else{
            echo '<div class="card mb-4">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$new->title.'</h5>';
            echo '<p class="card-text">'.$new->description.'</p>';
            echo '</div>';
            echo '<div class="card-body">';
            if($new->link != null){
            $link = trim($new->link);
            echo '<a href="'.$link.'" target="_blank" class="card-link">News Link</a>';
            }
            echo '</div>';
            echo "</div>";     
        }   
    }
    
?>