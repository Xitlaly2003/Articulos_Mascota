<?php

$host = 'localhost';
$user = 'root';
$password = 'admin';
$db = 'integrador';

$conn = new mysqli($host, $user, $password, $db);

// Verificar si hubo error en la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Retornar la conexión
return $conn;
?>
