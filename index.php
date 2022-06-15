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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

  <div class="d-flex justify-content-between mb-2 mt-2">
    <a href="create.php" class="btn btn-primary">Add News</a>
    <a href="addRss.php" class="btn btn-success">Add Rss Feed</a>  
    <a href="deleteAll.php" class="btn btn-danger">Delete All</a>
  </div>

  <div class="container p-4">
    <div class="row">
      <div class="col-md-4">        
        <label for="search">Date Range</label>
        <input class="form-control datepicker me-2" id="datepicker" aria-label="Search" name="daterange" >
      </div>
      <div class="col-md-4">
        <label for="source">Source</label>
        <select class="form-control" id="source">
                <option value="rss-feed">rss-feed</option>
                <option value="system">system</option>
        </select>
      </div>
      <div class="col-md-4 mt-2 p-3 justify-content-between">
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
          <button type="button" class="btn btn-outline-success" onclick="getDataFromDb()">Filter Resultest</button>
          <button type="button" class="btn btn-outline-danger" onclick="removeFilter()">Remove Filters</button>
          <button type="button" class="btn btn-outline-warning" id="export" onclick="exportXML()">Export XML</button>
        </div>
      </div>
    </div>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col" style="width: 20%">Title</th>
        <th scope="col" style="width: 20%">Description</th>
        <th scope="col" style="width: 20%">News Source</th>
        <th scope="col" style="width: 20%">Link to the content</th>
        <th scope="col" style="width: 20%">Published Date</th>
        <th scope="col" style="width: 20%">Action</th>
      </tr>
    </thead>
    <tbody id="printResults">
    </tbody>
  </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script>
$(document).ready(function() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("printResults").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "getAll.php", true);
  xhttp.send();
});

function removeFilter(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("printResults").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "getAll.php", true);
  xhttp.send();
};

function exportXML(){
  [startDate, endDate] = $('.datepicker').val().split(' - ');
  var source = $('#source').find(":selected").text();
  window.open(
    "generateXML.php?source="+ source+"&from="+startDate+"&to="+endDate,
    '_blank'
  )
}

$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    locale: {
      format: 'DD/MM/YYYY'
    }
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('DD/MM/YYYY') + ' to ' + end.format('DD/MM/YYYY'));
  });
});

function getDataFromDb() {
  [startDate, endDate] = $('.datepicker').val().split(' - ');
  var source = $('#source').find(":selected").text();
  console.log(source);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("printResults").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "getFilterDataFromDB.php?source="+ source+"&from="+startDate+"&to="+endDate, true);
  xhttp.send();
}
</script>
</body>
</html>