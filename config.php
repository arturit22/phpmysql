<?php
// Andmebaasiühenduse konfiguratsioon
$host = 'localhost'; // andmebaasi host
$username = 'arturit22'; // andmebaasi kasutajanimi
$password = 'Passw0rd'; // andmebaasi parool
$database = 'muusikapoodartur'; // andmebaasi nimi

// Ühenduse loomine andmebaasiga
$conn = new mysqli($host, $username, $password, $database);

// Kontrollime ühenduse olemasolu
if ($conn->connect_error) {
    die("Ühenduse loomine ebaõnnestus: " . $conn->connect_error);
}
?>
