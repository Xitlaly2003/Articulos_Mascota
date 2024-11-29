<?php
session_start();

// Verificar si el usuario tiene el rol adecuado
if (empty($_SESSION['rol']) || $_SESSION['rol'] !== 2) {
    header("Location: home.php");
    exit();
}

// Comprobar si se envió el formulario y los datos necesarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['idarticulo']) && !empty($_POST['cantidad'])) {
    $idArticulo = filter_var($_POST['idarticulo'], FILTER_VALIDATE_INT);
    $cantidad = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);

    // Validar que los datos sean correctos
    if (!$idArticulo || !$cantidad || $cantidad <= 0) {
        die("Error: Datos inválidos.");
    }

    // Conectar a la base de datos
    require_once '../../config/database.php';

    // Consultar información del artículo
    $consulta = $conn->prepare("SELECT * FROM articulo WHERE idarticulo = ? AND estado = 1");
    $consulta->bind_param("i", $idArticulo);
    $consulta->execute();
    $articulo = $consulta->get_result()->fetch_assoc();

    if (!$articulo || $cantidad > $articulo['stock']) {
        die("Error: Artículo no disponible o cantidad excede el stock.");
    }

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Agregar o actualizar el artículo en el carrito
    if (array_key_exists($idArticulo, $_SESSION['carrito'])) {
        $_SESSION['carrito'][$idArticulo]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$idArticulo] = [
            'nombre' => $articulo['nombre'],
            'precio_venta' => $articulo['precio_venta'],
            'cantidad' => $cantidad,
        ];
    }

    // Redirigir al catálogo
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
