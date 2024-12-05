<?php
$servername = "localhost";
$username = "damian";
$password = "damian";
$dbname = "pokedex";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Bienvenido a la POKEDEX!";
?>
