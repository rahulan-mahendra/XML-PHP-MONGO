<?php


session_start();
require 'collect.php';


$collection->deleteOne(['_id' => new MongoDB\BSON\ObjectID($_GET['id'])]);


$_SESSION['success'] = "News Deleted";
$_SESSION['color'] = "danger";
header("Location: index.php");


?>