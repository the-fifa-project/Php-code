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

    <main>
        <form action="includes/controller.php" method="post">
            <input type="hidden" name="type" value="register">
            <input type="text" name="firstname" required>
            <input type="text" name="middlename">
            <input type="text" name="lastname" required>
            <input type="email" name="email" required>
            <input type="password" name="password" required>
            <input type="submit" name="submit" value="register">
        </form>
    </main>

<?php

require 'footer.php';