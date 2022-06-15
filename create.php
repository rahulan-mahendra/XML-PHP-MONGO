<?php
session_start();
if(isset($_POST['submit'])){
   require 'collect.php';
   $insertOneResult = $collection->insertOne([
       'title' => $_POST['title'],
       'description' => $_POST['description'],
       'link' => $_POST['link'],
       'from' => 'system',
       'pubDate' => date('d/m/Y')
   ]);
   $_SESSION['success'] = "News Added";
   $_SESSION['color'] = "success";
   header("Location: index.php");
}
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
   <h1 class="text-center">Add News</h1>
    <form method="POST">
      <div class="mb-3 mt-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" id="title" placeholder="Enter title" name="title">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea type="text" class="form-control" id="description" placeholder="Enter description" name="description"></textarea>
      </div>
      <div class="mb-3 mt-3">
        <label for="link" class="form-label">Link:</label>
        <input type="url" class="form-control" id="link" placeholder="Enter link" name="link">
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>

</body>
</html>