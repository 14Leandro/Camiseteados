<?php
$host = "localhost";
$user = "root"; // Usuario por defecto en XAMPP
$pass = ""; // En XAMPP, la contraseña por defecto es vacía
$dbname = "camiseteados";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>