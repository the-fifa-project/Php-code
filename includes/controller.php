<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 16-4-2019
 * Time: 12:53
 */

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' )
{
    header("location: ..//index.php");
    exit;
}

if ($_POST['type'] === 'register')
{
    $firstName = htmlentities($_POST['firstname']);
    $middleName = htmlentities($_POST['middlename']);
    $lastName = htmlentities($_POST['lastname']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);

    // check of it is empty


}