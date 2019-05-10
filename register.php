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
        <div class="register">
            <h2>Register</h2>
        <form action="includes/controller.php" method="post">
            <input type="hidden" name="type" value="register">
            <label for="firstname">Firstname:</label>
            <input type="text" name="firstname" required>
            <p>Middlename:</p> <input type="text" name="middlename">
            <p>Lastname</p> <input type="text" name="lastname" required>
            <p>Email:</p> <input type="email" name="email" required>
            <p>Password:</p> <input type="password" name="password" required>
            <p>Confirm password:</p> <input type="password" name="passwordconfirm" required>
            <p>Already have an account? <a href="../Php-code/login.php">Login here!</a></p>
            <input type="submit" name="submit" value="register">
        </form>
        </div>
    </main>

<?php
require 'footer.php';

?>