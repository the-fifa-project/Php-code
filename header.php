<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 16-4-2019
 * Time: 12:05
 */

require 'includes/config.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>The Fifa Project</title>

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/normalize.css">
</head>
<body>
    <header>
        <div class="logo">
            FIFA PROJECT
        </div>
        <div class="nav">
        <a href="index.php">home</a>
        <a href="teams.php">teams</a>
        <a href="login.php">login</a>
        <a href="register.php">register</a>
        </div>
        <div class="username">
            <?php
                if(isset($_SESSION['id']) || isset($_SESSION['username']) || isset($_SESSION['admin']))
                {
                    echo "<form action=\"includes/controller.php\" method=\"post\">
                <input type=\"hidden\" name=\"type\" value=\"logout\">
                <input type=\"submit\" name=\"submit\" value=\"Logout\">
            </form>";
                }
            ?>

        </div>
    </header>