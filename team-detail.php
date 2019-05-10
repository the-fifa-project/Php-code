<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 9-5-2019
 * Time: 11:17
 */

require 'header.php';

$id = $_GET['id'];

if (!isset($id))
{
    header("location: index.php");
}

$sql = "SELECT 
            `team-players`.firstname as first, 
            `team-players`.middelname as middle, 
            `team-players`.lastname as last, 
            teams.name as team FROM `team-players`
            INNER JOIN teams ON `team-players`.team = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => $id
]);
$teamPlayers = $prepare->fetchAll(2);
?>


<main>
    <div class="container">
        <h2>Spelers</h2>
        <div class="players">
            <table>
                <tr>
                    <td>Voornaam:</td>
                    <td>middelnaam:</td>
                    <td>Achternaam:</td>
                </tr>
                <?php
                    foreach ($teamPlayers as $player)
                    {
                        echo "<tr>";
                        echo "<td>{$player['first']}</td><td>{$player['middle']}</td><td>{$player['last']}</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <div class="options">


            <?php
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === $_SESSION['id'])
            {
                echo  "<form action=\"includes/controller.php\" method=\"post\">
                            <input type=\"hidden\" name=\"type\" value=\"deleteteam\">
                            <input type=\"hidden\" name=\"teamid\" value=\"$id\">
                            <input type=\"submit\" name=\"submit\" value=\"Delete\">
                            </form>";
            }
            ?>
        </div>
    </div>
</main>

<?php
require 'footer.php';