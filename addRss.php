
<?php

require 'vendor/autoload.php';
 
$collection = (new MongoDB\Client)->cricket->news;

$url = 'https://www.espncricinfo.com/rss/content/story/feeds/8.xml';

$object = new DOMDocument();

$object->load($url);

$content = $object->getElementsByTagName("item");

foreach($content as $row){
    require 'vendor/autoload.php'; 
    $collection = (new MongoDB\Client)->cricket->news;
    $myDateTime = DateTime::createFromFormat('D, j M Y H:i:s', $row->getElementsByTagName("pubDate")->item(0)->nodeValue);
    $newDateString = $myDateTime->format('d/m/Y');
    $result = $collection->insertOne( [ 'title' => $row->getElementsByTagName("title")->item(0)->nodeValue , 'description' => $row->getElementsByTagName("description")->item(0)->nodeValue, 'link' => $row->getElementsByTagName("link")->item(0)->nodeValue, 'from' => 'rss-feed','pubDate' =>  $newDateString ] );
    header("Location: index.php"); 
}
?>