<?php
require 'config.php';
if ($_POST['type'] == 'POST')
{
    $match_time  = $_POST['match_time'];
    $half_time  = $_POST['half_time'];
    $break_time = $_POST['break_time'];

    $sql = "INSERT INTO time (match_time,half_time,break_time)
        VALUES (:match_time,:half_time,:break_time)";

    $prepare = $db->prepare($sql);
    $prepare->execute
    ([
        ':match_time' => $match_time,
        ':half_time'  => $half_time,
        ':break_time' => $break_time
    ]);
    header('Location: index.php');
}
?>

