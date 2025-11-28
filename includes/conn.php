<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "mysql";
$port = 3307;

$db = new mysqli($server, $username, $password, $database, $port);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
