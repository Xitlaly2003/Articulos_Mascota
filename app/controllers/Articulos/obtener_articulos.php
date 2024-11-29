<?php
// Conexión a la base de datos
require_once __DIR__ . '/../../config/database.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

function obtenerArticulos($conn)
{
    $consulta = "
        SELECT a.idarticulo, a.nombre, a.codigo, a.precio_venta, a.stock, a.descripcion, c.nombre AS categoria
        FROM articulo a
        INNER JOIN categoria c ON a.idcategoria = c.idcategoria
        WHERE a.estado = 1
        ORDER BY a.codigo
    ";

    return $conn->query($consulta);
}
?>