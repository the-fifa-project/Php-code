<?php
  require '../includes/config.php';
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../css/bootstrap.css">

  <title>Fifa Project | dashboard</title>
  <style>
  header {
    z-index: 1000000;
  }
</style>
</head>

<body>
  <header class="col-12 bg-info">
    <div class="container-fluid d-flex justify-content-between ">
      <div class="brand">
        <h1 class="h6 text-white m-0 p-1"><a href="../index.php" class="text-white">Dashboard | THE FIFA PROJECT</a></h1>
      </div>
      
      <div class="dropdown login">
        <p class="h6 text-white m-0 p-1 dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;"><?=$_SESSION['username']?></p>     
        <div class="dropdown-menu dropdown-menu-right py-0">
          <a class="dropdown-item" href="#">Account</a>
          <a class="dropdown-item" href="#">Download</a>
          <div class="dropdown-divider my-0"></div>
          <a class="dropdown-item" href="../includes/logout.php">Uitloggen</a>
        </div>
      </div>
    </div>
  </header>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2"></div>
        <main class="col">