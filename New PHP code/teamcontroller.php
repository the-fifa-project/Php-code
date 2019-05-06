<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "fifa-teams");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security
$name = mysqli_real_escape_string($link, $_REQUEST['email']);
$players = mysqli_real_escape_string($link, $_REQUEST['password']);

// Attempt insert query execution
$sql = "INSERT INTO users (username, password) VALUES ('$email','$password')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>