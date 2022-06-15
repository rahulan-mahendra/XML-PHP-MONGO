<?php
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>Sample RSS feed</title>';
$rssfeed .= '<link>http://www.test.com</link>';
$rssfeed .= '<description>Sample RSS Feed</description>';
$rssfeed .= '<language>en-us</language>';

$source = $_GET["source"];
$from = $_GET['from'];
$to = $_GET['to'];

require 'vendor/autoload.php';
 
$collection = (new MongoDB\Client)->cricket->news;
$news = $collection->find([
  'from' => $source,
  'pubDate' => array('$gte' => $from, '$lte' => $to),
]);

foreach($news as $new) {
  $rssfeed .= '<item><br>';
  $rssfeed .= '<title>' . $new["title"] . '</title>';
  $rssfeed .= '<description>' . $new["description"] . '</description>';
  $rssfeed .= '<link>' . $new["link"] . '</link>';
  $rssfeed .= '<source>' . $new["from"] . '</source>';
  $rssfeed .= '<pubDate>' . $new["pubDate"] . '</pubDate>';
  $rssfeed .= '</item>';
};

$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;

// header("Location: index.php"); 

?>
