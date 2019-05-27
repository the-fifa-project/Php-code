<?php
require 'config.php';
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 21-5-2019
 * Time: 08:53
 */
if(isset($_SESSION['id']))
{
    session_destroy();

    $msg = "Logged Out";
    header("location: ../index.php?msg=$msg");
    exit;
}
else
{
    header("location: ../login.php");
    exit;
}