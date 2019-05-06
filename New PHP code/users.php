<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16-4-2019
 * Time: 09:26
 */
?>

<head>
    <link rel="stylesheet" href="css/users.css">
</head>

<body>

<header>

</header>

<main>

    <div class="Football-images-Top">
        <img src="img/Ball.png" alt="Ball" width="100" height="100">
        <img src="img/Goal.png" alt="Goal" width="100" height="100">
    </div>

    <h1>Users and Teams Page</h1>

    <div class="Users-and-Teams">

        <div class="Register-Team">
            <form action="teamcontroller.php" method="post">

                <p><label for="name">Team Name:</label>
                    <input type="text" name="name" id="name"></p>

                <p><label for="players">Players:</label>
                    <input type="text" name="players" id="players"></p>

                <input type="submit" value="Submit">
            </form>
        </div>

        <div class="Register-User">

            <form action="teamcontroller.php" method="post">

                <p><label for="name">Team Name:</label>
                    <input type="text" name="name" id="name"></p>

                <p><label for="players">Players:</label>
                    <input type="text" name="players" id="players"></p>

                <input type="submit" value="Submit">
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

</main>

<footer>

</footer>

</body>

