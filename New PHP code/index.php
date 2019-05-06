<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 15-4-2019
 * Time: 09:46
 */

?>

<head>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

<header>

</header>

<main>

    <div class="Football-images-Top">
        <img src="img/Ball.png" alt="Ball" width="100" height="100">
        <img src="img/Goal.png" alt="Goal" width="100" height="100">
    </div>

    <h1>Project FIFA</h1>

    <div class="Register-and-Login">

        <div class="Register-section">

            <h2>Register</h2>

            <form action="registerController.php" method="post">
                <input type="hidden" name="type" value="register">

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <input type="submit" name="btnRegister" value="Register" class="btn">

            </form>
        </div>

        <div class="Login-section">

            <h2>Login</h2>

            <form action="loginController.php" method="post">
                <input type="hidden" name="type" value="login">

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <input type="submit" name="btnLogin" value="Login" class="btn">

            </form>
        </div>

    </div>

    <div class="Table-info">
        <br>
        <table>
            <tr>
                <th>Id</th>
                <th>Team-Name</th>
                <th>Players</th>
            </tr>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "fifa-teams");

            $sql = "SELECT id, name, players from teams";
            $result = $conn-> query($sql);

            if ($result -> num_rows > 0) {
                while ($row = $result-> fetch_assoc()) {
                    echo "<tr><td>". $row["id"] ."</td><td>". $row["name"] ."</td><td>". $row["players"] ."</td></tr>";
                }
                echo "</table>";
            }

            $conn-> close();
            ?>
        </table>
    </div>

    <div class="Football-images-Bottom">
        <img src="img/Penalty Cards.png" alt="Penalty Cards" width="100" height="100">
        <img src="img/Stadium.png" alt="Stadium" width="100" height="100">
    </div>

        <?php
            include('config.php');

            if(isset($_POST['btnRegister'])){
                $email = $_POST['email'];
                $password = $_POST['password'];

                $stm = $con->prepare("SELECT * FROM users WHERE email=?");
                $stm->execute([$email]);
                $user = $stm->fetch();
                if($user){
                    echo "<script type='text/javascript'>";
                    echo "alert('This email is already in use!');";
                    echo "</script>";
                } else {
                    $query = "INSERT INTO users (email, password, admin) VALUES ('$email', '$password', '0')";
                    $stm = $con->prepare($query);
                    $stm->execute();
                }
            }
        ?>

</main>

<footer>

</footer>

</body>