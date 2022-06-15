<?php
session_start();
require 'collect.php';

$collection = (new MongoDB\Client)->cricket->news;
$result = $collection->drop();

$_SESSION['success'] = "Deleted All News";
$_SESSION['color'] = "danger";
header("Location: index.php");


?>