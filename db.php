<?php
$status="";

if(!isset($_SESSION)) { session_start(); };

$servername = "localhost";
$username = "root";
$password = "";
$database = "isp";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>