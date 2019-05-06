<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15-4-2019
 * Time: 09:46
 */

?>

<head>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<header>

</header>

<main>

    <div class="Football-images-Top">
        <img src="img/Ball.png" alt="Ball" width="100" height="100">
        <img src="img/Goal.png" alt="Goal" width="100" height="100">
    </div>

    <h1>Admin Page</h1>

    <div class="Admin-section">

        <h2>Login</h2>

        <form action="admin.php" method="post">
            <input type="hidden" name="type" value="login">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <input type="submit" name="btnLogin" value="Login" class="btn">

        </form>
    </div>

    <div class="Football-images-Bottom">
        <img src="img/Penalty Cards.png" alt="Penalty Cards" width="100" height="100">
        <img src="img/Stadium.png" alt="Stadium" width="100" height="100">
    </div>

</main>

<footer>

</footer>

</body>