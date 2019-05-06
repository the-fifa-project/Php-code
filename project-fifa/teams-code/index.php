<?php
require 'config.php';
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
var_dump($teams);
$body = json_decode(file_get_contents('php://input'), true);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <a href="create.php">Team aanmaken</a>
</body>
</html>
