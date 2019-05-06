
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Record Form</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            color: #588c7e;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }
        th {
            background-color: #588c7e;
            color: white;
        }
        tr:nth-child(even) {background-color: #f2f2f2}
    </style>
</head>
<body>
<form action="teamcontroller.php" method="post">
    <p>
        <label for="name">Team Name:</label>
        <input type="text" name="name" id="name">
    </p>
    <p>
        <label for="players">Players:</label>
        <input type="text" name="players" id="players">
    </p>
    <input type="submit" value="Submit">
</form>
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
</body>

</html>