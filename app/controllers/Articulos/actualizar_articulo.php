<?php
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idarticulo = $_POST['idarticulo'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];

    // Consulta para actualizar el artículo
    $query = "
        UPDATE articulo 
        SET nombre = ?, precio_venta = ?, stock = ?, descripcion = ? 
        WHERE idarticulo = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdisi", $nombre, $precio, $stock, $descripcion, $idarticulo);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: ../../public/home.php?mensaje=Artículo actualizado con éxito");
    } else {
        echo "Error al actualizar artículo: " . $conn->error;
    }
    exit();
}
?>
