<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 18-4-2019
 * Time: 11:04
 */

$link = mysqli_connect("localhost", "root", "", "fifa-teams");

if ($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    header('location: index.php');
    exit;
}

if ($_POST['type'] === 'register') {

    require 'config.php';
    require 'index.php';

    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

// Escape user inputs for security
    $username = mysqli_real_escape_string($link, $_REQUEST['email']);
    $password = mysqli_real_escape_string($link, $_REQUEST['password']);

// Attempt insert query execution
    $sql = "INSERT INTO users (username, password) VALUES ('$email','$password')";
    if(mysqli_query($link, $sql)){
        echo "Records added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

// Close connection
    mysqli_close($link);

    exit;
}

?>