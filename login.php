<?php
/**
 * Created by PhpStorm.
 * User: GekkeGlenn
 * Date: 16-4-2019
 * Time: 12:01
 */

require 'header.php';

//add here a query
?>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/normalize.css">
    <main>
        <div class="main">
        <div class="login">
        <h2>Login</h2>
        <form action="includes/controller.php" method="post">
            <input type="hidden" name="type" value="login">
            <p>Email:</p> <input type="email" name="email" required>
            <p>Password:</p> <input type="password" name="password" required>
            <p>Already have an account? <a href="../Php-code/register.php">Register now!</a></p>
            <input type="submit" name="submit">
        </form>
        </div>
        <div class="background">
            <img src="img/Background_image.jpg" alt="">
        </div>
        </div>
    </main>

<?php

require 'footer.php';