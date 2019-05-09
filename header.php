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
</head>
<body>
    <header>
        <a href="index.php">home</a>
        <a href="teams.php">teams</a>
        <a href="login.php">login</a>
        <a href="register.php">register</a>
        <div>
            <?php
                if(isset($_SESSION['id']) && isset($_SESSION['username']))
                {
                    echo $_SESSION['username'];
                }
            ?>
        </div>
    </header>