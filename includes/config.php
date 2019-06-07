<?php
/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 16-4-2019
 * Time: 12:08
 */

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// here comes the database connection.
$dbHost = "localhost";
// $dbName = "the-fifa-project";
// $dbUser = "root";
// $dbPass = "";
$dbName = "glennea309_fifaProject";
$dbUser = "glennea309_glennea309";
$dbPass = "sPpDEZokJ";

// here we try to connect to the database if it can't connect. you get a error messega.
try {
    $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
 catch (PDOException $e) 
 {
    echo "<div class='note' style='background: #fedde9; padding: 10px; margin: 10px; font-family: courier'>
                <h4>Error!</h4>
                <p>
                    there is no connection with the database, contact a developer!
                </p>
              </div>";
    die($e->getMessage());
 }

// and a session_start for checking if there is an user thats logged in

session_start();


