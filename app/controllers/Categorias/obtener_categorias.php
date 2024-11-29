<?php
// Conexión a la base de datos
require_once __DIR__ . '/../../config/database.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

function obtenerCategorias($conn)
{
    $consulta = "SELECT * FROM categoria WHERE estado = 1";

    return $conn->query($consulta);
}
?>