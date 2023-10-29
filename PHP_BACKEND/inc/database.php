<?php
$lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$envVariabes = [];
foreach($lines as $line){
list($key, $value) = explode('=', $line);
$envVariables[$key] = $value;
}
// Create connection

$servername = $envVariables['servername'];
$database = $envVariables['database'];
$password = $envVariables['password'];
$username = $envVariables['username'];
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}


?>
