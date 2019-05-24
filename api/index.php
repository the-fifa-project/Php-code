<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 10-5-2019
 * Time: 12:01
 */

require '../includes/config.php';

if (isset($_GET['apikey']) && $_GET['apikey'] === "$2VAo@5JGt8%")
{
    $sql = "SELECT * FROM teams";
    $query = $db->query($sql);
    $api = $query->fetchAll(2); //PDO::FETCH_ASSOC == 2

    header('Content-Type: application/json');
    $json = json_encode($api);

    echo $json;
}
else if (isset($_GET['apikey']) && $_GET['apikey'] === "Rz7^8p2%4VYk")
{
    $sql = "SELECT * FROM `matches`";
    $query = $db->query($sql);
    $api = $query->fetchAll(2); //PDO::FETCH_ASSOC == 2

    header('Content-Type: application/json');
    $json = json_encode($api);

    echo $json;
}
else
{
    header("location: ../index.php");
    exit;
}