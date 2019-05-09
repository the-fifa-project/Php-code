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
    header("location: teams.php");
}

/*
 * SELECT teams.id as teamid, `team-players`.id as teamplayerid FROM `team-players`
INNER JOIN `teams` ON `team-players`.team = teams.id

 */

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

echo "<table>";
foreach ($teamPlayers as $player)
{
    echo "<tr>";
    echo "<td>{$player['first']}</td><td>{$player['middle']}</td><td>{$player['last']}</td>";
    echo "</tr>";
}
echo "</table>";
?>