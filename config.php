<?php
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "muusikapoodartur"; 

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Ühenduse loomine ebaõnnestus: " . $conn->connect_error);
}
?>
