<?php
require_once __DIR__ . "/vendor/autoload.php";
$collection = (new MongoDB\Client)->cricket->news;
?>

<?php
   session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>News feed</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="header">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">XML-PHP-MONGODB</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="create.php" class="btn btn-primary">Add News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="search.php" class="btn btn-primary">Search News</a>
          </li>
      </div>
    </div>
  </nav>
  </div>

  <div class="container p-4">
    <div class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" id="search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit" onclick="getDataFromDb()">Search</button>
    </div>
  </div>
  <div id="searchResults">
    <?php
        require 'collect.php';
        $news = $collection->find([]);

        foreach($news as $new) {
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
        };
    ?>
  </div>
</div>
<script>
function getDataFromDb() {
  var data = document.getElementById('search').value;
  console.log(data);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("searchResults").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "getSearchDataFromDB.php?q="+ data, true);
  xhttp.send();
}
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>