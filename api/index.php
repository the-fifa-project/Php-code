<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 10-5-2019
 * Time: 12:01
 */

require '../includes/config.php';
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$api = $query->fetchAll(2); //PDO::FETCH_ASSOC == 2

header('Content-Type: application/json');
$json = json_encode($api);

echo $json;